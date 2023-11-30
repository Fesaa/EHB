package art.ameliah.pulsewatcher.events.lifecycle;

import art.ameliah.pulsewatcher.client.AbstractClient;
import art.ameliah.pulsewatcher.events.Event;
import com.google.gson.JsonObject;

public class RegisterClientEvent implements Event {

    AbstractClient client;

    public RegisterClientEvent(AbstractClient client) {
        this.client = client;
    }

    public AbstractClient getClient() {
        return client;
    }

    @Override
    public String toJsonString() {
        JsonObject obj = new JsonObject();
        obj.addProperty("type", "register_client");
        obj.addProperty("name", client.getName());
        obj.addProperty("sessionId", client.getSession().getId());
        obj.addProperty("active", true);
        return obj.toString();
    }
}
