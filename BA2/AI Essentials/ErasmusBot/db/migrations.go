package db

import (
	"crypto/sha256"
	_ "embed"
	"encoding/hex"
	"fmt"
	"github.com/Fesaa/EHB/AI-Essentials/erasmusbot/config"
	"io"
	"log/slog"
	"os"
	"path/filepath"
	"regexp"
	"strings"
	"time"
)

//go:embed init.sql
var initSQL []byte

var FILE_REGEX = regexp.MustCompile("V(\\d*_\\d*_\\d*)__(.*).sql")

func (db *databaseImpl) doAll() error {
	_, err := db.db.Exec(string(initSQL))

	if err != nil {
		return err
	}

	dir, err := os.ReadDir(config.I().GetMigrationsPath())
	if err != nil {
		return err
	}

	for _, file := range dir {
		if file.IsDir() {
			continue
		}

		if !strings.HasSuffix(file.Name(), ".sql") {
			continue
		}

		if err := db.doMigration(file); err != nil {
			return err
		}
	}

	return nil
}

func checkSum(filePath string) (string, error) {
	file, err := os.Open(filePath)
	if err != nil {
		return "", err
	}
	hash := sha256.New()
	if _, err := io.Copy(hash, file); err != nil {
		slog.Error("Error hashing file", "file", file.Name(), "error", err)
		return "", err
	}
	checksum := hash.Sum(nil)
	return hex.EncodeToString(checksum), nil
}

func (db *databaseImpl) doMigration(file os.DirEntry) error {
	matches := FILE_REGEX.FindStringSubmatch(file.Name())
	if len(matches) != 3 {
		slog.Info("Skipping file with wrong format", "file", file.Name())
		return nil
	}
	version := matches[1]
	description := matches[2]

	maybeCheckSum := db.findMigrationChecksum(version)

	f, err := os.Open(filepath.Join(config.I().GetMigrationsPath(), file.Name()))
	if err != nil {
		return err
	}
	defer f.Close()
	checkSum, err := checkSum(filepath.Join(config.I().GetMigrationsPath(), file.Name()))
	if err != nil {
		return err
	}

	if maybeCheckSum != "" {
		if maybeCheckSum != checkSum {
			slog.Error("Checksum mismatch", "file", file.Name(), "version", version, "checksum", checkSum, "expected", maybeCheckSum)
			return fmt.Errorf("checksum mismatch for file %s", file.Name())
		}
		slog.Info("Skipping migration, already happened", "file", file.Name())
		return nil
	}

	data, err := io.ReadAll(f)
	if err != nil {
		return err
	}

	_, err = db.db.Exec(string(data))
	if err != nil {
		return err
	}
	err = db.insertMigration(version, description, checkSum, f.Name())
	if err != nil {
		return err
	}

	return nil
}

func (db *databaseImpl) findMigrationChecksum(version string) string {
	query := `SELECT checksum FROM migrations WHERE version = ?`

	var checksum string
	err := db.db.QueryRow(query, version).Scan(&checksum)
	if err != nil {
		return ""
	}

	return checksum
}

func (db *databaseImpl) insertMigration(version, desc, checkSum, fileName string) error {
	insertSQL := `INSERT INTO migrations (version, desc, checksum, time) VALUES (?, ?, ?, ?)`
	stmt, err := db.db.Prepare(insertSQL)
	if err != nil {
		slog.Error("Error preparing insert migration", "file", fileName, "error", err)
		return err
	}
	defer stmt.Close()

	currentTime := time.Now().Unix()
	_, err = stmt.Exec(version, desc, checkSum, currentTime)
	if err != nil {
		slog.Error("Error executing insert migration", "file", fileName, "error", err)
		return err
	}

	return nil
}
