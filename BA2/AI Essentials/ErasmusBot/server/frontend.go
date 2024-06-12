package main

import (
	"github.com/Fesaa/EHB/AI-Essentials/erasmusbot/config"
	"github.com/Fesaa/EHB/AI-Essentials/erasmusbot/server/middleware"
	"github.com/gofiber/fiber/v2"
)

var defaultMap fiber.Map

func registerFrontend(router fiber.Router) {
	defaultMap = fiber.Map{
		"path": config.I().GetBaseUrl(),
	}

	router.Get("/", middleware.AuthMiddleware(true), home)
	router.Get("/login", login)
}

func home(c *fiber.Ctx) error {
	return c.Render("index", defaultMap)
}

func login(c *fiber.Ctx) error {
	return c.Render("login", defaultMap)
}
