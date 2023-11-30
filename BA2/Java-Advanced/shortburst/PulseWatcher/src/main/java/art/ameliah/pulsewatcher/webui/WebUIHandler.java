package art.ameliah.pulsewatcher.webui;

import art.ameliah.pulsewatcher.client.AbstractClient;
import art.ameliah.pulsewatcher.client.ClientConfig;
import art.ameliah.pulsewatcher.events.Event;
import art.ameliah.pulsewatcher.events.Subscribe;
import art.ameliah.pulsewatcher.events.lifecycle.RegisterClientEvent;
import art.ameliah.pulsewatcher.events.lifecycle.UnregisterClientEvent;
import art.ameliah.pulsewatcher.proto.MutableConfigField;
import art.ameliah.pulsewatcher.proto.S2CChangeConfigPacket;
import art.ameliah.pulsewatcher.proto.S2CPacket;
import art.ameliah.pulsewatcher.utils.Pair;
import art.ameliah.pulsewatcher.ws.WSClientHandler;
import art.ameliah.pulsewatcher.ws.WSWebUIHandler;
import com.google.gson.*;
import org.springframework.web.socket.CloseStatus;
import org.springframework.web.socket.TextMessage;
import org.springframework.web.socket.WebSocketSession;

import java.io.IOException;
import java.util.Collection;
import java.util.Map;
import java.util.logging.Level;
import java.util.logging.Logger;

public class WebUIHandler {

    private final WebSocketSession session;
    private final Logger log = Logger.getLogger(WebUIHandler.class.getName());
    private String currentFocus = "";

    public WebUIHandler(WebSocketSession session) {
        this.session = session;
    }

    public void handle(TextMessage message) {
        JsonObject msg;
        try {
            msg = (new Gson()).fromJson(message.getPayload(), JsonObject.class);
        } catch (JsonSyntaxException e) {
            log.log(Level.SEVERE, "Failed to parse JSON from " + session.getId(), e);
            return;
        }

        if (!msg.has("type")) {
            log.log(Level.SEVERE, "Invalid message from " + session.getId());
            WSWebUIHandler.get().close(session, CloseStatus.BAD_DATA.withReason("Invalid message"));
            return;
        }

        switch (msg.get("type").getAsString().toLowerCase()) {
            case "requestconfigchange":
                requestConfigChange(msg);
                break;
            case "requestclientlist":
                requestClientList();
                break;
            case "setcurrentfocus":
                setCurrentFocus(msg);
                break;
            default:
                log.log(Level.SEVERE, "Unknown message type " + msg.get("type").getAsString() + " from " + session.getId());
                break;
        }
    }

    private void setCurrentFocus(JsonObject msg) {
        JsonElement focus = msg.get("focus");
        if (focus == null) {
            log.log(Level.SEVERE, "Invalid setCurrentFocus message from " + session.getId());
            WSWebUIHandler.get().close(session, CloseStatus.BAD_DATA.withReason("Invalid setCurrentFocus message"));
            return;
        }

        currentFocus = focus.getAsString();
    }

    private void requestClientList() {
        Collection<AbstractClient> activeClients = WSClientHandler.get().getClientHolder().getActiveClients();
        Map<String, Collection<Pair<CloseStatus, AbstractClient>>> inactiveClients = WSClientHandler.get().getClientHolder().getInActiveClients();

        JsonArray out = new JsonArray();

        activeClients.stream()
                .map(AbstractClient::minimalClientInfo)
                .forEach(out::add);
        inactiveClients.values().stream()
                .flatMap(Collection::stream)
                .map(Pair::right)
                .map(AbstractClient::minimalClientInfo)
                .forEach(out::add);

        sendTextMessage(new TextMessage(out.toString()));
    }

    private void requestConfigChange(JsonObject msg) {
        JsonElement fieldName = msg.get("field");
        JsonElement fieldValue = msg.get("value");
        if (fieldName == null || fieldValue == null) {
            log.log(Level.SEVERE, "Invalid requestConfigChange message from " + session.getId());
            WSWebUIHandler.get().close(session, CloseStatus.BAD_DATA.withReason("Invalid requestConfigChange message"));
            return;
        }

        ClientConfig.Field field = new ClientConfig.Field(fieldName.getAsString(), fieldValue.getAsString());

        AbstractClient client = WSClientHandler.get().getClientHolder().getClient(session.getId());
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

    @Subscribe
    public void onRegisterClient(RegisterClientEvent e) {
        if (currentFocus.isEmpty() || currentFocus.equals(e.getClient().getSession().getId())) {
            sendEventJson(e);
        }
    }

    @Subscribe
    public void onUnregisterClient(UnregisterClientEvent e) {
        if (currentFocus.isEmpty() || currentFocus.equals(e.getClient().getSession().getId())) {
            sendEventJson(e);
        }
    }

    private void sendEventJson(Event e) {
        sendTextMessage(new TextMessage(e.toJsonString()));
    }

    public void sendTextMessage(TextMessage msg) {
        try {
            session.sendMessage(msg);
        } catch (IOException e) {
            log.log(Level.SEVERE, "Failed to send message to " + session.getId(), e);
        }
    }

    public WebSocketSession getSession() {
        return session;
    }
}
