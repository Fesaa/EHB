package bot

import (
	"context"
	"github.com/Fesaa/EHB/AI-Essentials/erasmusbot/models"
)

type ErasmusBot interface {
	SetCtx(ctx context.Context)
	GenerateResponse(msg string, pastMessages []models.ChatMessage) (models.ChatMessage, error)
}
