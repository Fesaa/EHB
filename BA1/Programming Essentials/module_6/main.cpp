#include <iostream>
#include <cmath>

void oefening_1_1() {
    float METER_TO_CENTIMETER_AREA = 10000;

    float breedte;
    float lengte;
    float tegel;

    std::cout << "Breedte van de ruimte in m: ";
    std::cin >> breedte;

    std::cout << "Lengte van de ruimte in m: ";
    std::cin >> lengte;

    std::cout << "Groote van de tegel in cm: ";
    std::cin >> tegel;

    std::cout << "U heeft " << breedte * lengte * METER_TO_CENTIMETER_AREA / (tegel * tegel) << " tegel(s) nodig om de ruimte te bedekken";
}

void oefening_1_2() {

    float afstand;
    float tijd;
    float snelheid_verschil;

    std::cout << "Begin afstand (km): ";
    std::cin >> afstand;

    std::cout << "Tijd tot samenval (min): ";
    std::cin >> tijd;

    std::cout << "Snelheids verschil (km/h): ";
    std::cin >> snelheid_verschil;

    float gemmidelde_snelheid = afstand / ( 2 * tijd);
    float snelheid_trein_een = gemmidelde_snelheid - snelheid_verschil / 2;
    float snelheid_trein_twee = gemmidelde_snelheid + snelheid_verschil / 2;

    std::cout << "Trein een reidt met een snelheid van " << snelheid_trein_een << "mk/h."
    << std::endl
    << "Trein twee reidt met een snelheid van " << snelheid_trein_twee << "km/h.";
}

void oefening_1_3() {
    float lucht_druk_hpa;
    bool druk_te_hoog;
    float temp_buiten;
    double wereld_bevolking;
    float prijs_dvd;
    int zitplaatsen;
}

void oefening_2_1() {
    int a,b=3,c=-2;
    std::cout << "Welkom bij het ‘ a ‘ste werkcollege/n";
    a = 1;
    std::cout << "Dit is mijn eerste programma";
    std::cout << "\\nnen het staat vol met fouten!\n";
    std::cout << "c maal b is " << c * b << std::endl;
    b+=c;
    std::cout << "c verhoogt met b is " << b + c;
    std::cout << "De som van de variabelen is : " << c + b;
}

void oefening_2_2() {
    float straal;
    std::cout << "Straal van uw cirkel: ";
    std::cin >> straal;
    std::cout << "Omtrek: " << 2 * M_PI * straal << " Oppervlakte: " << M_PI * straal * straal;
}

void oefening_2_3() {
    std::cout
    << "Maak een keuze: "
    << std::endl
    << "a - Einstein"
    << std::endl
    << "b - Elvis Presley"
    << std::endl
    << "c - Steve Jobs"
    << std::endl
    << "d - Bill Gates"
    << std::endl
    << "Uw keuze: "
    ;
    char keuze;
    std::cin >> keuze;
    switch (keuze) {
        case 'a': {
            std::cout << "U koos: Einstein";
            std::cout << std::endl << "Insert cool qoute!";
            break;
        }
        case 'b': {
            std::cout << "U koos: Elvis Presley";
            std::cout << std::endl << "Insert cool qoute!";
            break;
        }
        case 'c': {
            std::cout << "U koos: Steve Jobs";
            std::cout << std::endl << "Insert cool qoute!";
            break;
        }
        case 'd': {
            std::cout << "U koos: Bill Gates";
            std::cout << std::endl << "Insert cool qoute!";
            break;
        }
        default: {
            std::cout << "An error occurred!";
        }
    }

}

int make_procent(float f) {
    return (int) (f / 30 * 100);
}

void oefening_4_1() {

    float punt_1, punt_2, punt_3, punt_4, punt_5;
    std::cout << "Punt 1: ";
    std::cin >> punt_1;
    std::cout << "Punt 2: ";
    std::cin >> punt_2;
    std::cout << "Punt 3: ";
    std::cin >> punt_3;
    std::cout << "Punt 4: ";
    std::cin >> punt_4;
    std::cout << "Punt 5: ";
    std::cin >> punt_5;

    std::cout << "Procenten: "
    << make_procent(punt_1) << "%, "
    << make_procent(punt_2) << "%, "
    << make_procent(punt_3) << "%, "
    << make_procent(punt_4) << "%, "
    << make_procent(punt_5) << "%. "
    << "Gemiddelde: " << (punt_1 + punt_2 + punt_3 + punt_3 + punt_5) / 5 << ".";
}

double factorial(double i) {
    if (i == 0) {
        return 1;
    } else {
        return i * factorial(i - 1);
    }
}

// Full version, simpler versions just omit one or two if else statements
void make_triangle(int width) {
    int counter = 1;
    for (int i = 0; i < width; i++) {
        for (int j = 0; j < counter; j++) {
            if ((i + 1)% 2 == 0) {
                if ((j + 1) % 2 == 0) {
                    std::cout << "o";
                } else {
                    std::cout << "O";
                }

            } else {
                if ((j + 1) % 2 == 0) {
                    std::cout << "*";
                } else {
                    std::cout << "X";
                }
            }
        }
        counter++;
        std::cout << std::endl;
    }
}

int main() {
    /*oefening_1_1();
    std::cout << std::endl;
    oefening_1_2();
    std::cout << std::endl;
    oefening_1_3();
    std::cout << std::endl;
    oefening_2_1();
    std::cout << std::endl;
    oefening_2_2();
    std::cout << std::endl;
    oefening_2_3();
    std::cout << std::endl;
    oefening_4_1();*/
    //std::cout << factorial(50);
    make_triangle(10);
    return 0;
}



