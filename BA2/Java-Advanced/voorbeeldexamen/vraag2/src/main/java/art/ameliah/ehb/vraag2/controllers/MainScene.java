package art.ameliah.ehb.vraag2.controllers;

import art.ameliah.ehb.vraag2.Main;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.scene.control.TitledPane;
import javafx.scene.layout.AnchorPane;

public class MainScene {

    @FXML
    public AnchorPane display;

    private static MainScene instance;
    public TitledPane sys;
    public TitledPane pat;
    public TitledPane link;
    public TitledPane data;

    public static MainScene getInstance() {
        if (instance == null) {
            throw new RuntimeException("Instance is null");
        }
        return instance;
    }

    @FXML
    public void initialize() {
        instance = this;

        // Doesn't work, not sure which event lol.
        sys.addEventHandler(ActionEvent.ACTION, this::clearDisplay);
        pat.addEventHandler(ActionEvent.ACTION, this::clearDisplay);
        link.addEventHandler(ActionEvent.ACTION, this::clearDisplay);
    }

    public void clearDisplay(ActionEvent e) {
        display.getChildren().clear();
    }

    public AnchorPane getDisplay() {
        return display;
    }
}
