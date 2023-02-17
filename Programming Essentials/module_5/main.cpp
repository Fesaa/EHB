#include <iostream>

int main() {
    int celsius;
    std::cout << "Geef graden Celsius: ";
    std::cin >> celsius;
    std::cout << "Dit is " << 1.8 * celsius + 32 << " graden Fahrenheit.";

    return 0;
}
