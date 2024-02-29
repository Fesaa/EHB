package main

import "github.com/gofiber/fiber/v2"

func main() {
	app := fiber.New()

	app.Static("/", "./public")

	err := app.Listen("127.0.0.1:8000")
	if err != nil {
		panic(err)
	}
}
