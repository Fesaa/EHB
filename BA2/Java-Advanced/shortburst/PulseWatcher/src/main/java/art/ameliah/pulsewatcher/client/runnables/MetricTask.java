package art.ameliah.pulsewatcher.client.runnables;

import art.ameliah.pulsewatcher.client.AbstractClient;
import art.ameliah.pulsewatcher.proto.S2CMetricPacket;
import art.ameliah.pulsewatcher.proto.S2CPacket;
import art.ameliah.pulsewatcher.tasks.Task;


public class MetricTask extends Task {
    public MetricTask(AbstractClient client) {
        super(() -> {
            S2CMetricPacket metricPacket = S2CMetricPacket
                    .newBuilder()
                    .build();

            S2CPacket packet = S2CPacket
                    .newBuilder()
                    .setMetricPacket(metricPacket)
                    .build();

            client.send(packet);
        });
    }
}
