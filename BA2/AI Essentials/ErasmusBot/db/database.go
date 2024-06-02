package db

import (
	"database/sql"
	"github.com/Fesaa/EHB/AI-Essentials/erasmusbot/config"
	_ "github.com/mattn/go-sqlite3"
	"log/slog"
)

var i *databaseImpl

func I() Database {
	return i
}

type databaseImpl struct {
	db *sql.DB
}

func InitDatabase() error {
	slog.Info("Initializing database", "url", config.I().GetDbURL())
	db, err := sql.Open("sqlite3", config.I().GetDbURL())
	if err != nil {
		return err
	}

	i = &databaseImpl{db: db}

	err = i.doAll()
	if err != nil {
		slog.Error("Error running migrations database", "error", err)
		return err
	}

	return nil
}
