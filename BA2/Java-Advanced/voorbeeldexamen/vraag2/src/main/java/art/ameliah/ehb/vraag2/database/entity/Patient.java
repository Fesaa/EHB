package art.ameliah.ehb.vraag2.database.entity;

import art.ameliah.ehb.vraag2.controllers.menu.Patients;
import jakarta.persistence.*;

import java.util.ArrayList;
import java.util.List;

@Entity
public class Patient {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    @Column(name = "id")
    private int id;

    @Column(name = "name")
    private String name;

    @ManyToMany(mappedBy = "patients")
    private List<Symptom> symptoms = new ArrayList<>();

    public Patient() {}

    public Patient(String name) {
        this.name = name;
    }

    public Patient(int id, String name) {
        this.id = id;
        this.name = name;
    }

    public String getName() {
        return name;
    }

    public int getId() {
        return id;
    }
}
