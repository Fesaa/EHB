package bot

import (
	"context"
	"errors"
	"github.com/Azure/azure-sdk-for-go/sdk/ai/azopenai"
	"github.com/Azure/azure-sdk-for-go/sdk/azcore"
	"github.com/Fesaa/EHB/AI-Essentials/erasmusbot/config"
)

var i *erasmusBotImpl

func I() ErasmusBot {
	return i
}

type erasmusBotImpl struct {
	ctx    context.Context
	client *azopenai.Client

	apiKey          string
	endpoint        string
	deploymentModel string
	apiVersion      string
}

func (e *erasmusBotImpl) validate() error {
	if e.apiKey == "" {
		return errors.New("apiKey is required")
	}
	if e.endpoint == "" {
		return errors.New("endpoint is required")
	}
	if e.deploymentModel == "" {
		return errors.New("deploymentModel is required")
	}
	if e.apiVersion == "" {
		return errors.New("apiVersion is required")
	}
	return nil
}

func (e *erasmusBotImpl) SetCtx(ctx context.Context) {
	e.ctx = ctx
}

func Init() error {
	i = &erasmusBotImpl{
		ctx:             context.Background(),
		apiKey:          config.I().GetAzure().GetApiKey(),
		endpoint:        config.I().GetAzure().GetEndPoint(),
		deploymentModel: config.I().GetAzure().GetDeploymentModel(),
		apiVersion:      config.I().GetAzure().GetApiVersion(),
	}
	err := i.validate()
	if err != nil {
		return err
	}

	keyCredential := azcore.NewKeyCredential(i.apiKey)
	client, err := azopenai.NewClientWithKeyCredential(i.endpoint, keyCredential, nil)
	if err != nil {
		return err
	}
	i.client = client
	return nil
}
