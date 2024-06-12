package bot

import (
	"context"
	"github.com/Fesaa/EHB/AI-Essentials/erasmusbot/config"
	"github.com/tmc/langchaingo/llms/openai"
)

var i *erasmusBotImpl

func I() ErasmusBot {
	return i
}

type erasmusBotImpl struct {
	ctx    context.Context
	client *openai.LLM
}

func (e *erasmusBotImpl) SetCtx(ctx context.Context) {
	e.ctx = ctx
}

func Init() error {
	opts := []openai.Option{
		openai.WithAPIType(openai.APITypeAzure),
		openai.WithToken(config.I().GetAzure().GetApiKey()),
		openai.WithModel(config.I().GetAzure().GetDeploymentModel()),
		openai.WithEmbeddingModel(config.I().GetAzure().GetEmbeddingsModels()),
		openai.WithBaseURL(config.I().GetAzure().GetEndPoint()),
		openai.WithAPIVersion(config.I().GetAzure().GetApiVersion()),
	}
	llm, err := openai.New(opts...)
	if err != nil {
		return err
	}
	i = &erasmusBotImpl{
		ctx:    context.Background(),
		client: llm,
	}
	return nil
}
