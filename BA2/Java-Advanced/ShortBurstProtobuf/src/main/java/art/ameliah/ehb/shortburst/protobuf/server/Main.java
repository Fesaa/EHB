package art.ameliah.ehb.shortburst.protobuf.server;

import art.ameliah.ehb.shortburst.protobuf.impl.Provider;
import art.ameliah.ehb.shortburst.protobuf.impl.adressbook.*;
import org.springframework.boot.SpringApplication;
import org.springframework.boot.autoconfigure.SpringBootApplication;
import org.springframework.context.annotation.Bean;
import org.springframework.http.converter.protobuf.ProtobufHttpMessageConverter;
import org.springframework.web.bind.annotation.*;

import java.util.Map;

@SpringBootApplication
@RestController
public class Main {
    private static final Map<Integer, Person> people;

    static {
        people = Provider.testData();
    }
    public static void main(String[] args) {
        SpringApplication.run(Main.class, args);
    }

    @Bean
    ProtobufHttpMessageConverter protobufHttpMessageConverter() {
        return new ProtobufHttpMessageConverter();
    }

    @GetMapping("/addressbook")
    public AddressBookResponse addressBook() {
        return AddressBookResponse.newBuilder()
                .setBook(AddressBook.newBuilder()
                        .addAllPeople(people.values()))
                .build();
    }

    @GetMapping("/person/{id}")
    public GetResponse index(@PathVariable Integer id) {
        Person p = people.get(id);
        if (p == null) {
            return GetResponse.newBuilder()
                    .setError("Person not found")
                    .build();
        }
        return GetResponse.newBuilder()
                .setPerson(p)
                .build();
    }

    @PostMapping("/upload")
    public UploadResponse upload(@RequestBody Person person) {
        people.put(person.getId(), person);
        return UploadResponse.newBuilder()
                .setId(person.getId())
                .build();
    }

}
