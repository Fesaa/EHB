package art.ameliah.pulsewatcher.tasks;


import java.util.HashSet;
import java.util.Set;
import java.util.Timer;

public class RepeatingTaskHandler {

    private final Set<Timer> timers = new HashSet<>();

    public void schedule(Task task, long delay, long period) {
        Timer timer = new Timer();
        timer.schedule(task, delay, period);
        timers.add(timer);
    }

    public void stopAll() {
        timers.forEach(Timer::cancel);
    }

}
