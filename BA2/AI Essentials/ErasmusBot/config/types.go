package config

type Config interface {
	GetBaseUrl() string
	GetDebug() bool
	GetDbURL() string
	GetMigrationsPath() string

	GetHost() string
	GetPort() string

	GetAzure() AzureConfig
}

type AzureConfig interface {
	GetApiKey() string
	GetEndPoint() string
	GetDeploymentModel() string
	GetApiVersion() string
}
