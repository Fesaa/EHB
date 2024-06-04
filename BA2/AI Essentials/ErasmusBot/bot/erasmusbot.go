package bot

import (
	"context"
	"github.com/Fesaa/EHB/AI-Essentials/erasmusbot/models"
)

var i *erasmusBotImpl

func I() ErasmusBot {
	return i
}

type erasmusBotImpl struct {
	ctx context.Context

	apiKey          string
	endpoint        string
	deploymentModel string
	apiVersion      string
}

func (e *erasmusBotImpl) SetCtx(ctx context.Context) {
	e.ctx = ctx
}

func (e *erasmusBotImpl) GenerateResponse(msg string) (models.ChatMessage, error) {
	return models.ChatMessage{
		User: false,
		Text: msg + " responded by erasmusbot",
	}, nil
}

func Init() error {
	i = &erasmusBotImpl{}
	return nil
}
