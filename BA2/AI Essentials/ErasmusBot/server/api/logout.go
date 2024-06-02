package api

import (
	"github.com/gofiber/fiber/v2"
	"time"
)

func logout(c *fiber.Ctx) error {
	c.Cookie(&fiber.Cookie{
		Name:    "erasmus-bot::token",
		Expires: time.Now().Add(-(time.Hour * 5)),
	})
	return nil
}
