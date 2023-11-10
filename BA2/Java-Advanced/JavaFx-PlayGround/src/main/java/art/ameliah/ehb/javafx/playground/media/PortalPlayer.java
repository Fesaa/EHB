package art.ameliah.ehb.javafx.playground.media;

import javafx.scene.control.Button;
import javafx.scene.control.Slider;
import javafx.scene.layout.HBox;
import javafx.scene.media.Media;
import javafx.scene.media.MediaPlayer;

import java.net.URL;

public class PortalPlayer extends HBox {

    private final MediaPlayer player;

    public PortalPlayer() {
        super();

        URL src = getClass().getResource("/Portal - Still Alive.mp3");
        if (src == null) {
            throw new RuntimeException("Couldn't find the song!");
        }

        Media song = new Media(src.toExternalForm());
        player = new MediaPlayer(song);

        getChildren().add(play());
        getChildren().add(pause());
        getChildren().add(stop());
        getChildren().add(volume());

    }

    private Button play() {
        Button play = new Button("Play");
        play.setOnAction(e -> {
            player.play();
        });
        return play;
    }

    private Button pause() {
        Button pause = new Button("Pause");
        pause.setOnAction(e -> {
            player.pause();
        });
        return pause;
    }

    private Button stop() {
        Button stop = new Button("Stop");
        stop.setOnAction(e -> {
            player.stop();
        });
        return stop;
    }

    private Slider volume() {
        Slider volume = new Slider();
        volume.setMin(0);
        volume.setMax(1);
        volume.setValue(0.5);
        volume.valueProperty().addListener((observable, oldValue, newValue) -> {
            player.setVolume(newValue.doubleValue());
        });
        return volume;
    }

}
