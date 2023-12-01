package art.ameliah.pulsewatcher.events.updates;

import art.ameliah.pulsewatcher.client.AbstractClient;
import art.ameliah.pulsewatcher.events.Event;
import com.google.gson.JsonObject;

public class PingResponseEvent implements Event {

    private final AbstractClient client;

    private final long ping;
    private final long time;

    public PingResponseEvent(AbstractClient client, long ping, long time) {
        this.client = client;
        this.ping = ping;
        this.time = time;
    }

    public AbstractClient getClient() {
        return client;
    }

    @Override
    public String toJsonString() {
        JsonObject obj = new JsonObject();
        obj.addProperty("type", "ping_response");

        JsonObject clientObj = new JsonObject();
        clientObj.addProperty("name", client.getName());
        clientObj.addProperty("sessionId", client.getSession().getId());
        obj.addProperty("ping", ping);
        obj.addProperty("time", time);

        obj.add("client", clientObj);

        return obj.toString();
    }
}
