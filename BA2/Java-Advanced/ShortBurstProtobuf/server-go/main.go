package main

import (
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
		res := pbd.AddressBookResponse{Book: book}
		data, err = proto.Marshal(&res)
		if err != nil {
			log.Println("Error marshaling response, but was succesful")
			return
		}
		bookCache = Cache[[]byte]{data, true}
	}

	w.WriteHeader(http.StatusOK)
	w.Write(data)
}

func getPerson(w http.ResponseWriter, r *http.Request) {
	w.Header().Set("Content-Type", "application/x-protobuf")

	parts := strings.Split(r.URL.Path, "/")
	if len(parts) != 3 {
		s := "Invalid URL"
		res := pbd.GetResponse{Error: &s}
		data, err := proto.Marshal(&res)
		if err != nil {
			log.Println("Error marshaling response, but was succesful")
			return
		}
		w.WriteHeader(http.StatusInternalServerError)
		w.Write(data)
		return
	}

	id := parts[len(parts)-1]
	strConv, err := strconv.Atoi(id)
	if err != nil {
		s := "Invalid ID"
		res := pbd.GetResponse{Error: &s}
		data, err := proto.Marshal(&res)
		if err != nil {
			log.Println("Error marshaling response, but was succesful")
			return
		}
		w.WriteHeader(http.StatusInternalServerError)
		w.Write(data)
		return
	}
	personID := int32(strConv)
	if person, ok := addressBook[personID]; ok {
		res := pbd.GetResponse{Person: person}
		data, err := proto.Marshal(&res)
		if err != nil {
			log.Println("Error marshaling response, but was succesful")
			return
		}
		w.WriteHeader(http.StatusOK)
		w.Write(data)
		return
	}

	s := "Person not found"
	res := pbd.GetResponse{Error: &s}
	data, err := proto.Marshal(&res)
	if err != nil {
		log.Println("Error marshaling response, but was succesful")
		return
	}
	w.WriteHeader(http.StatusNotFound)
	w.Write(data)
}

func addPerson(w http.ResponseWriter, r *http.Request) {
	w.Header().Set("Content-Type", "application/x-protobuf")

	body, err := io.ReadAll(r.Body)
	if err != nil {
		log.Println("Error marshaling response, but was succesful")
		w.WriteHeader(http.StatusInternalServerError)
		return
	}

	var person pbd.Person
	err = proto.Unmarshal(body, &person)
	if err != nil {
		log.Println("Error marshaling response, but was succesful")
		w.WriteHeader(http.StatusInternalServerError)
		return
	}

	addressBook[*person.Id] = &person
	bookCache.valid = false

	response := pbd.UploadResponse{Id: person.Id}
	data, err := proto.Marshal(&response)
	if err != nil {
		log.Println("Error marshaling response, but was succesful")
		w.WriteHeader(http.StatusInternalServerError)
		return
	}

	w.WriteHeader(http.StatusOK)
	w.Write(data)
}
