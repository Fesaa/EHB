package art.ameliah.pulsewatcher.client;

import art.ameliah.pulsewatcher.proto.C2SPacket;
import art.ameliah.pulsewatcher.utils.Pair;
import org.springframework.web.socket.CloseStatus;
import org.springframework.web.socket.WebSocketSession;

import java.util.Collection;
import java.util.HashMap;
import java.util.Map;

public class ClientHolder {

    // SessionID -> Client
    private final Map<String, AbstractClient> activeClients = new HashMap<>();

    // Name -> Client
    private final Map<String, Pair<CloseStatus, AbstractClient>> inActiveClients = new HashMap<>();


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
        inActiveClients.put(client.getName(), Pair.of(status, client));

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

    public Collection<Pair<CloseStatus, AbstractClient>> getInActiveClients() {
        return inActiveClients.values();
    }

}
