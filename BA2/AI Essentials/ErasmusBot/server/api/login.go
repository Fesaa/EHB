package api

import (
	"github.com/Fesaa/EHB/AI-Essentials/erasmusbot/config"
	"github.com/Fesaa/EHB/AI-Essentials/erasmusbot/db"
	"github.com/gofiber/fiber/v2"
	"log/slog"
	"time"
)

type loginRequest struct {
	Username string `json:"username"`
	Password string `json:"password"`
}

func login(ctx *fiber.Ctx) error {
	body := loginRequest{}
	if err := ctx.BodyParser(&body); err != nil {
		slog.Error("Failed to parse body", "error", err)
		return ctx.Redirect(config.I().GetBaseUrl() + "/login")
	}
	if body.Username == "" || body.Password == "" {
		return ctx.Redirect(config.I().GetBaseUrl() + "/login")
	}

	success, token := db.I().Login(body.Username, body.Password)
	if !success {
		return ctx.Redirect(config.I().GetBaseUrl() + "/login")
	}

	ctx.Cookie(&fiber.Cookie{
		Name:        "erasmus-bot::token",
		Value:       token,
		SessionOnly: true,
		Expires:     time.Now().Add(time.Hour * 24 * 7),
	})

	return ctx.Redirect(config.I().GetBaseUrl() + "/")
}
