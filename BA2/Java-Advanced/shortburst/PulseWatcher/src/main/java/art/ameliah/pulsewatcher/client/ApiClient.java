package art.ameliah.pulsewatcher.client;

import art.ameliah.pulsewatcher.proto.C2SRegisterPacket;
import art.ameliah.pulsewatcher.ws.WSClientHandler;
import art.ameliah.pulsewatcher.proto.APIClientMetric;
import art.ameliah.pulsewatcher.proto.C2SMetricPacket;
import org.springframework.web.socket.CloseStatus;
import org.springframework.web.socket.WebSocketSession;

import java.util.HashMap;
import java.util.List;
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

    public List<APIClientMetric> metricsAfter(long time) {
        return metrics.entrySet()
                .stream()
                .filter(e -> e.getKey() > time)
                .map(Map.Entry::getValue)
                .toList();
    }
}
