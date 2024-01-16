package art.ameliah.ehb.vraag2;

import art.ameliah.ehb.vraag2.database.Disco;
import javafx.application.Application;
import javafx.fxml.FXMLLoader;
import javafx.scene.Parent;
import javafx.scene.Scene;
import javafx.stage.Stage;

import java.net.URL;

public class Main extends Application {
    public static void main(String[] args) {
      launch(args);
    }

    @Override
    public void start(Stage stage) throws Exception {
        // Init disco
        new Disco();

        FXMLLoader loader = new FXMLLoader();
        URL url = getClass().getResource("/main-scene.fxml");
        loader.setLocation(url);
        Parent root = loader.load();

        stage.setScene(new Scene(root));

        stage.setTitle("Voorbeeldexamen");
        stage.show();
    }
}