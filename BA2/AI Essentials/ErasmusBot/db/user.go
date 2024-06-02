package db

import (
	"crypto/rand"
	"database/sql"
	"encoding/base64"
	"encoding/hex"
	"errors"
	"golang.org/x/crypto/bcrypt"
	"log/slog"
)

func (db *databaseImpl) GetUserID(cookie string) (int, error) {
	var id int
	res := db.db.QueryRow("SELECT id FROM users WHERE cookie = ?", cookie)
	err := res.Scan(&id)
	return id, err
}

func (db *databaseImpl) Login(username string, password string) (bool, string) {
	var cookie string
	var savedInDatabase string
	row := db.db.QueryRow("SELECT cookie, password FROM users WHERE username = ?", username)
	err := row.Scan(&cookie, &savedInDatabase)
	if err != nil {
		if !errors.Is(err, sql.ErrNoRows) {
			slog.Info("An error occurred when trying to get cookie for user", username, "error", err)
			return false, ""
		}
	} else {
		savedPasswordHash, err := base64.StdEncoding.DecodeString(savedInDatabase)
		if err != nil {
			slog.Info("An error occurred when trying to decode cookie for user", username)
			return false, ""
		}
		err = bcrypt.CompareHashAndPassword(savedPasswordHash, []byte(password))
		if err != nil {
			slog.Info("Failed login attempt", "username", username, "error", err)
			return false, ""
		}
		return true, cookie
	}

	newHashedPassword, err := bcrypt.GenerateFromPassword([]byte(password), bcrypt.DefaultCost)
	if err != nil {
		slog.Error("Error hashing password", "error", err)
		return false, ""
	}

	newEncodedPassword := base64.StdEncoding.EncodeToString(newHashedPassword)
	cookie = generateSecureToken(25)
	_, err = db.db.Exec("INSERT INTO users (username, password, cookie) VALUES (?, ?, ?)", username, newEncodedPassword, cookie)
	if err != nil {
		slog.Info("An error occurred when trying to insert cookie for user", username, "error", err)
		return false, ""
	}
	return true, cookie
}

func generateSecureToken(length int) string {
	b := make([]byte, length)
	if _, err := rand.Read(b); err != nil {
		return ""
	}
	return hex.EncodeToString(b)
}
