package art.ameliah.pulsewatcher.events.lifecycle;

import art.ameliah.pulsewatcher.client.AbstractClient;
import art.ameliah.pulsewatcher.events.Event;
import com.google.gson.JsonObject;
import org.springframework.web.socket.CloseStatus;

public class UnregisterClientEvent implements Event {

    private final AbstractClient client;
    private final CloseStatus status;

    public UnregisterClientEvent(AbstractClient client, CloseStatus status) {
        this.client = client;
        this.status = status;
    }

    public AbstractClient getClient() {
        return client;
    }

    public CloseStatus getStatus() {
        return status;
    }

    @Override
    public String toJsonString() {
        JsonObject obj = new JsonObject();
        obj.addProperty("type", "unregister_client");

        JsonObject clientObj = new JsonObject();
        clientObj.addProperty("name", client.getName());
        clientObj.addProperty("sessionId", client.getSession().getId());
        clientObj.addProperty("active", false);
        clientObj.addProperty("reason", status.getReason());

        obj.add("client", clientObj);
        return obj.toString();
    }
}
