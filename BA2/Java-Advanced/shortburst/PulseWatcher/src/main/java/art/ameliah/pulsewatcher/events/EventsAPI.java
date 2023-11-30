package art.ameliah.pulsewatcher.events;

import java.lang.reflect.Method;
import java.util.*;
import java.util.logging.Logger;

public class EventsAPI {

    private static final ArrayList<Method> EMPTY = new ArrayList<>();

    private static EventsAPI instance = null;

    private final Map<Object, Map<Class<Event>, Collection<Method>>> listeners = new HashMap<>();
    private final Logger log = Logger.getLogger(EventsAPI.class.getName());

    public EventsAPI() {
        if (instance != null) {
            throw new RuntimeException("EventsAPI already initialized");
        }
        instance = this;
    }

    public static EventsAPI get() {
        if (instance == null) {
            throw new RuntimeException("EventsAPI not initialized");
        }
        return instance;
    }

    public void fire(Event event) {
        Objects.requireNonNull(event, "event cannot be null");
        log.info("Firing event " + event.getClass().getName());
        Class<? extends Event> eventClass = event.getClass();
        listeners.forEach((key, value) -> value.getOrDefault(eventClass, EMPTY)
                .forEach(method -> {
                    try {
                        method.invoke(key, event);
                    } catch (Exception e) {
                        throw new RuntimeException("Error invoking event handler", e);
                    }
                }));
    }

    public void unregisterListener(Object listener) {
        Objects.requireNonNull(listener, "listener cannot be null");
        listeners.remove(listener);
    }


    public void registerListener(Object listener) {
        Objects.requireNonNull(listener, "listener cannot be null");

        Method[] methods = listener.getClass().getMethods();
        for (Method method : methods) {
            if (!method.isAnnotationPresent(Subscribe.class)) {
                continue;
            }

            Class<?>[] parameters = method.getParameterTypes();
            if (parameters.length != 1) {
                throw new RuntimeException("Method " + method.getName() + " has @Subscribe annotation but does not have exactly one parameter");
            }

            Class<?> eventClass = parameters[0];
            if (!Event.class.isAssignableFrom(eventClass)) {
                throw new RuntimeException("Method " + method.getName() + " has @Subscribe annotation but parameter is not an Event");
            }

            listeners.computeIfAbsent(listener, k -> new HashMap<>())
                    .computeIfAbsent((Class<Event>) eventClass,
                            k -> new ArrayList<>())
                    .add(method);
        }
    }

}
