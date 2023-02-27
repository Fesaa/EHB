#include <iostream>


bool isPerfect(int i) {
    int sum = 0;
    for (int div = 0; div <= i /2 + 1; div++) {
        if (i % div == 0) {
            sum += div;
        }
    }
    return sum == i;
}

int zoekMin(int i) {
    if (i < 0) {
        i = -i;
    }
    int min = 10;
    do {
        int rest = i % 10;
        i = (i-rest)/10;
        if (rest < min) {
            min = rest;
        }
    } while (i != 0);

return min;
}

void oefening_1_3() {
    for (int i = 0; i < 10; i++) {
        for (int j = 0; j < 10; j++) {
            if (j * 10 + 6 + j * 10 + i == i * 10 + j) {
                std::cout << j << "&" << i << std::endl;
            }
        }
    }
}

int main() {
    std::cout << isPerfect(1) << std::endl;
    std::cout << zoekMin(985);
    std::cout << std::endl;
    oefening_1_3();

    return 0;
}
