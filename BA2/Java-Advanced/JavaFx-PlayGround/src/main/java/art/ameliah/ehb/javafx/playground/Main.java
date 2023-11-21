package art.ameliah.ehb.javafx.playground;

import art.ameliah.ehb.javafx.playground.media.PortalPlayer;
import javafx.application.Application;
import javafx.scene.Scene;
import javafx.stage.Stage;


public class Main extends Application {
    public static void main(String[] args) {
       launch(args);
    }

    @Override
    public void start(Stage stage) throws Exception {
        stage.setTitle("Hello world!");
        stage.setScene(new Scene(new PortalPlayer()));
        stage.setHeight(300);
        stage.setWidth(300);
        stage.show();
    }
}