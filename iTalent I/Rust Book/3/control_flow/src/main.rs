fn main() {
    let mut counter = 0;

    let result = loop {
        counter += 1;

        if counter == 10 {
            // counter * 2 will be returned by loop and thus assigned to result
            break counter * 2;
        }
    };

    println!("The result is {result}");

    let mut count = 0;
    'counting_up: loop {
        println!("count = {count}");
        let mut remaining = 10;

        loop {
            println!("remaining = {remaining}");
            if remaining == 9 {
                // Stops "smallest" loop
                break;
            }
            if count == 2 {
                // Stops top loop
                break 'counting_up;
            }
            remaining -= 1;
        }

        count += 1;
    }
    println!("End count = {count}");

    // 1..4 returns a Range, calling .rev reverses it.
    for number in (1..4).rev() {
        println!("{number}!");
    }
    println!("LIFTOFF!!!");

    println!("{}", fahrenheit_to_celsius(1.0));

    // No () around the Range needed if we're not calling a function on it
    for n in 1..10 {
        println!("{}", fibonacci_number(n));
    }
}

fn fahrenheit_to_celsius(f: f32) -> f32 {
    (5.0 / 9.0) * (f - 32.0)
}

fn fibonacci_number(n: u32) -> u32 {
    if n == 1 {
        1
    } else if n == 2 {
        1
    } else {
        fibonacci_number(n - 1) + fibonacci_number(n - 2)
    }
}
