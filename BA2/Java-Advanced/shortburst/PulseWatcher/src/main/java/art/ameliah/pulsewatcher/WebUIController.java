package art.ameliah.pulsewatcher;

import art.ameliah.pulsewatcher.client.ClientHolder;
import art.ameliah.pulsewatcher.ws.WSClientHandler;
import com.google.gson.JsonArray;
import com.google.gson.JsonObject;
import org.springframework.context.annotation.Bean;
import org.springframework.http.HttpStatusCode;
import org.springframework.http.MediaType;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.RestController;
import org.springframework.web.servlet.config.annotation.CorsRegistry;
import org.springframework.web.servlet.config.annotation.WebMvcConfigurer;

import java.util.Collection;
import java.util.Map;

@RestController
public class WebUIController {

    @Bean
    public WebMvcConfigurer corsConfigurer() {
        return new WebMvcConfigurer() {
            @Override
            public void addCorsMappings(CorsRegistry registry) {
                registry.addMapping("/**").allowedOrigins("*");
            }
        };
    }

    @GetMapping(value = "/active-services")
    public ResponseEntity<String> getActiveServices() {
        Map<String, Collection<ClientHolder.SharedData>> data = WSClientHandler.get()
                .getClientHolder()
                .getDataDump();

        JsonObject out = new JsonObject();
        data.forEach((name, sharedData) -> {
            JsonArray obj = new JsonArray();
            sharedData.forEach(d -> obj.add(d.toJson()));
            out.add(name, obj);
        });

        return ResponseEntity
                .status(HttpStatusCode.valueOf(200))
                .contentType(MediaType.APPLICATION_JSON)
                .body(out.toString());
    }


}
