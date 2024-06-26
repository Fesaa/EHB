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
	LogLevel       slog.Level      `yaml:"logLevel"`
	BaseUrl        string          `yaml:"base_url"`
	Debug          bool            `yaml:"debug"`
	DbURl          string          `yaml:"db_url"`
	MigrationsPath string          `yaml:"migrations_path"`
	Host           string          `yaml:"host"`
	Port           string          `yaml:"port"`
	Azure          azureConfigImpl `yaml:"azure"`
}

type azureConfigImpl struct {
	ApiKey          string `yaml:"api_key"`
	EndPoint        string `yaml:"endpoint"`
	DeploymentModel string `yaml:"deployment_model"`
	ApiVersion      string `yaml:"api_version"`
	EmbeddingsModel string `yaml:"embeddings_model"`
}

func (c *configImpl) GetLogLevel() slog.Level {
	return c.LogLevel
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

func (c *configImpl) GetHost() string {
	assert(c.Host != "")
	return c.Host
}

func (c *configImpl) GetPort() string {
	assert(c.Port != "")
	return c.Port
}

func (c *configImpl) GetAzure() AzureConfig {
	return &c.Azure
}

func (a *azureConfigImpl) GetApiKey() string {
	return a.ApiKey
}

func (a *azureConfigImpl) GetEndPoint() string {
	return a.EndPoint
}

func (a *azureConfigImpl) GetDeploymentModel() string {
	return a.DeploymentModel
}

func (a *azureConfigImpl) GetApiVersion() string {
	return a.ApiVersion
}

func (a *azureConfigImpl) GetEmbeddingsModels() string {
	return a.EmbeddingsModel
}
