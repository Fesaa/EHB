package api

import (
	"context"
)

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

func New() ErasmusBot {
	return &erasmusBotImpl{}
}
