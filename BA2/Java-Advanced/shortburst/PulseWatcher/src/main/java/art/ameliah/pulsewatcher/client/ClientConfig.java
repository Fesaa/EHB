package art.ameliah.pulsewatcher.client;

import art.ameliah.pulsewatcher.proto.Config;
import com.google.gson.JsonArray;
import com.google.gson.JsonObject;

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

    public JsonObject toJson() {
        JsonObject obj = new JsonObject();

        JsonArray fields = new JsonArray();
        for (Field field : getFields()) {
            JsonObject fieldObj = new JsonObject();
            fieldObj.addProperty("name", field.name());
            fieldObj.addProperty("value", field.value());
            fields.add(fieldObj);
        }

        JsonArray mutableFields = new JsonArray();
        for (Field field : getMutableFields()) {
            JsonObject fieldObj = new JsonObject();
            fieldObj.addProperty("name", field.name());
            fieldObj.addProperty("value", field.value());
            mutableFields.add(fieldObj);
        }

        obj.add("fields", fields);
        obj.add("mutableFields", mutableFields);

        return obj;
    }

}
