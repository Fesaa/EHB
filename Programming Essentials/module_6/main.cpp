#include <iostream>

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
    float snelheidVerschil;

    std::cout << "Begin afstand (km): ";
    std::cin >> afstand;

    std::cout << "Tijd tot samenval (min): ";
    std::cin >> tijd;

    std::cout << "Snelheids verschil (km/h): ";
    std::cin >> snelheidVerschil;

    std::cout << "De tweede trein is " << "" << " sneller dan de eerste.";
}

int main() {
    oefening_1_1();
    oefening_1_2();

    return 0;
}



