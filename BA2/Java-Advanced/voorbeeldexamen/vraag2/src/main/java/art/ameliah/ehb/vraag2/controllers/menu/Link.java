package art.ameliah.ehb.vraag2.controllers.menu;

import art.ameliah.ehb.vraag2.database.Disco;
import art.ameliah.ehb.vraag2.database.entity.Patient;
import art.ameliah.ehb.vraag2.database.entity.Symptom;
import art.ameliah.ehb.vraag2.models.Named;
import javafx.collections.FXCollections;
import javafx.collections.ObservableList;
import javafx.event.ActionEvent;
import javafx.event.Event;
import javafx.event.EventHandler;
import javafx.fxml.FXML;
import javafx.scene.control.Button;
import javafx.scene.control.ComboBox;
import javafx.scene.control.ListCell;
import javafx.scene.control.ListView;
import javafx.util.Callback;
import org.hibernate.Session;
import org.hibernate.query.Query;

import static art.ameliah.ehb.vraag2.utils.JavaFXUtils.SimpleErrorAlert;

public class Link {
    @FXML
    public Button submit;
    public ComboBox<Symptom> symptom_list;
    public ComboBox<Patient> patient_list;


    private final ObservableList<Symptom> symptoms = FXCollections.observableArrayList();
    private final ObservableList<Patient> patients = FXCollections.observableArrayList();


    @FXML
    public void initialize() {
        submit.addEventHandler(ActionEvent.ACTION, this::onSubmit);

        // TODO: display item is still the class definition lol?
        symptom_list.setItems(symptoms);
        symptom_list.setCellFactory(getFactory(Symptom.class));
        symptom_list.setOnShown(onOpen(Symptom.class, symptoms));

        patient_list.setItems(patients);
        patient_list.setCellFactory(getFactory(Patient.class));
        patient_list.setOnShown(onOpen(Patient.class, patients));
    }

    // Should be cached or register ObservableList to Disco that updates them when save is used maybe?
    // Out of scope atm
    private <T> EventHandler<Event> onOpen(Class<T> Clazz, ObservableList<T> list) {
        return e -> list.setAll(Disco.get().getTable(Clazz));
    }

    // vomit- at least it looks nice-ish above
    private <T extends Named> Callback<ListView<T>, ListCell<T>> getFactory(Class<T> clazz) {
        return listView -> new ListCell<>() {
            @Override
            protected void updateItem(T item, boolean empty) {
                super.updateItem(item, empty);
                if (item == null || empty) {
                    return;
                }
                setText(item.getName());
            }
        };
    }


    // Can't deselect? Think a multi select would be nicer maybe idk?
    public void onSubmit(ActionEvent e) {
        Patient patient = patient_list.getValue();
        Symptom symptom = symptom_list.getValue();
        if (patient == null || symptom == null) {
            SimpleErrorAlert("Invalid input", "Both patient and symptom must be selected");
            return;
        }

        // Doesn't use hibernate- idk how...
        // Raw sql rules anyway
        try (Session session = Disco.get().getSession()) {
            session.beginTransaction();
            String sql = String.format("INSERT INTO patients_symptoms (symptom_id, patient_id) VALUES (%d, %d)", symptom.getId(), patient.getId());
            session.createNativeQuery(sql).executeUpdate();
            session.getTransaction().commit();
        }

        patient_list.setValue(null);
        symptom_list.setValue(null);
    }
}
