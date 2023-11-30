package art.ameliah.pulsewatcher.events;

import art.ameliah.pulsewatcher.client.AbstractClient;

public class RegisterClientEvent implements Event{

    AbstractClient client;

    public RegisterClientEvent(AbstractClient client) {
        this.client = client;
    }

    public AbstractClient getClient() {
        return client;
    }

}
