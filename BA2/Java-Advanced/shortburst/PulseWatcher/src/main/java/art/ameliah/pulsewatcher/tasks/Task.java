package art.ameliah.pulsewatcher.tasks;

import java.util.TimerTask;

public class Task extends TimerTask {

    private final Runnable run;

    public Task(Runnable run) {
        this.run = run;
    }

    @Override
    public void run() {
        run.run();
    }
}
