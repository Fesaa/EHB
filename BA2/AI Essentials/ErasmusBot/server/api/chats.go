package api

import (
	"github.com/Fesaa/EHB/AI-Essentials/erasmusbot/bot"
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

type addChatStruct struct {
	Query string `json:"query"`
}

func addChat(c *fiber.Ctx) error {
	chatId := c.Params("id")
	userID, _ := c.Locals("user_id").(int)
	chatInfo, err := db.I().GetChatInfo(chatId)
	if err != nil {
		return err
	}

	if chatInfo.UserId != userID {
		return fiber.ErrForbidden
	}
	var s addChatStruct
	err = c.BodyParser(&s)
	if err != nil {
		return err
	}

	err = db.I().AddMessage(chatId, models.ChatMessage{
		User: true,
		Text: s.Query,
	})

	reply, err := bot.I().GenerateResponse(s.Query)
	if err != nil {
		return err
	}

	err = db.I().AddMessage(chatId, reply)
	if err != nil {
		return err
	}

	return c.JSON(reply)
}

func newChat(c *fiber.Ctx) error {
	userID, _ := c.Locals("user_id").(int)
	ci, err := db.I().NewChat(userID)
	if err != nil {
		return err
	}
	return c.JSON(ci)
}
