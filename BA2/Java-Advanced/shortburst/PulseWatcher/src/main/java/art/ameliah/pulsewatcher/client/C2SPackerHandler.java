package art.ameliah.pulsewatcher.client;

import art.ameliah.pulsewatcher.proto.*;
import org.springframework.web.socket.WebSocketSession;

public interface C2SPackerHandler {

    void handleCS2Packet(C2SPacket packet);

    void close();

    WebSocketSession getSession();

    String getName();

}
