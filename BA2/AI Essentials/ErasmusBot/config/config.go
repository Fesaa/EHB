package config

import (
	"gopkg.in/yaml.v3"
	"log/slog"
	"os"
)

var i *configImpl

func I() Config {
	return i
}

func LoadConfig(path string) error {
	slog.Info("Loading config", "path", path)
	data, err := os.ReadFile(path)
	if err != nil {
		return err
	}
	return yaml.Unmarshal(data, &i)
}

type configImpl struct {
	BaseUrl        string `yaml:"base_url"`
	Debug          bool   `yaml:"debug"`
	DbURl          string `yaml:"db_url"`
	MigrationsPath string `yaml:"migrations_path"`
}

func (c *configImpl) GetBaseUrl() string {
	return c.BaseUrl
}

func (c *configImpl) GetDebug() bool {
	return c.Debug
}

func (c *configImpl) GetDbURL() string {
	return c.DbURl
}

func (c *configImpl) GetMigrationsPath() string {
	return c.MigrationsPath
}
