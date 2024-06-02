package middleware

import (
	"github.com/Fesaa/EHB/AI-Essentials/erasmusbot/config"
	"github.com/Fesaa/EHB/AI-Essentials/erasmusbot/db"
	"github.com/gofiber/fiber/v2"
	"log/slog"
)

func AuthMiddleware(redirect bool) func(*fiber.Ctx) error {
	if redirect {
		return authMiddlewareRedirect
	}
	return authMiddleware
}

func authMiddlewareRedirect(ctx *fiber.Ctx) error {
	token := ctx.Cookies("erasmus-bot::token")
	if token == "" {
		return ctx.Redirect(config.I().GetBaseUrl() + "/login")
	}

	id, err := db.I().GetUserID(token)
	if err != nil {
		slog.Info("Error getting user id from database", "err", err)
		return ctx.Redirect(config.I().GetBaseUrl() + "/login")
	}

	ctx.Locals("user_id", id)
	return ctx.Next()
}

func authMiddleware(ctx *fiber.Ctx) error {
	token := ctx.Cookies("erasmus-bot::token")
	if token == "" {
		return fiber.ErrUnauthorized
	}

	id, err := db.I().GetUserID(token)
	if err != nil {
		return fiber.ErrUnauthorized
	}

	ctx.Locals("user_id", id)
	return ctx.Next()
}
