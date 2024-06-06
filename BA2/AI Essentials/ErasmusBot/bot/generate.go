package bot

import (
	"errors"
	"github.com/Azure/azure-sdk-for-go/sdk/ai/azopenai"
	"github.com/Azure/azure-sdk-for-go/sdk/azcore/to"
	"github.com/Fesaa/EHB/AI-Essentials/erasmusbot/models"
)

var system_messages = []string{
	"Only respond with information given to you by the index, not your previous knowledge.",
	"If you don't know the answer, or can't find it in the indexes, respond by saying you don't know.",
}

func (e *erasmusBotImpl) GenerateResponse(msg string, pastMessages []models.ChatMessage) (models.ChatMessage, error) {
	history := conv(append(pastMessages, models.ChatMessage{
		User: true,
		Text: msg,
	}))

	resp, err := e.client.GetChatCompletions(e.ctx, azopenai.ChatCompletionsOptions{
		Messages:       history,
		MaxTokens:      to.Ptr(int32(1024)),
		DeploymentName: &e.deploymentModel,
	}, nil)
	if err != nil {
		return models.ChatMessage{}, err
	}

	if len(resp.Choices) == 0 {
		return models.ChatMessage{}, errors.New("no choices found")
	}

	var choice *string = nil
	for _, c := range resp.Choices {
		if c.Message.Content == nil {
			continue
		}
		choice = c.Message.Content
		break
	}
	if choice == nil {
		return models.ChatMessage{}, errors.New("no choice found")
	}

	return models.ChatMessage{
		User: false,
		Text: *choice,
	}, nil
}

func conv(msgs []models.ChatMessage) []azopenai.ChatRequestMessageClassification {
	out := make([]azopenai.ChatRequestMessageClassification, len(msgs)+len(system_messages))
	for index, systemMsg := range system_messages {
		out[index] = &azopenai.ChatRequestSystemMessage{
			Content: &systemMsg,
		}
	}
	for index, msg := range msgs {
		if msg.User {
			out[index+len(system_messages)] = &azopenai.ChatRequestUserMessage{
				Content: azopenai.NewChatRequestUserMessageContent(msg.Text),
			}
		} else {
			out[index+len(system_messages)] = &azopenai.ChatRequestAssistantMessage{
				Content: &msg.Text,
			}
		}
	}
	return out
}
