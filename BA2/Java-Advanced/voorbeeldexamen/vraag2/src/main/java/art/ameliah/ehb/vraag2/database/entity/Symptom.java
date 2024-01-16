package art.ameliah.ehb.vraag2.database.entity;


import art.ameliah.ehb.vraag2.models.Named;
import jakarta.persistence.*;

import java.util.ArrayList;
import java.util.List;

@Entity
public class Symptom implements Named {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    @Column(name = "id")
    private int id;

    @Column(name = "name")
    private String name;

    @Column(name = "description")
    private String desc;

    @ManyToMany(cascade = CascadeType.ALL, fetch = FetchType.EAGER)
    @JoinTable(
            name = "patients_symptoms",
            joinColumns = { @JoinColumn(name = "symptom_id")},
            inverseJoinColumns = { @JoinColumn(name = "patient_id")}
    )
    private List<Patient> patients = new ArrayList<>();

    public Symptom() {}

    public Symptom(String name, String desc) {
        this.name = name;
        this.desc = desc;
    }

    public Symptom(int id, String name, String desc) {
        this.id = id;
        this.name = name;
        this.desc = desc;
    }

    public int getId() {
        return id;
    }

    public String getDesc() {
        return desc;
    }

    public String getName() {
        return name;
    }

    public List<Patient> getPatients() {
        return patients;
    }

    public void setPatients(List<Patient> patients) {
        this.patients = patients;
    }
}
