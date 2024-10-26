package art.ameliah.ehb.anki.api.dtos.session;

import lombok.Getter;
import lombok.Setter;

@Setter
@Getter
public class SessionAnswerDto {

    Long id;

    Long cardId;

    String answer;

    Boolean correct;

}