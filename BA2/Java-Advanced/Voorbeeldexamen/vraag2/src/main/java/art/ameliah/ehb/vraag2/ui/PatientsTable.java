package art.ameliah.ehb.vraag2.ui;

import art.ameliah.ehb.vraag2.database.Disco;
import art.ameliah.ehb.vraag2.database.entity.Patient;
import javafx.beans.property.SimpleStringProperty;
import javafx.beans.value.ObservableValue;
import javafx.collections.FXCollections;
import javafx.collections.ObservableList;
import javafx.scene.control.TableColumn;
import javafx.scene.control.TableView;
import javafx.util.Callback;

import java.util.function.Function;

public class PatientsTable extends TableView<Patient> {

    ObservableList<Patient> patients;

    public PatientsTable() {
        patients = FXCollections.observableArrayList(Disco.get().getTable(Patient.class));

        TableColumn<Patient, String> id = new TableColumn<>("id");
        id.setCellValueFactory(getFactory(p -> String.valueOf(p.getId())));
        TableColumn<Patient, String> name = new TableColumn<>("Name");
        name.setCellValueFactory(getFactory(Patient::getName));
        TableColumn<Patient, String> age = new TableColumn<>("age");
        age.setCellValueFactory(getFactory(p -> String.valueOf(p.getAge())));

        getColumns().add(id);
        getColumns().add(name);
        getColumns().add(age);
        setItems(patients);
    }

    private Callback<TableColumn.CellDataFeatures<Patient, String>, ObservableValue<String>> getFactory(Function<Patient, String> f) {
        return s -> new SimpleStringProperty(f.apply(s.getValue()));
    }

}
