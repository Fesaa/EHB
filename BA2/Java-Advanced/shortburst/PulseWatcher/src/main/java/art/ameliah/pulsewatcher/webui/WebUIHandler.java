package art.ameliah.pulsewatcher.webui;

import org.springframework.web.socket.TextMessage;
import org.springframework.web.socket.WebSocketSession;

public class WebUIHandler {

    private final WebSocketSession session;

    public WebUIHandler(WebSocketSession session) {
        this.session = session;
    }

    public void handle(TextMessage message) {

    }

}
