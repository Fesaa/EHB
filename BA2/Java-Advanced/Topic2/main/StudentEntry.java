package main;

import java.util.ArrayList;
import java.util.Collections;
import java.util.DoubleSummaryStatistics;
import java.util.stream.Collectors;

public class StudentEntry {
    private String name;
    private double score;
    private String course;

    public StudentEntry(String name, double score, String course) {
        this.name = name;
        this.score = score;
        this.course = course;
    }

    public static void main(String[] args) {
        ArrayList<StudentEntry> entries = new ArrayList<>();
        Collections.addAll(entries,
                new StudentEntry("Jef", 10.3, "Java Advanced"),
                new StudentEntry("Jan", 5.6, "Java Advanced"),
                new StudentEntry("Adam", 4.8, "Databases Advanced"),
                new StudentEntry("Eva", 12.5, "Java Advanced"),
                new StudentEntry("Bert", 16.3, "Databases Advanced"),
                new StudentEntry("Gert", 8.3, "Java Advanced"),
                new StudentEntry("Jan", 9.0, "Networking Essentials"),
                new StudentEntry("Noel", 16.7, "Java Advanced"),
                new StudentEntry("Willem", 15.3, "Networking Essentials"),
                new StudentEntry("Geert", 7.3, "Networking Essentials"),
                new StudentEntry("Karine", 20.0, "Databases Advanced"),
                new StudentEntry("Wim", 17.3, "Java Advanced"),
                new StudentEntry("Mike", 7.3, "Java Advanced"),
                new StudentEntry("Joachim", 14.3, "Java Advanced"),
                new StudentEntry("Steve", 15.3, "Networking Essentials"),
                new StudentEntry("Martine", 2.3, "Java Advanced"),
                new StudentEntry("Kristien", 11.3, "Java Advanced"),
                new StudentEntry("Jurgen", 8.4, "Databases Advanced")
        );

        //Toon alle geslaagde studenten
        System.out.println("Alle geslaagde studenten:");
        entries.stream()
                .filter(s -> s.getScore() >= 10)
                .forEach(System.out::println);

        //Toon alle geslaagde studenten voor het vak Java Advanced
        System.out.println("Alle geslaagde studenten voor het vak Java Advanced:");
        entries.stream()
                .filter(s -> s.getScore() >= 10)
                .filter(s -> s.getCourse().equals("Java Advanced"))
                .forEach(System.out::println);

        //Toon per vak het aantal studenten
        System.out.println("Toon per vak het aantal studenten");
        entries.stream()
                .collect(Collectors.groupingBy(StudentEntry::getCourse))
                .forEach((course, students) -> {
                    System.out.println(course + ": " + students.size());
                });

        //Aantal geslaagde studenten per vak
        System.out.println("Aantal geslaagde studenten per vak");
        entries.stream()
                .collect(Collectors.groupingBy(StudentEntry::getCourse))
                .forEach((course, students) -> {
                    System.out.println(course + ": ");
                    students.stream()
                            .filter(s -> s.getScore() >= 10)
                            .forEach(System.out::println);
                });

        // Gebruik makende van DoubleSummaryStatistics toon de maximum, minimum en de average van het vak Java Advanced
        System.out.println("Gebruik makende van DoubleSummaryStatistics toon de maximum, minimum en de average van het vak Java Advanced");
        DoubleSummaryStatistics stats = entries.stream()
                .filter(s -> s.getCourse().equals("Java Advanced"))
                .map(StudentEntry::getScore)
                .collect(DoubleSummaryStatistics::new,
                        DoubleSummaryStatistics::accept,
                        DoubleSummaryStatistics::combine);
        System.out.printf("max: %f, min: %f, avg: %f%n",
                stats.getMax(),
                stats.getMin(),
                stats.getAverage());

        //Alle studenten waarvan de naam langer is dan 4 letters en die een e in de naam hebben
        //+ Beperkt tot 4 personen
        //+ en gesorteerd op naam
        //+ in omgekeerde volgorde
        //Maak een String van de alle 2de en derde letters van elke naam

        System.out.println("Weird stuff");
        String weirdName = entries.stream()
                .map(StudentEntry::getName)
                .filter(s -> s.length() > 4)
                .filter(s -> s.contains("e"))
                .limit(4)
                .sorted(String::compareTo)
                .sorted(Collections.reverseOrder())
                .map(name -> name.substring(1, 3))
                .collect(Collectors.joining());
        System.out.println(weirdName);



    }

    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }

    public double getScore() {
        return score;
    }

    public void setScore(double score) {
        this.score = score;
    }

    public String getCourse() {
        return course;
    }

    public void setCourse(String course) {
        this.course = course;
    }

    @Override
    public String toString() {
        return String.format("[%s] %s: %f", course, name, score);
    }
}
