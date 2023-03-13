#include <iostream>
void change(int number);
void change(int* number);
void printNumber(int number);

void swap(int& a, int& b);

void pas_aan(int& a, int& b);
void pas_aan(int* a, int* b);

void min_max(int a, int b, int& min, int& max);
void min_max(int a, int b, int* min, int* max);

void order(int* a, int* b, int* c);

int& max_of_two(int& a, int& b);

int& RareFunctie(int x, int& y);

int main() {
    int number = 75;
    printNumber(number);
    change(number);
    printNumber(number);
    change(&number);
    printNumber(number);
    std::cout << std::endl;

    int a = 5;
    int b = 9;
    std::cout << a << " & " << b << std::endl;
    swap(a, b);
    std::cout << a << " & " << b << std::endl;
    std::cout << std::endl;

    pas_aan(a, b);
    std::cout << a << " & " << b << std::endl;
    std::cout << std::endl;

    b = 10;
    a = 7;
    std::cout << a << " & " << b << std::endl;
    pas_aan(&a, &b);
    std::cout << a << " & " << b << std::endl;
    std::cout << std::endl;

    int min;
    int max;

    b = 10;
    a = 7;
    std::cout << a << " & " << b << std::endl;
    min_max(a, b, min, max);
    std::cout << "Min: " << min << " Max: " << max << std::endl;
    std::cout << std::endl;

    a = 3;
    b = 2;
    std::cout << a << " & " << b << std::endl;
    min_max(a, b, &min, &max);
    std::cout << "Min: " << min << " Max: " << max << std::endl;
    std::cout << std::endl;

    int n1 = 7;
    int n2 = 3;
    int n3 = 5;
    order(&n1, &n2, &n3);
    std::cout << n1 << n2 << n3 << std::endl;
    std::cout << std::endl;

    int x = 50;
    int y = 100;
    // Change the value of the highest number to 25
    // What kind of dark magic is this
    // Don't think this is very readable, or clear what it does lol
    max_of_two(x, y) = 25;


    int i = 1, j = 2;
    RareFunctie(i, j)++;
    std::cout << "a = " << i << " // b = " << j << std::endl;
    RareFunctie(j, i)++;
    std::cout << "a = " << i << " // b = " << j << std::endl;

    int* g = nullptr;
    std::cout << *g << std::endl;

    return 0;
}

void change(int number) {
    number = 150;
}

void change(int* number) {
    *number = 150;
}

void printNumber(int number) {
    std::cout << "The number currently is: " << number << std::endl;
}

void swap(int& a, int& b) {
    int help = a;
    a = b;
    b = help;
}

void pas_aan(int& a, int& b) {
    if (a < b) {
        b -= a;
        a = 0;
    } else {
        a -= b;
        b = 0;
    }
}

void pas_aan(int* a, int* b) {
    if (*a < *b) {
        *b -= *a;
        *a = 0;
    } else {
        *a -= *b;
        *b = 0;
    }
}

void min_max(int a, int b, int& min, int& max) {
    if (a < b) {
        min = a;
        max = b;
    } else {
        min = b;
        max = a;
    }
}

void min_max(int a, int b, int* min, int* max) {
    if (a < b) {
        *min = a;
        *max = b;
    } else {
        *min = b;
        *max = a;
    }
}

void order(int* a, int* b, int* c) {
    if (*a > *b) {
        swap(*a, *b);
    }
    if (*b > *c) {
        swap(*b, *c);
    }

    if (!(*a < *b && *b < *c)) {
        order(a, b, c);
    }
}

int& max_of_two(int& a, int& b) {
    if (a < b) {
        return b;
    } else {
        return a;
    }
}

int& RareFunctie(int x, int& y){
    if ( x > y ) {
        return x;
    }
    return y;
}
