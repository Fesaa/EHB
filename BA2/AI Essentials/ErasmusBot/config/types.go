package config

type Config interface {
	GetBaseUrl() string
	GetDebug() bool
	GetDbURL() string
	GetMigrationsPath() string
}
