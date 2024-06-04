package main

import (
	"github.com/Fesaa/EHB/AI-Essentials/erasmusbot/bot"
	"github.com/Fesaa/EHB/AI-Essentials/erasmusbot/config"
	"github.com/Fesaa/EHB/AI-Essentials/erasmusbot/db"
	"github.com/Fesaa/EHB/AI-Essentials/erasmusbot/server/api"
	"github.com/gofiber/fiber/v2"
	"github.com/gofiber/fiber/v2/middleware/logger"
	"github.com/gofiber/template/html/v2"
	"log/slog"
)

func main() {
	err := config.LoadConfig("config.yaml")
	if err != nil {
		slog.Error("Unable to load config, exiting", "error", err)
		return
	}
	if err := db.InitDatabase(); err != nil {
		slog.Error("Unable to connect to database, exiting", "error", err)
		return
	}
	if err := bot.Init(); err != nil {
		slog.Error("Unable to initialize bot, exiting", "error", err)
		return
	}

	engine := html.New("./web/views", ".html")
	app := fiber.New(fiber.Config{
		Views: engine,
	})

	app.Use(logger.New(logger.Config{
		TimeFormat: "2006/01/02 15:04:05",
		Format:     "${time} | ${status} | ${latency} | ${reqHeader:X-Real-IP} ${ip} | ${method} | ${path} | ${error}\n",
		Next: func(c *fiber.Ctx) bool {
			return !config.I().GetDebug()
		},
	}))

	app.Static(config.I().GetBaseUrl(), "./web/public")
	registerFrontend(app)
	api.RegisterBackEnd(app)

	if e := app.Listen(":3000"); e != nil {
		slog.Error("Unable to start server, exiting", "error", e)
	}
}
