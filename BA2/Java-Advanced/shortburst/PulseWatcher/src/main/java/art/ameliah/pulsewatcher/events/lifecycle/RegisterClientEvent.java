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

        JsonObject clientObj = new JsonObject();
        clientObj.addProperty("name", client.getName());
        clientObj.addProperty("sessionId", client.getSession().getId());
        clientObj.addProperty("active", true);

        obj.add("client", clientObj);
        return obj.toString();
    }
}
