package entity;

public class Dier {

    public enum Vergunningstype { MILEUVERGUNNING, OMGEVINGSVERGUNNING, GEEN};

    private String naam;
    private Vergunningstype vergunning;

    public Dier(String naam) {
        vergunning = Vergunningstype.GEEN;
        this.naam = naam;
    }

    public Dier(String naam, Vergunningstype vergunning) {
        this.naam = naam;
        this.vergunning = vergunning;
    }

    public Vergunningstype getVergunning() {
        return vergunning;
    }

    public void setVergunning(Vergunningstype vergunning) {
        this.vergunning = vergunning;
    }

    public String getNaam() {
        return naam;
    }

    public void setNaam(String naam) {
        this.naam = naam;
    }
}
