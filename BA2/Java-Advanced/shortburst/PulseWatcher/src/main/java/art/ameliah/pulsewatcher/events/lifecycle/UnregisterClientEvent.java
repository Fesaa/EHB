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
        obj.addProperty("name", client.getName());
        obj.addProperty("active", false);
        obj.addProperty("status", status.getCode());
        obj.addProperty("reason", status.getReason());
        return obj.toString();
    }
}
