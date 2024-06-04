package db

import "github.com/Fesaa/EHB/AI-Essentials/erasmusbot/models"

type Database interface {
	Login(username string, password string) (bool, string)
	GetUserID(cookie string) (int, error)
	GetChatsForUser(id int) ([]models.ChatInfo, error)
	GetMessagesForChat(chatId string) ([]models.ChatMessage, error)
	GetChatInfo(chatId string) (*models.ChatInfo, error)
	AddMessage(chatId string, msg models.ChatMessage) error
	NewChat(userId int) (*models.ChatInfo, error)
}
