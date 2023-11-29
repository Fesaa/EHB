package art.ameliah.pulsewatcher.client;

import art.ameliah.pulsewatcher.proto.Config;

public class ClientConfig {

    private final Field[] fields;

    private final Field[] mutableFields;

    public ClientConfig(Config config) {

        this.fields = config.getFieldsList()
                .stream()
                .map(f -> new Field(f.getName(), f.getValue()))
                .toArray(Field[]::new);

        this.mutableFields = config.getMutableFieldsList()
                .stream()
                .map(f -> new Field(f.getName(), f.getCurrentValue()))
                .toArray(Field[]::new);
    }

    public Field[] getFields() {
        return fields;
    }

    public Field[] getMutableFields() {
        return mutableFields;
    }

    public record Field(String name, String value) {

    }

}
