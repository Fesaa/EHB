package models

type ChatInfo struct {
	Id     string `json:"id"`
	UserId int    `json:"userId"`
	Name   string `json:"name"`
}

type ChatMessage struct {
	User bool   `json:"user"`
	Text string `json:"text"`
}

type FullChatInfo struct {
	Id          string        `json:"id"`
	Name        string        `json:"name"`
	ChatHistory []ChatMessage `json:"chatHistory"`
}
