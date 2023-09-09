#include <iostream>

struct Hardeschijf;
double reductor(double* gram, double size);
Hardeschijf leesHardeschijfIn();



void oefening_A() {
    std::cout << "-- Gram naar Engelse Maten –-" << std::endl;

    std::cout << "Geef een aantal gram in: ";

    int input;
    std::cin >> input;

    double gram = input;

    double pound = reductor(&gram, 450);
    double ounce = reductor(&gram, 28);
    double tablespoon = reductor(&gram, 15);
    double teaspoon = reductor(&gram, 5);
    double pinch = reductor(&gram, 0.5);


    std::cout << std::endl;
    if (pound != 0) {
        std::cout << pound << " pound" << std::endl;
    }

    if (ounce != 0) {
        std::cout << ounce << " ounce" << std::endl;
    }

    if (tablespoon != 0) {
        std::cout << tablespoon << " tablespoon" << std::endl;
    }

    if (teaspoon != 0) {
        std::cout << teaspoon << " teaspoon" << std::endl;
    }

    if (pinch != 0) {
        std::cout << pinch << " pinch" << std::endl;
    }
}

double reductor(double* gram, double size) {
    int count = 0;
    while (*gram >= size) {
        *gram -= size;
        count++;
    }
    return count;
}

struct Hardeschijf {
    std::string naam;
    double prijs;
    int opslagcapaciteit;

    void printHardeschijf() const {
        std::cout << "Hardeschijf: " << std::endl
            << "    Naam: " << naam << std::endl
            << "    Prijs: " << prijs << std::endl
            << "    Opslagcapaciteit: " << opslagcapaciteit << " gigabytes" << std::endl;
    }
};

bool operator==(const Hardeschijf& h1, const Hardeschijf& h2) {
    return h1.naam == h2.naam && h1.opslagcapaciteit == h2.opslagcapaciteit;
}

Hardeschijf leesHardeschijfIn() {
    std::string naam;
    double prijs;
    int opslagcapaciteit;

    std::cout << "Naam harde schijft: ";
    std::getline(std::cin, naam);

    std::cout << "Prijs harde schijft: ";
    std::cin >> prijs;

    std::cout << "Opslagcapaciteit harde schijft: ";
    std::cin >> opslagcapaciteit;

    return Hardeschijf{naam, prijs, opslagcapaciteit};
}

void oefening_B() {
    Hardeschijf hardeschijf = leesHardeschijfIn();
    hardeschijf.printHardeschijf();
    Hardeschijf hardeschijf2 = Hardeschijf{hardeschijf.naam, hardeschijf.prijs, hardeschijf.opslagcapaciteit};

    if (hardeschijf == hardeschijf2) {
        std::cout << "same same";
    } else {
        std::cout << "different";
    }
}

int main() {
    return 0;
}






