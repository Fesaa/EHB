package art.ameliah.ehb.databases;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.SQLException;
import java.util.Random;

public class Main {

    private static final String[] RND_NAMES = {
            "Ameliah",
            "Ava",
            "Avery",
            "Bella",
            "Charlotte",
            "Chloe",
            "Ella",
            "Emma",
            "Evelyn",
            "Grace",
            "Harper",
            "Isabella",
    };

    private static Random rnd = new Random();

    private final Connection connection;

    public static void main(String[] args) throws SQLException {
        Connection connection = DriverManager.getConnection("jdbc:postgresql://localhost:5432/ehb", "ehb", "ehb_test");
        Main main = new Main(connection);
        main.createTable();
        main.insertData();
        int deleted = main.deleteDuplicates();
        System.out.println("Deleted " + deleted + " duplicate(s)");
    }

    public Main(Connection connection) {
        this.connection = connection;
    }

    public void createTable() throws SQLException {
        connection.createStatement().execute("CREATE TABLE IF NOT EXISTS test (id SERIAL PRIMARY KEY, name VARCHAR(255))");
    }

    public void insertData() throws SQLException {
        connection.createStatement().execute("INSERT INTO test (name) VALUES ('" + RND_NAMES[rnd.nextInt(RND_NAMES.length)] + "')");
    }

    public int deleteDuplicates() throws SQLException {
        return connection.createStatement().executeUpdate("DELETE FROM test WHERE id NOT IN (SELECT MIN(id) FROM test GROUP BY name)");
    }
}