package main

import (
	"fmt"
	"log"
	"net/http"
)

var counter int = 0

func startWebServer() {
	http.HandleFunc("/counter", func(w http.ResponseWriter, r *http.Request) {
		counter++
		fmt.Fprintf(w, "Counter: %d", counter)
	})

	http.HandleFunc("/msg", func(w http.ResponseWriter, r *http.Request) {
		fmt.Fprintf(w, "Message: %s", returnMessage)
	})

	log.Println("Starting server...")
	err := http.ListenAndServe(":"+port, nil)
	if err != nil {
		log.Fatal("ListenAndServe: ", err)
	}
}
