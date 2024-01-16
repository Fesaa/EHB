package art.ameliah.ehb.vraag2.controllers.menu;

import art.ameliah.ehb.vraag2.controllers.MainScene;
import art.ameliah.ehb.vraag2.ui.PatientsTable;
import art.ameliah.ehb.vraag2.ui.RelationChart;
import art.ameliah.ehb.vraag2.ui.SymptomsTable;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.scene.control.Button;
import javafx.scene.layout.AnchorPane;

public class Data {

    @FXML
    public Button symptoms;
    public Button patients;
    public Button graph;

    AnchorPane display;

    @FXML
    public void initialize() {
        symptoms.addEventHandler(ActionEvent.ACTION, this::displaySymptoms);
        patients.addEventHandler(ActionEvent.ACTION, this::displaysPatients);
        graph.addEventHandler(ActionEvent.ACTION, this::displayGraph);
    }

    public void displaySymptoms(ActionEvent e) {
        if (display == null) {
            display = MainScene.getInstance().getDisplay();
        }

        display.getChildren().clear();
        display.getChildren().add(new SymptomsTable());
    }

    public void displaysPatients(ActionEvent e) {
        if (display == null) {
            display = MainScene.getInstance().getDisplay();
        }

        display.getChildren().clear();
        display.getChildren().add(new PatientsTable());
    }

    public void displayGraph(ActionEvent e) {
        if (display == null) {
            display = MainScene.getInstance().getDisplay();
        }

        display.getChildren().clear();
        display.getChildren().add(new RelationChart());
    }
}
