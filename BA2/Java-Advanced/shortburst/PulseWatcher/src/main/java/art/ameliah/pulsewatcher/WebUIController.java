package art.ameliah.pulsewatcher;

import art.ameliah.pulsewatcher.ws.WSClientHandler;
import org.springframework.context.annotation.Bean;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.RestController;
import org.springframework.web.servlet.config.annotation.CorsRegistry;
import org.springframework.web.servlet.config.annotation.WebMvcConfigurer;

import java.util.List;

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
    public List<Service> getActiveServices() {
        return WSClientHandler.get()
                .getClientHolder()
                .getActiveClients()
                .stream()
                .map(handler -> new Service(handler.getSession().getId(), handler.getName()))
                .toList();
    }

    public record Service(String id, String name) {}

}
