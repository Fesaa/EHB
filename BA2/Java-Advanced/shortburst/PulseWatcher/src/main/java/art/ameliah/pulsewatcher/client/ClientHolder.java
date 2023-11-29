package art.ameliah.pulsewatcher.client;

import art.ameliah.pulsewatcher.proto.C2SPacket;
import art.ameliah.pulsewatcher.utils.Pair;
import com.google.gson.JsonArray;
import com.google.gson.JsonObject;
import org.springframework.web.socket.CloseStatus;
import org.springframework.web.socket.WebSocketSession;

import java.util.*;

public class ClientHolder {

    // SessionID -> Client
    private final Map<String, AbstractClient> activeClients = new HashMap<>();

    // Name -> Client
    private final Map<String, Collection<Pair<CloseStatus, AbstractClient>>> inActiveClients = new HashMap<>();

    public void registerClient(WebSocketSession session, AbstractClient client) {
        activeClients.put(session.getId(), client);
    }

    public void unregisterClient(WebSocketSession session, CloseStatus status) {
        AbstractClient client = activeClients.get(session.getId());
        if (client == null) {
            throw new IllegalStateException("Cannot unregister client that is not registered");
        }
        activeClients.remove(session.getId());
        client.close();
        inActiveClients.computeIfAbsent(client.getName(),k -> new ArrayList<>()).add(Pair.of(status, client));

    }


    public boolean handle(WebSocketSession session, C2SPacket packet) {
        AbstractClient client = activeClients.get(session.getId());
        if (client == null) {
            return false;
        }

        client.handleCS2Packet(packet);
        return true;
    }

    public Collection<AbstractClient> getActiveClients() {
        return activeClients.values();
    }

    public Map<String, Collection<Pair<CloseStatus, AbstractClient>>> getInActiveClients() {
        return inActiveClients;
    }

    public Map<String, Collection<SharedData>> getDataDump() {
        return getDataDump(0);
    }

    public Map<String, Collection<SharedData>> getDataDump(long time) {
        Map<String, Collection<SharedData>> data = new HashMap<>();

        for (AbstractClient client : getActiveClients()) {
            data.computeIfAbsent(client.getName(), k -> new ArrayList<>())
                    .add(client.getSharedData(time));
        }

        for (var set : getInActiveClients().values()) {
            for (var pair : set) {
                data.computeIfAbsent(pair.right().getName(), k -> new ArrayList<>())
                        .add(pair.right().getSharedData(time).setActive(false));
            }
        }

        return data;
    }

    public AbstractClient getClient(String sessionID) {
        for (AbstractClient client : getActiveClients()) {
            if (client.getSession().getId().equals(sessionID)) {
                return client;
            }
        }
        return null;
    }

    public static class SharedData {

        private final String name;
        private final String sessionID;
        private final Long[] pings;
        private final JsonObject[] metrics;
        private final ClientConfig config;

        private boolean active = true;

        public SharedData(String name, String sessionID, Long[] pings, JsonObject[] metrics, ClientConfig config) {
            this.name = name;
            this.sessionID = sessionID;
            this.pings = pings;
            this.metrics = metrics;
            this.config = config;
        }

        public SharedData setActive(boolean active) {
            this.active = active;
            return this;
        }

        public JsonObject toJson() {
            JsonObject obj = new JsonObject();
            obj.addProperty("name", name);
            obj.addProperty("session_id", sessionID);

            JsonArray pings = new JsonArray();
            for (Long ping : this.pings) {
                pings.add(ping);
            }
            obj.add("pings", pings);

            JsonObject metrics = new JsonObject();
            for (JsonObject metric : this.metrics) {
                metrics.add(metric.get("time").getAsString(), metric);
            }
            obj.add("metrics", metrics);
            if (active) {
                obj.add("config", config.toJson());
            }

            obj.addProperty("Active", active);

            return obj;
        }
    }

}
