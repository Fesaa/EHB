package art.ameliah.ehb.vraag2.controllers.menu;

import art.ameliah.ehb.vraag2.database.Disco;
import art.ameliah.ehb.vraag2.database.entity.Patient;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.scene.control.Button;
import javafx.scene.control.TextField;

import static art.ameliah.ehb.vraag2.utils.JavaFXUtils.SimpleErrorAlert;

public class Patients {

    @FXML
    public Button submit;
    public TextField name;
    public TextField age;

    @FXML
    public void initialize() {
        submit.addEventHandler(ActionEvent.ACTION, this::onSubmit);
    }

    public void onSubmit(ActionEvent e) {
        if (name.getText().isEmpty() || age.getText().isEmpty()) {
            SimpleErrorAlert("Invalid input", "Patient must have a name");
            return;
        }
        int a;
        try {
            a = Integer.parseInt(age.getText());
        } catch (NumberFormatException ex) {
            SimpleErrorAlert("Invalid input", "Age must be a number");
            return;
        }


        Patient patient = new Patient(name.getText(), a);
        Disco.get().save(patient);

        name.setText("");
        age.setText("");
    }
}
