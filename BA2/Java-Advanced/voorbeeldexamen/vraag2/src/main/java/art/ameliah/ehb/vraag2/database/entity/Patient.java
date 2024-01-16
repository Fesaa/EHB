package art.ameliah.ehb.vraag2.database.entity;

import art.ameliah.ehb.vraag2.controllers.menu.Patients;
import art.ameliah.ehb.vraag2.models.Named;
import jakarta.persistence.*;

import java.util.ArrayList;
import java.util.List;

@Entity
public class Patient implements Named {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    @Column(name = "id")
    private int id;

    @Column(name = "name")
    private String name;

    @Column(name = "age")
    private int age;

    @ManyToMany(mappedBy = "patients", fetch = FetchType.EAGER)
    private List<Symptom> symptoms = new ArrayList<>();

    public Patient() {}

    public Patient(String name, int age) {
        this.name = name;
        this.age = age;
    }

    public Patient(int id, String name, int age) {
        this.id = id;
        this.name = name;
        this.age = age;
    }

    public String getName() {
        return name;
    }

    public int getId() {
        return id;
    }

    public int getAge() {
        return age;
    }

    public List<Symptom> getSymptoms() {
        return symptoms;
    }
}
