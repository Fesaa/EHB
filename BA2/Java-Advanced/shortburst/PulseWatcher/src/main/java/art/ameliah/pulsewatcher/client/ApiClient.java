package art.ameliah.pulsewatcher.client;

import art.ameliah.pulsewatcher.proto.APIClientMetric;
import art.ameliah.pulsewatcher.proto.C2SMetricPacket;
import art.ameliah.pulsewatcher.proto.C2SRegisterPacket;
import art.ameliah.pulsewatcher.ws.WSClientHandler;
import com.google.gson.JsonArray;
import com.google.gson.JsonObject;
import org.springframework.web.socket.CloseStatus;
import org.springframework.web.socket.WebSocketSession;

import java.util.HashMap;
import java.util.Map;

public class ApiClient extends AbstractClient {

    private final Map<Long, APIClientMetric> metrics = new HashMap<>();

    public ApiClient(WebSocketSession session, C2SRegisterPacket packet) {
        super(session, packet);
    }

    @Override
    void handleC2SMetricPacket(C2SMetricPacket packet) {
        if (packet.getMetricsCase() != C2SMetricPacket.MetricsCase.APICLIENTMETRIC) {
            WSClientHandler.get().close(getSession(), CloseStatus.BAD_DATA.withReason("Wrong metric type"));
            return;
        }

        APIClientMetric metric = packet.getApiClientMetric();
        metrics.put(System.currentTimeMillis(), metric);
    }

    @Override
    public ClientHolder.SharedData getSharedData(long time) {
        Long[] pingArray = getPings()
                .stream()
                .map(t -> (long) t.getNanos())
                .filter(t -> t > time)
                .toArray(Long[]::new);

        JsonObject[] metricArray = metrics.entrySet()
                .stream()
                .filter(e -> e.getKey() > time)
                .map(e -> {
                    APIClientMetric m = e.getValue();
                    long t = e.getKey();

                    JsonObject obj = new JsonObject();
                    obj.addProperty("host", m.getHost());
                    obj.addProperty("port", m.getPort());
                    obj.addProperty("os", m.getOs());

                    JsonArray metrics = new JsonArray();
                    m.getApiEndPointMetricsList().forEach(a -> {
                        JsonObject apiObj = new JsonObject();
                        apiObj.addProperty("endpoint", a.getEndPoint());
                        apiObj.addProperty("hits", a.getHits());
                        apiObj.addProperty("errors", a.getErrors());
                        metrics.add(apiObj);
                    });
                    obj.add("metrics", metrics);
                    obj.addProperty("time", t);

                    return obj;
                })
                .toArray(JsonObject[]::new);

        return new ClientHolder.SharedData(getName(), getSession().getId(), pingArray, metricArray, getConfig());
    }
}
