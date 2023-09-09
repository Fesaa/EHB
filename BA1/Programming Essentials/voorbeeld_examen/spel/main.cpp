#include <iostream>

using namespace std;

struct HoleGame {
    int distance;
    int distance_left[18];
    int hit_counter;

    static HoleGame newGame() {
        int d = 100 + rand() % 700;
        return HoleGame{d, {d}, 0};
    }

    void start() {
        menu();
    }

private:

    void drive() {
        update(150, 350);
    }

    void pitch() {
        update(25, 50);
    }

    void put() {
        update(1, 10);
    }

    void update(int min, int max) {
        int yeet = min + rand() % (max - min);
        cout << "Geslagen afstand: " << yeet << endl;
        hit_counter++;
        distance = distance - yeet;
        distance_left[hit_counter] = distance;
        menu();
    }

    void toonAfstanden() {
        cout << endl;
        for (int i : distance_left) {
            if (i == 0) {
                break;
            }
            cout << i << " - ";
        }
        cout << endl;
    }

    void end_screen() {
        if (distance > 0) {
            cout << "You won! Congrats!";
        } else {
            cout << "You shot too far. :(";
        }
        toonAfstanden();
    }

    void menu() {
        if (distance < 10) {
            return end_screen();
        }

        cout << "Slag: " << hit_counter + 1 << " Afstand: " << distance_left[hit_counter] << endl;
        cout << "a) Drive"  << endl;
        cout << "b) Pitch"  << endl;
        cout << "c) Put"  << endl;

        char choice;
        cin >> choice;
        switch (choice) {
            case 'a': {
                drive();
                break;
            }
            case 'b': {
                pitch();
                break;
            }
            case 'c': {
                put();
                break;
            }
            default: {
                cout << "That's not an option. Try again."  << endl;
                return menu();
            }
        }
    }
};

int main() {
    srand(time(nullptr));

    HoleGame holeGame = HoleGame::newGame();
    holeGame.start();

    return 0;
}
