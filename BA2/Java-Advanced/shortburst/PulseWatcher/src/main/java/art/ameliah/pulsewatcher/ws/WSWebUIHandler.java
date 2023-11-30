package art.ameliah.pulsewatcher.ws;

import art.ameliah.pulsewatcher.events.EventsAPI;
import art.ameliah.pulsewatcher.webui.WebUIHandler;
import org.springframework.web.socket.CloseStatus;
import org.springframework.web.socket.TextMessage;
import org.springframework.web.socket.WebSocketSession;

import java.util.HashMap;
import java.util.Map;
import java.util.logging.Logger;

public class WSWebUIHandler extends AbstractWSHandler {

    private static WSWebUIHandler instance = null;
    private final Logger log = Logger.getLogger(WSWebUIHandler.class.getName());
    private Map<String, WebUIHandler> handles = new HashMap<>();

    public WSWebUIHandler() {
        instance = this;
    }

    public static WSWebUIHandler get() {
        return instance;
    }

    @Override
    public void afterConnectionEstablished(WebSocketSession session) {
        /*
        List<String> username = session.getHandshakeHeaders().get("username");
        List<String> password = session.getHandshakeHeaders().get("password");

        if (username == null || password == null) {
            close(session, CloseStatus.BAD_DATA);
            return;
        }

        if (username.size() != 1 || password.size() != 1) {
            close(session, CloseStatus.BAD_DATA);
            return;
        }

        if (!username.get(0).equals("admin") || !password.get(0).equals("admin")) {
            close(session, CloseStatus.BAD_DATA);
            return;
        }
        */

        handles.put(session.getId(), new WebUIHandler(session));
        EventsAPI.get().registerListener(handles.get(session.getId()));
    }

    @Override
    protected void handleTextMessage(WebSocketSession session, TextMessage message) {
        WebUIHandler handler = handles.get(session.getId());
        if (handler == null) {
            log.warning("Received packet from session that is not registered");
            close(session, CloseStatus.NOT_ACCEPTABLE);
            return;
        }

        handler.handle(message);
    }

    @Override
    protected void cleanup(WebSocketSession session, CloseStatus status) {
        EventsAPI.get().unregisterListener(handles.get(session.getId()));
        handles.remove(session.getId());
    }
}
