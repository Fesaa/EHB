package art.ameliah.pulsewatcher.ws;

import art.ameliah.pulsewatcher.client.AbstractClient;
import art.ameliah.pulsewatcher.client.ClientConfig;
import art.ameliah.pulsewatcher.events.EventsAPI;
import art.ameliah.pulsewatcher.events.RegisterClientEvent;
import art.ameliah.pulsewatcher.events.Subscribe;
import art.ameliah.pulsewatcher.proto.MutableConfigField;
import art.ameliah.pulsewatcher.proto.S2CChangeConfigPacket;
import art.ameliah.pulsewatcher.proto.S2CPacket;
import art.ameliah.pulsewatcher.webui.WebUIHandler;
import org.springframework.web.socket.CloseStatus;
import org.springframework.web.socket.TextMessage;
import org.springframework.web.socket.WebSocketSession;

import java.util.HashMap;
import java.util.List;
import java.util.Map;
import java.util.logging.Logger;

public class WSWebUIHandler extends AbstractWSHandler {

    private static WSWebUIHandler instance = null;

    public WSWebUIHandler() {
        instance = this;

        EventsAPI.get().registerListener(this);
    }

    public static WSWebUIHandler get() {
        return instance;
    }

    private final Logger log = Logger.getLogger(WSWebUIHandler.class.getName());

    private Map<String, WebUIHandler> handles = new HashMap<>();

    @Subscribe
    public void onRegisterClient(RegisterClientEvent e) {
        log.info("Registering client " + e.getClient().getName());
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
        handles.remove(session.getId());
    }

    private void requestConfigChange(String sessionID, ClientConfig.Field field) {
        AbstractClient client = WSClientHandler.get().getClientHolder().getClient(sessionID);
        if (client == null) {
            throw new IllegalStateException("Cannot request config change for client that is not registered");
        }

        S2CChangeConfigPacket changeConfigPacket = S2CChangeConfigPacket
                .newBuilder()
                .setConfigField(MutableConfigField.
                        newBuilder()
                        .setName(field.name())
                        .setCurrentValue(field.value())
                        .build())
                .build();

        S2CPacket packet = S2CPacket
                .newBuilder()
                .setChangeConfigPacket(changeConfigPacket)
                .build();

        client.send(packet);

    }
}
