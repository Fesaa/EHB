package org.paumard.lambdamasterclass.part1;

import org.junit.Test;
import org.paumard.lambdamasterclass.part1.model.Person;

import java.util.Comparator;

import static org.assertj.core.api.Assertions.assertThat;

public class Test03_Comparator {

    private Person michael = new Person("Michael", "Jackson", 51);
    private Person rod = new Person("Rod", "Stewart", 71);
    private Person paul = new Person("Paul", "McCartney", 74);
    private Person mick = new Person("Mick", "Jagger", 73);
    private Person jermaine = new Person("Jermaine", "Jackson", 61);

    /**
     * Write a comparator that compare instances of the Person
     * class using the following rules:
     * - the instances are first compared using their last names
     * - then compared with their first names
     * - then compared with their age
     * - if this comparator is used to sort a list of Person
     * instances, and this list contains null values, then these
     * null values should be put at the end of the sorted list.
     */
    @Test
    public void comparator_1() {
        Comparator<Person> cmp = new Comparator<Person>() {
            @Override
            public int compare(Person person1, Person person2) {
                if (person1 == null && person2 == null) {
                    return 0; // Equal
                } else if (person1 == null) {
                    return 1; // person2 is greater
                } else if (person2 == null) {
                    return -1; // person1 is greater
                }

                int lastNameComparison = person1.getLastName().compareTo(person2.getLastName());
                if (lastNameComparison != 0) {
                    return lastNameComparison;
                }

                int firstNameComparison = person1.getFirstName().compareTo(person2.getFirstName());
                if (firstNameComparison != 0) {
                    return firstNameComparison;
                }

                return Integer.compare(person1.getAge(), person2.getAge());


            }
        }; // TODO

        assertThat(cmp.compare(michael, rod)).isLessThan(0);
        assertThat(cmp.compare(paul, paul)).isEqualTo(0);
        assertThat(cmp.compare(michael, jermaine)).isGreaterThan(0);
        assertThat(cmp.compare(mick, null)).isLessThan(0);
        assertThat(cmp.compare(null, mick)).isGreaterThan(0);
    }
}
