package art.ameliah.pulsewatcher.client.runnables;

import art.ameliah.pulsewatcher.client.AbstractClient;
import art.ameliah.pulsewatcher.proto.S2CPacket;
import art.ameliah.pulsewatcher.proto.S2CPingPacket;
import art.ameliah.pulsewatcher.tasks.Task;
import com.google.protobuf.Timestamp;

public class PingTask extends Task {

    public PingTask(AbstractClient client) {
        super(() -> {
            S2CPingPacket c2SPacket = S2CPingPacket
                    .newBuilder()
                    .setTimestamp(Timestamp.newBuilder().setSeconds(((int) System.currentTimeMillis()) / 1000).build())
                    .build();

            S2CPacket packet = S2CPacket
                    .newBuilder()
                    .setPingPacket(c2SPacket)
                    .build();
            client.send(packet);
        });
    }
}
