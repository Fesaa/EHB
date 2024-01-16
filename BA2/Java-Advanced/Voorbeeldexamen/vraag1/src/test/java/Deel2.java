import entity.*;
import org.junit.Test;


import java.util.*;
import java.util.function.Consumer;
import java.util.function.Function;
import java.util.function.Predicate;
import java.util.stream.Collectors;

import static org.junit.Assert.*;


public class Deel2 {


    //Schrijf een consumer die er voor zorgt dat de de laatste twee characters van alle strings uit een List van strings wordt verwijderd

    @Test
    public void consumer_1() {

        Consumer<List<String>> edit = l -> {
            for (int i = 0; i < l.size(); i++) {
                String s = l.get(i);
                l.set(i, s.substring(0, s.length() - 2));
            }
        };
        List<String> list = new ArrayList<>(Arrays.asList("Joske", "Bertje", "Jeanke"));

        edit.accept(list);

        assertEquals("Jos", list.get(0));
        assertEquals("Bert", list.get(1));
        assertEquals("Jean", list.get(2));
    }

    //Schrijf een function die een Kat omvormt tot een Hond en zijn naam laat beginnen met Hond
    @Test
    public void function_1() {

        //Pas aan
        Function<Kat, Hond> transform = cat -> new Hond("Hond" + cat.getNaam());

        String naam = "Garfield";
        Kat h = new Kat(naam);

        Dier d = transform.apply(h);
        assertTrue(d instanceof Hond);
        assertEquals("HondGarfield", d.getNaam());
    }

    //Schrijf een predicate die enkel true terugstuurt als een persoon geen huisdier heeft (null) of wanneer hij wel een huisdier bezit, maar hij de juiste vergunning heeft of het dier vergunningstype GEEN heeft.
    @Test
    public void predicate_1() {

        Predicate<Persoon> controleer = p -> {
            if (p.getDier() == null) {
                return true;
            }
            Dier animal = p.getDier();
            if (animal.getVergunning() == Dier.Vergunningstype.GEEN) {
                return true;
            }
            return p.getVergunningen().contains(animal.getVergunning());
        };

        Persoon p1 = new Persoon("Jef", new Hond("Samson"));
        Persoon p2 = new Persoon("Jos");
        Persoon p3 = new Persoon("Jan", new Kat("Shadow"));
        Persoon p4 = new Persoon("Jimmy", new GiftigeSlang("Ka"));
        Persoon p5 = new Persoon("Jil", new GiftigeSlang("Ka"));
        p5.addVergunningen(Dier.Vergunningstype.MILEUVERGUNNING);

        assertTrue(controleer.test(p1));
        assertTrue(controleer.test(p2));
        assertTrue(controleer.test(p3));
        assertFalse(controleer.test(p4));
        assertTrue(controleer.test(p5));
    }


    //Verwijder alle personen uit de lijst die een GiftigeSlang hebben als huisdier.
    @Test
    public void predicate_2() {

        List<Persoon> personen = new ArrayList<>(Arrays.asList(
                new Persoon("Jef", new Hond("Samson")),
                new Persoon("Jos"),
                new Persoon("Jan", new Kat("Shadow")),
                new Persoon("Jimmy", new GiftigeSlang("Ka")),
                new Persoon("Jil", new GiftigeSlang("Ka")),
                new Persoon("Jeremy", new Kat("Garfield"))
        ));

        //Pas aan
        personen.removeIf(p -> p.getDier() instanceof GiftigeSlang);

        assertFalse(personen.stream().anyMatch((p) -> p.getNaam().equals("Jimmy") || p.getNaam().equals("Jil")));
        assertEquals(personen.size(), 4);
    }

    class Planeet
    {
        private String naam;
        private int grootte;
        private double gewicht;

        public Planeet(String naam, int grootte, double gewicht) {
            this.naam = naam;
            this.grootte = grootte;
            this.gewicht = gewicht;
        }
    }

    private List<Planeet> planeten = Arrays.asList(
            new Planeet("Aarde", 3, 2.2),
            new Planeet("Aarde", 4, 2.2),
            new Planeet("Tatooine", 3, 2.2),
            new Planeet("Coruuscant", 20, 2.2),
            new Planeet("Hoth", 20, 2.2),
            null,
            new Planeet("Naboo", 4, 2.2),
            new Planeet("Coruuscant", 2, 5.2),
            null,
            new Planeet("Alderaan", 3, 8),
            new Planeet("Kashyyyk", 77, 7),
            new Planeet("Yavin", 33, 3)
    );

    //Schrijf een Comparator dat Planeten vergelijkt op grootte en daarna op gewicht. als een planeet wordt vergeleken met null is de null kleiner (eerst)
    @Test
    public void comparator_1() {
        Comparator<Planeet> vglplaneet = (p1, p2) -> {
            if (p2 == null) {
                return 1;
            }
            if (p1 == null) {
                return -1;
            }
            if (p1.grootte != p2.grootte) {
                return p1.grootte - p2.grootte;
            }
            if (p1.gewicht != p2.gewicht) {
                return (int) (p1.gewicht - p2.gewicht);
            }
            return 0;
        };

        assertTrue(vglplaneet.compare(planeten.get(3), planeten.get(4)) == 0);
        assertTrue(vglplaneet.compare(planeten.get(2), planeten.get(9)) < 0);

        planeten.sort(vglplaneet);

        assertEquals(planeten.get(0), null);
        assertEquals(planeten.get(1), null);
        assertEquals(planeten.get(2).naam, "Coruuscant");
        assertEquals(planeten.get(planeten.size()-1).naam, "Kashyyyk");
    }

    // Implementeer een functie die alle planeten die groter zijn dan 25 en een a hebben in hun naam (niet hoofdlettergevoelig) gaat samensmelten in één string (elke planeet wordt gevolgd door een komma en een spatie).
    // Gebruik hiervoor een stream. Doe dit in één statement. (één schakeling van stream functies)
    @Test
    public void toonBepaaldePlaneten()
    {
        //vul aan
        String s =  planeten
                .stream()
                .filter(Objects::nonNull)
                .filter(p -> p.grootte > 25)
                .filter(p -> p.naam.toLowerCase().contains("a"))
                .map(p -> p.naam + ", ")
                .collect(Collectors.joining());
        assertEquals("Kashyyyk, Yavin, ", s);
    }

    @Test
    // Gebruik een stream om van een lijst van strings te gaan naar een lijst van planeten. De strings hebben volgende format: <naam planeet>:<grootte planeet>:<gewicht planeet>
    // Doe dit in één statement. (één aaneenschakeling van stream functies)
    public void mapPlaneten()
    {
        List<String> splaneten = Arrays.asList(
                "Aarde:2:10",
                "Venus:2:8",
                "Mars:3:8.5",
                "Jupiter:2:7.6",
                "Venus:30:10.5");

        //vul aan
        List<Planeet> planeten = splaneten.
                stream()
                .map(s -> s.split(":"))
                .map(l -> {
                    String name = l[0];
                    Integer grootte = Integer.parseInt(l[1]);
                    Double gewicht = Double.parseDouble(l[2]);
                    return new Planeet(name, grootte, gewicht);
                })
                .toList();

        assertEquals(planeten.get(3).naam, "Jupiter");
        assertEquals(planeten.get(3).grootte, 2);
        assertEquals(planeten.get(3).gewicht, 7.6, 0);
    }
}
