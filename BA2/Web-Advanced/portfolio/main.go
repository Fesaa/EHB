package main

import "github.com/gofiber/fiber/v2"

func main() {
	app := fiber.New()

	app.Static("/", "./public")
	app.Get("/", func(c *fiber.Ctx) error {
		return c.Redirect("/main.html")
	})

	err := app.Listen("127.0.0.1:8000")
	if err != nil {
		panic(err)
	}
}
