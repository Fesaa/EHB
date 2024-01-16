package art.ameliah.pulsewatcher;

import art.ameliah.pulsewatcher.events.EventsAPI;
import org.springframework.boot.SpringApplication;
import org.springframework.boot.autoconfigure.SpringBootApplication;

@SpringBootApplication
public class PulseWatcher {
    public static void main(String[] args) {
        new EventsAPI();
        SpringApplication.run(PulseWatcher.class, args);
    }
}