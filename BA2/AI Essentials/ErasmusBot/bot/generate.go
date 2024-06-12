package bot

import (
	"errors"
	"github.com/Fesaa/EHB/AI-Essentials/erasmusbot/models"
	"github.com/tmc/langchaingo/llms"
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

	resp, err := e.client.GenerateContent(e.ctx, history)
	if err != nil {
		return models.ChatMessage{}, err
	}

	if len(resp.Choices) == 0 {
		return models.ChatMessage{}, errors.New("no choices found")
	}

	return models.ChatMessage{
		User: false,
		Text: resp.Choices[0].Content,
	}, nil
}

func conv(msgs []models.ChatMessage) []llms.MessageContent {
	out := make([]llms.MessageContent, len(msgs)+len(system_messages))
	for index, systemMsg := range system_messages {
		out[index] = llms.MessageContent{
			Role: llms.ChatMessageTypeSystem,
			Parts: []llms.ContentPart{
				llms.TextPart(systemMsg),
			},
		}
	}
	for index, msg := range msgs {
		if msg.User {
			out[index+len(system_messages)] = llms.MessageContent{
				Parts: []llms.ContentPart{
					llms.TextPart(msg.Text),
				},
				Role: llms.ChatMessageTypeHuman,
			}
		} else {
			out[index+len(system_messages)] = llms.MessageContent{
				Parts: []llms.ContentPart{
					llms.TextPart(msg.Text),
				},
				Role: llms.ChatMessageTypeAI,
			}
		}
	}
	return out
}
