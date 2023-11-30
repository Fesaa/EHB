package art.ameliah.pulsewatcher.client;

import art.ameliah.pulsewatcher.client.runnables.MetricTask;
import art.ameliah.pulsewatcher.client.runnables.PingResponseTask;
import art.ameliah.pulsewatcher.client.runnables.PingTask;
import art.ameliah.pulsewatcher.proto.*;
import art.ameliah.pulsewatcher.tasks.RepeatingTaskHandler;
import art.ameliah.pulsewatcher.ws.WSClientHandler;
import com.google.gson.JsonObject;
import com.google.protobuf.Timestamp;
import org.springframework.web.socket.BinaryMessage;
import org.springframework.web.socket.CloseStatus;
import org.springframework.web.socket.WebSocketSession;

import java.io.IOException;
import java.util.ArrayDeque;
import java.util.ArrayList;
import java.util.List;
import java.util.Queue;
import java.util.logging.Level;
import java.util.logging.Logger;

public abstract class AbstractClient implements C2SPackerHandler {

    public final int DEFAULT_TRIES = 1;
    public final long PING_TIME_OUT = 5_000L;
    public final long PING_INTERVAL = 10_000L;
    protected final Logger log = Logger.getLogger(AbstractClient.class.getName());
    protected final RepeatingTaskHandler handler = new RepeatingTaskHandler();
    private final long METRIC_INTERVAL = 15_000L;
    private final WebSocketSession session;
    private final String token;
    private final String name;
    private final ClientConfig config;

    private final Queue<S2CPacket> packetQueue = new ArrayDeque<>();
    private final List<Timestamp> pings = new ArrayList<>();
    private boolean isSending = false;
    private Timestamp lastPing = null;

    public AbstractClient(WebSocketSession session, C2SRegisterPacket packet) {
        this.session = session;
        this.token = packet.getToken();
        this.name = packet.getName();
        this.config = new ClientConfig(packet.getConfig());

        handler.schedule(new PingTask(this), 0, PING_INTERVAL);
        handler.schedule(new PingResponseTask(this), PING_INTERVAL + PING_TIME_OUT, PING_INTERVAL);
        handler.schedule(new MetricTask(this), METRIC_INTERVAL, METRIC_INTERVAL);
    }

    @Override
    public WebSocketSession getSession() {
        return session;
    }

    @Override
    public String getName() {
        return name;
    }

    @Override
    public void handleCS2Packet(C2SPacket packet) {
        if (!token.equals(packet.getToken())) {
            WSClientHandler.get().close(session, CloseStatus.POLICY_VIOLATION);
            return;
        }

        switch (packet.getPacketCase()) {
            case PINGPACKET:
                handleC2SPingPacket(packet.getPingPacket());
                break;
            case METRICPACKET:
                handleC2SMetricPacket(packet.getMetricPacket());
                break;
            default:
                throw new IllegalStateException("Unexpected value: " + packet.getPacketCase());
        }
    }

    @Override
    public void close() {
        handler.stopAll();
    }

    protected void handleC2SPingPacket(C2SPingPacket packet) {

        Timestamp current = packet.getTimestamp();

        pings.add(current);
        lastPing = current;
    }

    public void send(S2CPacket packet) {
        if (session == null) {
            throw new IllegalStateException("Session is null");
        }
        if (packet == null) {
            throw new IllegalStateException("Packet is null");
        }

        if (isSending) {
            packetQueue.add(packet);
            return;
        }

        isSending = true;
        BinaryMessage msg = new BinaryMessage(packet.toByteArray());
        try {
            session.sendMessage(msg);
        } catch (IOException e) {
            log.log(Level.WARNING, "Failed to send packet", e);
        } finally {
            if (!packetQueue.isEmpty()) {
                send(packetQueue.poll());
            }
            isSending = false;
        }
    }


    public Logger getLog() {
        return log;
    }

    public Timestamp getLastPing() {
        return lastPing;
    }

    public ClientConfig getConfig() {
        return config;
    }

    public List<Timestamp> getPings() {
        return pings;
    }

    public JsonObject minimalClientInfo() {
        JsonObject obj = new JsonObject();
        obj.addProperty("name", getName());
        obj.addProperty("sessionId", getSession().getId());
        obj.addProperty("active", true);
        return obj;
    }


    abstract void handleC2SMetricPacket(C2SMetricPacket packet);

    public ClientHolder.SharedData getSharedData() {
        return getSharedData(0);
    }

    ;

    public abstract ClientHolder.SharedData getSharedData(long time);
}
