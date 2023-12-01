package art.ameliah.pulsewatcher.ws;


import art.ameliah.pulsewatcher.client.AbstractClient;
import art.ameliah.pulsewatcher.client.ApiClient;
import art.ameliah.pulsewatcher.client.ClientHolder;
import art.ameliah.pulsewatcher.proto.C2SPacket;
import art.ameliah.pulsewatcher.proto.C2SRegisterPacket;
import art.ameliah.pulsewatcher.proto.S2CPacket;
import art.ameliah.pulsewatcher.proto.S2CRegisterPacket;
import com.google.protobuf.InvalidProtocolBufferException;
import org.springframework.web.socket.BinaryMessage;
import org.springframework.web.socket.CloseStatus;
import org.springframework.web.socket.WebSocketSession;

import java.util.HashMap;
import java.util.Map;
import java.util.UUID;
import java.util.logging.Level;
import java.util.logging.Logger;

public class WSClientHandler extends AbstractWSHandler {

    private static WSClientHandler instance = null;
    private final Logger log = Logger.getLogger(WSClientHandler.class.getName());
    private final Map<String, String> preC2SRegisterSessions = new HashMap<>();
    private final ClientHolder clientHolder = new ClientHolder();

    public WSClientHandler() {
        instance = this;
    }

    public static WSClientHandler get() {
        return instance;
    }

    @Override
    public void afterConnectionEstablished(WebSocketSession session) throws Exception {

        String token = UUID.randomUUID().toString();

        S2CRegisterPacket packet = S2CRegisterPacket
                .newBuilder()
                .setToken(token)
                .build();

        S2CPacket s2CPacket = S2CPacket
                .newBuilder()
                .setRegisterPacket(packet)
                .build();

        BinaryMessage msg = new BinaryMessage(s2CPacket.toByteArray());
        session.sendMessage(msg);

        preC2SRegisterSessions.put(session.getId(), token);
    }

    @Override
    protected void handleBinaryMessage(WebSocketSession session, BinaryMessage message) {
        C2SPacket packet;
        try {
            packet = C2SPacket.parseFrom(message.getPayload());
        } catch (InvalidProtocolBufferException e) {
            log.log(Level.WARNING, "Failed to parse C2SRegisterPacket", e);
            close(session, CloseStatus.BAD_DATA);
            return;
        }

        log.log(Level.INFO, "Received packet on sessions " + session.getId() + " with case " + packet.getPacketCase());

        if (packet.getPacketCase() == C2SPacket.PacketCase.REGISTERPACKET) {
            handleC2SRegisterPacket(session, packet.getRegisterPacket());
        } else if (!clientHolder.handle(session, packet)) {
            log.warning("Received packet from session that is not registered");
            close(session, CloseStatus.NOT_ACCEPTABLE);
        }
    }

    private void handleC2SRegisterPacket(WebSocketSession session, C2SRegisterPacket packet) {
        String token = preC2SRegisterSessions.get(session.getId());
        if (token == null || !token.equals(packet.getToken())) {
            log.warning("Received register packet with invalid token or is not registered");
            close(session, CloseStatus.NOT_ACCEPTABLE.withReason("Invalid token"));
            return;
        }

        AbstractClient C2SPackerHandler;
        switch (packet.getClientType()) {
            case API_CLIENT -> C2SPackerHandler = new ApiClient(session, packet);
            default -> {
                log.warning("Received C2SRegisterPacket with unknown client type");
                close(session, CloseStatus.NOT_ACCEPTABLE);
                return;
            }
        }
        clientHolder.registerClient(session, C2SPackerHandler);
        preC2SRegisterSessions.remove(session.getId());
    }


    @Override
    protected void cleanup(WebSocketSession session, CloseStatus status) {
        log.info("Removing " + session.getId() + " with reason " + status.getCode()
                + " " + status.getReason() + " from trackers.");

        clientHolder.unregisterClient(session, status);
        preC2SRegisterSessions.remove(session.getId());
    }

    public ClientHolder getClientHolder() {
        return clientHolder;
    }
}
