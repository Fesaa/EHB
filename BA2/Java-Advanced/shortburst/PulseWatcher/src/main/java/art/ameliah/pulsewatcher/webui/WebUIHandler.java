package art.ameliah.pulsewatcher.webui;

import art.ameliah.pulsewatcher.client.AbstractClient;
import art.ameliah.pulsewatcher.client.ClientConfig;
import art.ameliah.pulsewatcher.events.Event;
import art.ameliah.pulsewatcher.events.Subscribe;
import art.ameliah.pulsewatcher.events.lifecycle.RegisterClientEvent;
import art.ameliah.pulsewatcher.events.lifecycle.UnregisterClientEvent;
import art.ameliah.pulsewatcher.events.updates.PingResponseEvent;
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
import java.util.List;
import java.util.Map;
import java.util.logging.Level;
import java.util.logging.Logger;

public class WebUIHandler {

    private final WebSocketSession session;
    private final Logger log = Logger.getLogger(WebUIHandler.class.getName());

    public WebUIHandler(WebSocketSession session) {
        this.session = session;
    }

    public void handle(TextMessage message) {
        JsonObject msg;
        try {
            msg = (new Gson()).fromJson(message.getPayload(), JsonObject.class);
        } catch (JsonSyntaxException e) {
            log.log(Level.SEVERE, "Failed to parse JSON from " + session.getId() + "\n" + message.getPayload(), e);
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
                requestClientList(msg.getAsJsonArray("names"));
                break;
            case "requestclientinfo":
                requestClientInfo(msg);
                break;
            default:
                log.log(Level.SEVERE, "Unknown message type " + msg.get("type").getAsString() + " from " + session.getId());
                break;
        }
    }

    private void requestClientInfo(JsonObject msg) {
        JsonElement s = msg.get("session");
        if (s == null) {
            log.log(Level.SEVERE, "Invalid requestClientInfo message from " + session.getId());
            WSWebUIHandler.get().close(session, CloseStatus.BAD_DATA.withReason("Invalid requestClientInfo message"));
            return;
        }

        AbstractClient client = WSClientHandler.get().getClientHolder().getClient(s.getAsString());
        if (client == null) {
            log.log(Level.SEVERE, "Invalid requestClientInfo message from " + session.getId());
            WSWebUIHandler.get().close(session, CloseStatus.BAD_DATA.withReason("Invalid requestClientInfo message"));
            return;
        }

        JsonObject out = new JsonObject();
        out.addProperty("type", "clientInfo");
        out.add("info", client.getSharedData().toJson());
        sendTextMessage(new TextMessage(out.toString()));
    }

    private void requestClientList(JsonArray namesArray) {
        Collection<AbstractClient> activeClients = WSClientHandler.get().getClientHolder().getActiveClients();
        Map<String, Collection<Pair<CloseStatus, AbstractClient>>> inactiveClients = WSClientHandler.get().getClientHolder().getInActiveClients();
        List<String> names = namesArray == null ? null : namesArray.asList().stream().map(JsonElement::getAsString).toList();

        JsonObject out = new JsonObject();
        out.addProperty("type", "clientList");

        JsonArray array = new JsonArray();

        activeClients.stream()
                .filter(c -> names == null || names.contains(c.getName()))
                .map(AbstractClient::minimalClientInfo)
                .forEach(array::add);
        inactiveClients.values().stream()
                .flatMap(Collection::stream)
                .map(Pair::right)
                .filter(c -> names == null || names.contains(c.getName()))
                .map(AbstractClient::minimalClientInfo)
                .forEach(array::add);

        out.add("clients", array);
        sendTextMessage(new TextMessage(out.toString()));
    }

    private void requestConfigChange(JsonObject msg) {
        JsonElement sessionElement = msg.get("session");
        JsonElement configElement = msg.get("config");
        if (sessionElement == null || configElement == null) {
            log.log(Level.SEVERE, "Invalid requestConfigChange message from " + session.getId() + "no session or config");
            WSWebUIHandler.get().close(session, CloseStatus.BAD_DATA.withReason("Invalid requestConfigChange message"));
            return;
        }

        AbstractClient client = WSClientHandler.get().getClientHolder().getClient(sessionElement.getAsString());
        if (client == null) {
            log.log(Level.SEVERE, "Invalid requestConfigChange message from " + session.getId() + "no client");
            WSWebUIHandler.get().close(session, CloseStatus.BAD_DATA.withReason("Invalid requestConfigChange message"));
            return;
        }

        configElement.getAsJsonArray().forEach((el) -> {
            JsonElement nameElement = el.getAsJsonObject().get("name");
            JsonElement valueElement = el.getAsJsonObject().get("value");
            if (nameElement == null || valueElement == null) {
                log.log(Level.SEVERE, "Invalid requestConfigChange message from " + session.getId() + "no name or value");
                WSWebUIHandler.get().close(session, CloseStatus.BAD_DATA.withReason("Invalid requestConfigChange message"));
                return;
            }

            S2CChangeConfigPacket changeConfigPacket = S2CChangeConfigPacket
                    .newBuilder()
                    .setConfigField(MutableConfigField.
                            newBuilder()
                            .setName(nameElement.getAsString())
                            .setCurrentValue(valueElement.getAsString())
                            .build())
                    .build();

            S2CPacket packet = S2CPacket
                    .newBuilder()
                    .setChangeConfigPacket(changeConfigPacket)
                    .build();

            log.info("Sending config change packet to " + client.getName() + " from " + session.getId());
            client.send(packet);
        });
    }

    @Subscribe
    public void onRegisterClient(RegisterClientEvent e) {
        sendEventJson(e);
    }

    @Subscribe
    public void onUnregisterClient(UnregisterClientEvent e) {
        sendEventJson(e);
    }

    @Subscribe
    public void onPingEvent(PingResponseEvent e) {
        sendEventJson(e);
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
