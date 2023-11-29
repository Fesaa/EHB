package main

import (
	"fmt"
	"log"
	"os"
	"os/signal"
	"time"

	"github.com/gorilla/websocket"
)

var start time.Time

type Client struct {
	conn  *websocket.Conn
	token string
}

var returnMessage string = "Default Value"
var port string = "2020"

func main() {
	port = os.Getenv("PORT")
	if port == "" {
		port = "2020"
	}

	start = time.Now()

	interrupt := make(chan os.Signal, 1)
	signal.Notify(interrupt, os.Interrupt)

	url := "ws://localhost:8080/ws"

	c, _, err := websocket.DefaultDialer.Dial(url, nil)
	if err != nil {
		log.Fatal("dial:", err)
	}
	defer c.Close()

	client := &Client{
		conn: c,
	}

	done := make(chan struct{})
	go client.Handle(done)
	go startWebServer()

	// Gracefully handle interrupt signal
	select {
	case <-interrupt:
		fmt.Println("Interrupt received. Closing connection...")
		err := c.WriteMessage(websocket.CloseMessage, websocket.FormatCloseMessage(websocket.CloseNormalClosure, ""))
		if err != nil {
			log.Println("write close:", err)
			return
		}
		select {
		case <-done:
		case <-time.After(time.Second):
		}
		return
	}
}
