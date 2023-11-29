package art.ameliah.pulsewatcher.client.runnables;

import art.ameliah.pulsewatcher.ws.WSClientHandler;
import art.ameliah.pulsewatcher.client.AbstractClient;
import art.ameliah.pulsewatcher.tasks.Task;
import com.google.protobuf.Timestamp;
import org.springframework.web.socket.CloseStatus;


public class PingResponseTask extends Task {
    public PingResponseTask(AbstractClient client) {
        super(() -> {
            if (!client.getSession().isOpen()) {
                return;
            }

            Timestamp lastPing = client.getLastPing();
            if (lastPing == null || (lastPing.getSeconds() < ((int) System.currentTimeMillis())/1000 - client.PING_TIME_OUT)) {
                WSClientHandler.get().close(client.getSession(), CloseStatus.SESSION_NOT_RELIABLE);
            }
        });
    }
}
