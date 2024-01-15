module vraag2 {
    requires org.hibernate.orm.core;
    requires jakarta.persistence;
    requires java.naming;
    requires javafx.controls;
    requires javafx.fxml;

    opens art.ameliah.ehb.vraag2.database to org.hibernate.orm.core;
    opens art.ameliah.ehb.vraag2.database.entity to org.hibernate.orm.core;

    exports art.ameliah.ehb.vraag2;
    opens art.ameliah.ehb.vraag2 to javafx.fxml;

    exports art.ameliah.ehb.vraag2.controllers;
    opens art.ameliah.ehb.vraag2.controllers to javafx.fxml;

    exports art.ameliah.ehb.vraag2.controllers.menu;
    opens art.ameliah.ehb.vraag2.controllers.menu to javafx.fxml;
}