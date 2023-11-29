package art.ameliah.pulsewatcher.utils;

public record Pair<T, U>(T t, U u) {

    public T left() {
        return t;
    }

    public U right() {
        return u;
    }

    public static <T, U> Pair<T, U> of(T t, U u) {
        return new Pair<>(t, u);
    }

}
