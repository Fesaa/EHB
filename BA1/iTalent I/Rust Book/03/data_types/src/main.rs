fn main() {
    // Needs type annotation!
    let guess: u32 = "42".parse().expect("Not a number!");

    // addition
    let sum = 5 + 10;

    // subtraction
    let difference = 95.5 - 4.3;

    // multiplication
    let product = 4 * 30;

    // division
    let quotient = 56.7 / 32.2;
    let truncated = -5 / 3; // Results in -1 because 5 & 3 act as integers

    // remainder
    let remainder = 43 % 5;

    println!("{}, {}, {}, {}, {}, {}, {}", guess, sum, difference, product, quotient, truncated, remainder);

    let tup = (500, 6.4, 1);

    let (x, y, z) = tup;

    println!("The value of y is: {y}. The other elements are {} {} {} {}", tup.0, x, tup.2, z);

    // Arrays have a fixed length! Vectors can change
    //let a = [1, 2, 3, 4, 5];

}

