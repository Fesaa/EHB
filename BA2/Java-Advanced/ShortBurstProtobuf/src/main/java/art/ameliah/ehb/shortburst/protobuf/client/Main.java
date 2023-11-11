package art.ameliah.ehb.shortburst.protobuf.client;

import art.ameliah.ehb.shortburst.protobuf.impl.Provider;
import art.ameliah.ehb.shortburst.protobuf.impl.adressbook.*;
import org.springframework.http.HttpEntity;
import org.springframework.http.HttpHeaders;
import org.springframework.http.MediaType;
import org.springframework.http.converter.protobuf.ProtobufHttpMessageConverter;
import org.springframework.web.client.RestTemplate;

public class Main {

    private static final String HOST = "http://127.0.0.1:8080";
    private static final String UPLOAD_ENDPOINT = HOST + "/upload";
    private static final String DOWNLOAD_ENDPOINT = HOST + "/person/";
    private static final String ADDRESSBOOK_ENDPOINT = HOST + "/addressbook";

    public static void main(String[] args) {

        UploadResponse response = uploadPerson(Provider.randomPerson());

        if (response.hasError()) {
            System.out.println("Error: " + response.getError());
            System.exit(1);
        } else {
            System.out.println("Uploaded person with id: " + response.getId());
        }

        GetResponse getResponse = getPerson(response.getId());
        if (getResponse.hasError()) {
            System.out.println("Error: " + getResponse.getError());
            System.exit(1);
        } else {
            System.out.println("Downloaded person: " + getResponse.getPerson());
        }

        AddressBookResponse addressBookResponse = getAddressBook();
        if (addressBookResponse.hasError()) {
            System.out.println("Error: " + addressBookResponse.getError());
            System.exit(1);
        } else {
            System.out.println("Downloaded addressbook has " + addressBookResponse.getBook().getPeopleCount() + " people");
        }


    }

    private static AddressBookResponse getAddressBook() {
        RestTemplate restTemplate = new RestTemplate();
        restTemplate.getMessageConverters().add(new ProtobufHttpMessageConverter());
        return restTemplate.getForObject(ADDRESSBOOK_ENDPOINT, AddressBookResponse.class);
    }

    private static GetResponse getPerson(int id) {
        RestTemplate restTemplate = new RestTemplate();
        restTemplate.getMessageConverters().add(new ProtobufHttpMessageConverter());
        return restTemplate.getForObject(DOWNLOAD_ENDPOINT + id, GetResponse.class);
    }

    private static UploadResponse uploadPerson(Person person) {
        RestTemplate restTemplate = new RestTemplate();
        restTemplate.getMessageConverters().add(new ProtobufHttpMessageConverter());

        HttpHeaders headers = new HttpHeaders();
        headers.setContentType(MediaType.APPLICATION_PROTOBUF);

        HttpEntity<Person> entity = new HttpEntity<>(person, headers);
        return restTemplate.postForObject(UPLOAD_ENDPOINT, entity, UploadResponse.class);
    }

}
