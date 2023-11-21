package art.ameliah.ehb.shortburst.protobuf.client;

import art.ameliah.ehb.shortburst.protobuf.impl.Provider;
import art.ameliah.ehb.shortburst.protobuf.impl.adressbook.AddressBook;
import art.ameliah.ehb.shortburst.protobuf.impl.adressbook.Person;
import com.google.protobuf.InvalidProtocolBufferException;

import java.net.URI;
import java.net.http.HttpClient;
import java.net.http.HttpRequest;
import java.net.http.HttpResponse;
import java.util.concurrent.CompletableFuture;
import java.util.function.Consumer;
import java.util.function.Supplier;

public class Main {
    private static final String HOST = "http://127.0.0.1:8080";
    private static final String UPLOAD_ENDPOINT = HOST + "/upload";
    private static final String DOWNLOAD_ENDPOINT = HOST + "/person/";
    private static final String ADDRESSBOOK_ENDPOINT = HOST + "/addressbook";

    private static HttpClient client = HttpClient.newHttpClient();


    public static void main(String[] args) {
        Integer uploadedId = getAndLogHelper(() -> uploadPerson(Provider.randomPerson()),
                (id) -> System.out.println("Uploaded person with id " + id));

        if (uploadedId == null) {
            return;
        }

        Person downloadedPerson = getAndLogHelper(() -> downloadPerson(uploadedId),
                (person) -> System.out.println("Downloaded person with id " + person.getId() + " and name " + person.getName()));

        AddressBook addressBook = getAndLogHelper(Main::downloadAddressBook,
                (ab) -> System.out.println("Downloaded addressbook with " + ab.getPeopleCount() + " people"));

        if (addressBook == null) {
            return;
        }

        for (Person person : addressBook.getPeopleList()) {
            System.out.print("Person: " + person.getName());
            if (person.getId() == downloadedPerson.getId()) {
                System.out.println("  - This is the person we uploaded and downloaded");
            }
            System.out.println();
        }

    }

    private static <T> T getAndLogHelper(Supplier<CompletableFuture<T>> supplier, Consumer<T> consumer) {
        return supplier.get()
                .thenApply((t) -> {
                    if (t == null) {
                        System.out.println("t was null");
                    } else {
                        consumer.accept(t);
                    }
                    return t;
                }).exceptionally((e) -> {
                    System.out.println("Request failed: " + e.getMessage());
                    return null;
                }).join();
    }

    private static CompletableFuture<AddressBook> downloadAddressBook() {
        HttpRequest req = HttpRequest.newBuilder()
                .uri(URI.create(ADDRESSBOOK_ENDPOINT))
                .GET()
                .build();

        return client.sendAsync(req, HttpResponse.BodyHandlers.ofByteArray())
                .thenApply((response) -> {
                    if (response.statusCode() != 200) {
                        throw new RuntimeException("[" + response.statusCode() + "]Failed to download addressbook: " + response.body());
                    }
                    return response;
                })
                .thenApply(HttpResponse::body)
                .thenApply((body) -> {
                    try {
                        return AddressBook.parseFrom(body);
                    } catch (InvalidProtocolBufferException e) {
                        throw new RuntimeException("Failed to upload person: ");
                    }
                });
    }

    private static CompletableFuture<Person> downloadPerson(int id) {
        HttpRequest req = HttpRequest.newBuilder()
                .uri(URI.create(DOWNLOAD_ENDPOINT + id))
                .GET()
                .build();

        return client.sendAsync(req, HttpResponse.BodyHandlers.ofByteArray())
                .thenApply((response) -> {
                    if (response.statusCode() != 200) {
                        throw new RuntimeException("[" + response.statusCode() + "]Failed to download person: " + response.body());
                    }
                    return response;
                })
                .thenApply(HttpResponse::body)
                .thenApply((body) -> {
                    try {
                        return Person.parseFrom(body);
                    } catch (InvalidProtocolBufferException e) {
                        throw new RuntimeException("Failed to upload person: ");
                    }
                });
    }

    private static CompletableFuture<Integer> uploadPerson(Person person) {
        HttpRequest req = HttpRequest.newBuilder()
                .uri(URI.create(UPLOAD_ENDPOINT))
                .header("Content-Type", "application/x-protobuf")
                .POST(HttpRequest.BodyPublishers.ofByteArray(person.toByteArray()))
                .build();

        return client.sendAsync(req, HttpResponse.BodyHandlers.ofString())
                .thenApply((response) -> {
                    if (response.statusCode() != 200) {
                        throw new RuntimeException("[" + response.statusCode() + "]Failed to upload person: " + response.body());
                    }
                    return response;
                })
                .thenApply(HttpResponse::body)
                .thenApply((body) -> {
                    try {
                        return Integer.parseInt(body);
                    } catch (NumberFormatException e) {
                        throw new RuntimeException("Failed to upload person: " + body);
                    }
                });
    }
}
