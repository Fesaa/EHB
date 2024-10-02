package art.ameliah.ehb.anki.api.services;

import art.ameliah.ehb.anki.api.models.account.User;
import art.ameliah.ehb.anki.api.models.deck.Deck;
import art.ameliah.ehb.anki.api.models.deck.query.QDeck;
import art.ameliah.ehb.anki.api.services.model.IDeckService;
import lombok.RequiredArgsConstructor;
import lombok.extern.slf4j.Slf4j;
import org.springframework.stereotype.Service;

import java.util.List;
import java.util.Optional;

@Slf4j
@Service
@RequiredArgsConstructor
public class DeckService implements IDeckService {

    @Override
    public Optional<Deck> getDeck(Long id) {
        return new QDeck().id.eq(id).findOneOrEmpty();
    }

    @Override
    public List<Deck> getDecks(User user) {
        return getDecks(user.getId());
    }

    @Override
    public List<Deck> getDecks(Long userId) {
        return new QDeck().user.id.eq(userId).findList();
    }

    @Override
    public Deck createDeck(Deck deck) {
        deck.save();
        return new QDeck()
                .id.eq(deck.getId())
                .tags.fetch()
                .cards.fetch()
                .findOne();
    }
}
