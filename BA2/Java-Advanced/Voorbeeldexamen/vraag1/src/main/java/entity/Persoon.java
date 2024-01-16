package entity;

import java.util.ArrayList;
import java.util.List;

public class Persoon {


    private String naam;
    private int leeftijd;
    private Dier dier;
    private int getal;
    private List<Dier.Vergunningstype> vergunningen = new ArrayList<>();

    public Persoon(String naam) {
        this.naam = naam;
    }

    public Persoon(String naam, Dier dier) {
        this.naam = naam;
        this.dier = dier;
    }

    public int getGetal() {
        return getal;
    }

    public void setGetal(int getal) {
        this.getal = getal;
    }

    public String getNaam() {
        return naam;
    }

    public void setNaam(String naam) {
        this.naam = naam;
    }

    public int getLeeftijd() {
        return leeftijd;
    }

    public void setLeeftijd(int leeftijd) {
        this.leeftijd = leeftijd;
    }

    public Dier getDier() {
        return dier;
    }

    public void setDier(Dier dier) {
        this.dier = dier;
    }

    public List<Dier.Vergunningstype> getVergunningen() {
        return vergunningen;
    }

    public void setVergunningen(List<Dier.Vergunningstype> vergunningen) {
        this.vergunningen = vergunningen;
    }

    public void addVergunningen(Dier.Vergunningstype... vergunningen)
    {
        for(Dier.Vergunningstype v : vergunningen)
        {
            this.vergunningen.add(v);
        }
    }


}
