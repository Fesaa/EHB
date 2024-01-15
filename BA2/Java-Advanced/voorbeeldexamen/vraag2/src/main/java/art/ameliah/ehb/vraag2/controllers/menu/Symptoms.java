package art.ameliah.ehb.vraag2.controllers.menu;

import art.ameliah.ehb.vraag2.database.Disco;
import art.ameliah.ehb.vraag2.database.entity.Symptom;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.scene.control.Alert;
import javafx.scene.control.Button;
import javafx.scene.control.TextArea;
import javafx.scene.control.TextField;
import org.hibernate.Session;

public class Symptoms {

    @FXML
    public TextField name;
    public TextArea desc;
    public Button submit;

    @FXML
    public void initialize() {
        submit.addEventHandler(ActionEvent.ACTION, this::onSubmit);
    }

    public void onSubmit(ActionEvent e) {
        if (name.getText().isEmpty() || desc.getText().isEmpty()) {
            Alert alert = new Alert(Alert.AlertType.ERROR);
            alert.setTitle("Invalid input");
            alert.setHeaderText("Invalid input");
            alert.setContentText("Please fill in all fields");
            alert.showAndWait();
            return;
        }
        Symptom symptom = new Symptom(name.getText(), desc.getText());
        Disco.get().save(symptom);
    }
}
