package art.ameliah.ehb.vraag2.ui;

import art.ameliah.ehb.vraag2.database.Disco;
import art.ameliah.ehb.vraag2.database.entity.Symptom;
import javafx.beans.property.SimpleStringProperty;
import javafx.beans.value.ObservableValue;
import javafx.collections.FXCollections;
import javafx.collections.ObservableList;
import javafx.scene.control.*;
import javafx.util.Callback;

import java.util.List;
import java.util.function.Function;


public class SymptomsTable extends TableView<Symptom> {

    ObservableList<Symptom> symptoms;

    public SymptomsTable() {
        symptoms = FXCollections.observableArrayList(Disco.get().getTable(Symptom.class));

        TableColumn<Symptom, String> name = new TableColumn<>("Name");
        name.setCellValueFactory(getFactory(Symptom::getName));
        TableColumn<Symptom, String>  desc = new TableColumn<>("Description");
        desc.setCellValueFactory(getFactory(Symptom::getDesc));
        getColumns().add(name);
        getColumns().add(desc);
        setItems(symptoms);
    }

    private Callback<TableColumn.CellDataFeatures<Symptom, String>, ObservableValue<String>> getFactory(Function<Symptom, String> f) {
        return s -> new SimpleStringProperty(f.apply(s.getValue()));
    }

}
