package art.ameliah.pulsewatcher.ws;

import org.springframework.web.socket.CloseStatus;
import org.springframework.web.socket.WebSocketSession;
import org.springframework.web.socket.handler.AbstractWebSocketHandler;

import java.io.IOException;
import java.util.logging.Level;
import java.util.logging.Logger;

public abstract class AbstractWSHandler extends AbstractWebSocketHandler {

    private final Logger log = Logger.getLogger(AbstractWSHandler.class.getName());

    public void close(WebSocketSession session, CloseStatus status) {
        try {
            session.close(status);
        } catch (IOException e) {
            log.log(Level.WARNING, "Failed to close session " + session.getId(), e);
        }

        cleanup(session, status);
    }

    public void afterConnectionClosed(WebSocketSession session, CloseStatus status) {
        cleanup(session, status);
    }

    protected abstract void cleanup(WebSocketSession session, CloseStatus status);

}
