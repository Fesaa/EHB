package art.ameliah.ehb.shortburst.protobuf;

import art.ameliah.ehb.shortburst.protobuf.adressbook.Person;

public class Main {
    public static void main(String[] args) {
        Person Eva = Person.newBuilder()
                .setId(1)
                .setName("Eva")
                .setEmail("eva@example.com")
                .addPhones(
                        Person.PhoneNumber.newBuilder()
                                .setNumber("555-1234")
                                .setType(Person.PhoneType.PHONE_TYPE_MOBILE)
                )
                .build();

        System.out.println(Eva);
    }
}