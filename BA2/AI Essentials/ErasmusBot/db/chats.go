package db

import (
	"github.com/Fesaa/EHB/AI-Essentials/erasmusbot/models"
)

func (db *databaseImpl) GetChatsForUser(id int) ([]models.ChatInfo, error) {
	res, err := db.db.Query("SELECT id, name, user_id FROM chats WHERE user_id = ?", id)
	if err != nil {
		return nil, err
	}
	defer res.Close()
	var chats []models.ChatInfo
	for res.Next() {
		var chat models.ChatInfo
		err := res.Scan(&chat.Id, &chat.Name, &chat.UserId)
		if err != nil {
			return nil, err
		}
		chats = append(chats, chat)
	}

	return chats, nil
}

func (db *databaseImpl) GetMessagesForChat(chatId string) ([]models.ChatMessage, error) {
	res, err := db.db.Query("SELECT message, user FROM messages WHERE chat_id = ?", chatId)
	if err != nil {
		return nil, err
	}

	defer res.Close()
	var messages []models.ChatMessage = make([]models.ChatMessage, 0)
	for res.Next() {
		var message models.ChatMessage
		err := res.Scan(&message.Text, &message.User)
		if err != nil {
			return nil, err
		}
		messages = append(messages, message)
	}
	return messages, nil
}

func (db *databaseImpl) GetChatInfo(chatId string) (*models.ChatInfo, error) {
	row := db.db.QueryRow("SELECT user_id, name FROM chats WHERE id = ?", chatId)
	var chatInfo models.ChatInfo
	err := row.Scan(&chatInfo.UserId, &chatInfo.Name)
	if err != nil {
		return nil, err
	}
	return &chatInfo, nil
}

func (db *databaseImpl) AddMessage(chatId string, msg models.ChatMessage) error {
	_, err := db.db.Exec("INSERT INTO messages (chat_id, user, message) VALUES (? , ?, ?)", chatId, msg.User, msg.Text)
	return err
}

func (db *databaseImpl) NewChat(userId int) (*models.ChatInfo, error) {
	ci := &models.ChatInfo{
		Id:     generateSecureToken(10),
		UserId: userId,
		Name:   "My New Chat",
	}

	_, err := db.db.Exec("INSERT INTO chats (user_id, name, id) VALUES (?, ?, ?)", ci.UserId, ci.Name, ci.Id)
	if err != nil {
		return nil, err
	}
	return ci, nil
}

func (db *databaseImpl) Rename(chatId string, name string) error {
	_, err := db.db.Exec("UPDATE chats SET name = ? WHERE id = ?", name, chatId)
	return err
}
