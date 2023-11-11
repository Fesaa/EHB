package art.ameliah.ehb.shortburst.protobuf.impl;

import art.ameliah.ehb.shortburst.protobuf.impl.adressbook.Person;

import java.util.HashMap;
import java.util.Map;
import java.util.Random;

public class Provider {

    private static final Random rnd = new Random(System.currentTimeMillis());

    private static final String[] NAMES = {
            "Eva", "Amelia", "Luna", "Lo", "Lotte", "Yana", "Milan",
            "Oliver", "Olivia", "Noah", "Emma", "Sophia", "Liam", "Isabella",
            "Jackson", "Ava", "Lucas", "Mia", "Aiden", "Ella", "Caden", "Madison",
            "Grayson", "Scarlett", "Leo", "Aria", "Mason", "Layla", "Elijah",
            "Chloe", "Logan", "Harper", "Carter", "Penelope", "Owen", "Evelyn",
            "Jayden", "Abigail", "Wyatt", "Emily", "Henry", "Elizabeth", "Sebastian",
            "Avery", "Caleb", "Grace", "Gabriel", "Sofia"
    };


    public static Map<Integer, Person> testData() {
        return testData(100);
    }

    public static Map<Integer, Person> testData(int count) {
        Map<Integer, Person> map = new HashMap<>(count);
        for (int i = 0; i < count; i++) {
            Person person = randomPerson(i);
            map.put(person.getId(), person);
        }
        return map;
    }

    public static Person randomPerson() {
        return randomPerson(rnd.nextInt(101, 1000000));
    }

    private static Person randomPerson(int i) {
        String name = NAMES[rnd.nextInt(NAMES.length)];
        return Person.newBuilder()
                .setId(i)
                .setName(name)
                .setEmail(name + "@example.com")
                .addPhones(random())
                .addPhones(random())
                .addPhones(random())
                .build();
    }

    private static Person.PhoneNumber random() {
        return Person.PhoneNumber.newBuilder()
                .setNumber(String.valueOf(rnd.nextInt(1000000000)))
                .setType(Person.PhoneType.forNumber(rnd.nextInt(3)))
                .build();
    }

}
