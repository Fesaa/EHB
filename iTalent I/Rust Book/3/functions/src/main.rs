fn main() {
    print_labeled_measurement(5, 'h');


    // {} is an expression and thus returns 4
    let y = {
        let x = 3;
        x + 1 // No semicolon! Adding one makes it a statement rather than an expression
    };

    println!("The value of y is: {y} and five in numbers is {}", five());
}

fn print_labeled_measurement(value: i32, unit_label: char) {
    println!("The measurement is: {value}{unit_label}");
}

// Python like syntax to declare return value
fn five() -> i32 {
    5 // Explicit return like in scheme <=> last expression
}
