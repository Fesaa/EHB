package api

import (
	"github.com/Fesaa/EHB/AI-Essentials/erasmusbot/db"
	"github.com/Fesaa/EHB/AI-Essentials/erasmusbot/models"
	"github.com/gofiber/fiber/v2"
)

func getChats(c *fiber.Ctx) error {
	userID, _ := c.Locals("user_id").(int)
	chats, err := db.I().GetChatsForUser(userID)
	if err != nil {
		return err
	}
	return c.JSON(chats)
}

func getChatInfo(c *fiber.Ctx) error {
	chatId := c.Params("id")
	userID, _ := c.Locals("user_id").(int)

	chatInfo, err := db.I().GetChatInfo(chatId)
	if err != nil {
		return err
	}

	if chatInfo.UserId != userID {
		return fiber.ErrForbidden
	}

	msgs, err := db.I().GetMessagesForChat(chatId)
	if err != nil {
		return err
	}

	full := models.FullChatInfo{
		Id:          chatInfo.Id,
		Name:        chatInfo.Name,
		ChatHistory: msgs,
	}

	return c.JSON(full)
}
