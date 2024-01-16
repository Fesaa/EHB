package art.ameliah.ehb.vraag2.utils;

import javafx.scene.control.Alert;

public class JavaFXUtils {

    public static void DispatchAlert(Alert.AlertType type, String title, String header, String content) {
        Alert alert = new Alert(type);
        alert.setTitle(title);
        alert.setHeaderText(header);
        alert.setContentText(content);
        alert.showAndWait();
    }

    public static void SimpleErrorAlert(String header, String content) {
        DispatchAlert(Alert.AlertType.ERROR, header, header, content);
    }

    public static void SimpleInfoAlert(String header, String content) {
        DispatchAlert(Alert.AlertType.INFORMATION, header, header, content);
    }

}
