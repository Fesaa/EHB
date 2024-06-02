package api

import (
	"github.com/Fesaa/EHB/AI-Essentials/erasmusbot/server/middleware"
	"github.com/gofiber/fiber/v2"
)

func RegisterBackEnd(router fiber.Router) {

	api := router.Group("/api")

	api.Post("/login", login)
	api.Post("logout", logout)

	chats := api.Group("/chats", middleware.AuthMiddleware(false))

	chats.Get("/", getChats)
	chats.Get("/full/:id", getChatInfo)
}
