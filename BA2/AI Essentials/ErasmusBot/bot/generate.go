package bot

import (
	"errors"
	"github.com/Azure/azure-sdk-for-go/sdk/ai/azopenai"
	"github.com/Azure/azure-sdk-for-go/sdk/azcore/to"
	"github.com/Fesaa/EHB/AI-Essentials/erasmusbot/models"
)

var default_query = []string{
	"Only respond with information given to you by the index, not your previous knowledge.",
	"If you don't know the answer, or can't find it in the indexes, respond by saying you don't know.",
}

func (e *erasmusBotImpl) GenerateResponse(msg string) (models.ChatMessage, error) {

	prompt := append(default_query, msg)
	resp, err := e.client.GetCompletions(e.ctx, azopenai.CompletionsOptions{
		Prompt:         prompt,
		MaxTokens:      to.Ptr(int32(1024)),
		DeploymentName: &e.deploymentModel,
	}, nil)
	if err != nil {
		return models.ChatMessage{}, err
	}

	if len(resp.Choices) == 0 {
		return models.ChatMessage{}, errors.New("no choices found")
	}

	var choice *azopenai.Choice = nil
	for _, c := range resp.Choices {
		if c.Text == nil {
			continue
		}
		choice = &c
		break
	}
	if choice == nil {
		return models.ChatMessage{}, errors.New("no choice found")
	}

	return models.ChatMessage{
		User: false,
		Text: *choice.Text,
	}, nil
}
