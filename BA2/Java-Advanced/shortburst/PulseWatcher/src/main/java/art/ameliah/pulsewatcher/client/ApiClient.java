package art.ameliah.pulsewatcher.client;

import art.ameliah.pulsewatcher.proto.APIClientMetric;
import art.ameliah.pulsewatcher.proto.C2SMetricPacket;
import art.ameliah.pulsewatcher.proto.C2SRegisterPacket;
import art.ameliah.pulsewatcher.utils.Pair;
import art.ameliah.pulsewatcher.ws.WSClientHandler;
import com.google.gson.JsonArray;
import com.google.gson.JsonElement;
import com.google.gson.JsonObject;
import org.springframework.web.socket.CloseStatus;
import org.springframework.web.socket.WebSocketSession;

import java.util.HashMap;
import java.util.List;
import java.util.Map;

import static com.fasterxml.jackson.databind.type.LogicalType.Collection;

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
        Pair<Long, Long>[] pingArray = getPings()
                .stream()
                .filter(e -> e.left() > time)
                .toArray(Pair[]::new);

        JsonObject info = new JsonObject();

        APIClientMetric lastMetric = metrics.get(metrics.keySet().stream().max(Long::compareTo).orElse(0L));
        if (lastMetric != null) {
            info.addProperty("host", lastMetric.getHost());
            info.addProperty("port", lastMetric.getPort());
            info.addProperty("os", lastMetric.getOs());
        }

        JsonObject[] metricArray = metrics.entrySet()
                .stream()
                .filter(e -> e.getKey() > time)
                .map(e -> {
                    APIClientMetric metric = e.getValue();
                    long t = e.getKey();

                    JsonObject metricObj = new JsonObject();
                    metricObj.addProperty("time", t);

                    JsonArray metrics = new JsonArray();
                    metric.getApiEndPointMetricsList().stream().map(m -> {
                        JsonObject apiObj = new JsonObject();
                        apiObj.addProperty("endpoint", m.getEndPoint());
                        apiObj.addProperty("hits", m.getHits());
                        apiObj.addProperty("errors", m.getErrors());
                        return apiObj;
                    }).forEach(metrics::add);

                    metricObj.add("metrics", metrics);
                    return metricObj;
                })
                .toArray(JsonObject[]::new);

        return new ClientHolder.SharedData(getName(), getSession().getId(), pingArray, metricArray, getConfig(), info);
    }
}
