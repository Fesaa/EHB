package main

import (
	"fmt"
	"io"
	"log"
	"net/http"
	"strconv"
	"strings"

	"github.com/Fesaa/EHB/BA2/java-advanced/short-burst-protobuf/server/pbd"
	"google.golang.org/protobuf/proto"
)

type Cache[T any] struct {
	data  T
	valid bool
}

var addressBook map[int32]*pbd.Person = make(map[int32]*pbd.Person)
var bookCache Cache[[]byte] = Cache[[]byte]{valid: false}

func main() {

	mux := http.NewServeMux()

	mux.HandleFunc("/upload", addPerson)
	mux.HandleFunc("/person/", getPerson)
	mux.HandleFunc("/addressbook", getAddressBook)

	log.Println("Server starting on port 8080")
	e := http.ListenAndServe(":8080", mux)
	if e != nil {
		panic(e)
	}
}

func getAddressBook(w http.ResponseWriter, r *http.Request) {
	w.Header().Set("Content-Type", "application/x-protobuf")

	var data []byte
	var err error
	if bookCache.valid {
		data = bookCache.data
	} else {
		book := &pbd.AddressBook{}
		for _, v := range addressBook {
			book.People = append(book.People, v)
		}
		data, err = proto.Marshal(book)
		if err != nil {
			log.Println("Error marshaling response, but was succesful")
			w.WriteHeader(http.StatusInternalServerError)
			return
		}
		bookCache = Cache[[]byte]{data, true}
	}

	w.WriteHeader(http.StatusOK)
	w.Write(data)
}

func getPerson(w http.ResponseWriter, r *http.Request) {
	w.Header().Set("Content-Type", "text/plain; charset=UTF-8")

	parts := strings.Split(r.URL.Path, "/")
	if len(parts) != 3 {
		w.WriteHeader(http.StatusInternalServerError)
		w.Write([]byte("Invalid URL"))
		return
	}

	id := parts[len(parts)-1]
	strConv, err := strconv.Atoi(id)
	if err != nil {
		w.WriteHeader(http.StatusInternalServerError)
		w.Write([]byte("Invalid ID"))
		return
	}
	personID := int32(strConv)
	if person, ok := addressBook[personID]; ok {
		data, err := proto.Marshal(person)
		if err != nil {
			log.Println("Error marshaling response, but was succesful")
			w.WriteHeader(http.StatusInternalServerError)
			w.Write([]byte("Error marshaling response, but was succesful"))
			return
		}
		w.Header().Set("Content-Type", "application/x-protobuf")
		w.WriteHeader(http.StatusOK)
		w.Write(data)
		return
	}
	w.WriteHeader(http.StatusNotFound)
	w.Write([]byte("Person not foun"))
}

func addPerson(w http.ResponseWriter, r *http.Request) {
	w.Header().Set("Content-Type", "text/plain; charset=UTF-8")

	body, err := io.ReadAll(r.Body)
	if err != nil {
		log.Println(err)
		w.WriteHeader(http.StatusInternalServerError)
		w.Write([]byte("Error reading body, person not uploaded"))
		return
	}

	var person pbd.Person
	err = proto.Unmarshal(body, &person)
	if err != nil {
		log.Println(err)
		w.WriteHeader(http.StatusInternalServerError)
		w.Write([]byte("Error marshaling response, but was succesful"))
		return
	}

	addressBook[*person.Id] = &person
	bookCache.valid = false

	log.Println(fmt.Sprintf("Added person with id: %d", *person.Id))
	w.WriteHeader(http.StatusOK)
	w.Write([]byte(fmt.Sprintf("%d", *person.Id)))
}
