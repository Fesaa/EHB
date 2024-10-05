package art.ameliah.ehb.anki.api.models.account;

import io.ebean.annotation.NotNull;
import lombok.Getter;

import jakarta.persistence.Entity;
import jakarta.persistence.Id;

@Getter
@Entity
public class Role {

    @Id
    Long id;

    @NotNull
    String name;

    public static Role of(String name) {
        Role role = new Role();
        role.name = name;
        return role;
    }

}
