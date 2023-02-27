#include <iostream>

void jokerTrekking() {
    std::srand(std::time(nullptr));

    std::cout
    << "Jokertrekking: "
    << std::rand() % 9
    << " "
    << std::rand() % 9
    << std::rand() % 9
    << std::rand() % 9
    << " "
    << std::rand() % 9
    << std::rand() % 9
    << std::rand() % 9
    ;
}

void tekenRechthoek() {
    while (true ){
        char ch;
        int width;
        int height;
        std::cout << "Geef een teken: ";
        std::cin >> ch;
        std::cout << "Geef de hoogt (0 om te stoppen): ";
        std::cin >> height;
        if (height == 0) {
            break;
        }
        std::cout << "Geeft de breedte: ";
        std::cin >> width;
        for (int i = 0; i < height; i++) {
            for (int j = 0; j < width; j++) {
                if (j % (width - 1) == 0) {
                    std::cout << ch;
                } else {
                    if (i % (height - 1) == 0) {
                        std::cout << ch;
                    } else {
                        std::cout << " ";
                    }
                }
            }
            std::cout << std::endl;
        }

    }
}

int nThFibonacciNumber(unsigned int n) {
    if (n == 0)  {
        return 0;
    } else if (n == 1) {
        return 1;
    } else {
        return nThFibonacciNumber(n - 1) + nThFibonacciNumber(n - 2);
    }
}

int main() {
    time_t start = std::time(nullptr);
    std::cout << start;
    std::cout << std::endl;
    std::cout << "Hello, World!" << std::endl;
    jokerTrekking();
    std::cout << std::endl;
    //tekenRechthoek();
    std::cout << std::endl;
    for (int i = 0; i < 20; i++) {
        std::cout << nThFibonacciNumber(i) << ", ";
    }
    std::cout << std::endl;

    return 0;
}
