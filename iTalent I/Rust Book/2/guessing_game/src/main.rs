use std::io;
use rand::Rng;

fn main() {
    println!("Guess the number!");

    let secret_number = rand::thread_rng().gen_range(1..=100);

    loop {
        println!("Please input your guess.");

        let mut guess: String = String::new();

        io::stdin()
            .read_line(&mut guess)
            .expect("Failed to read line");

        // Removing this infers secret_number to i32. Auto changes it, very cool!
        let guess: u32 = match guess.trim().parse() {
            Ok(num) => num,
            Err(_) => {
                // Cannot compute anything inside {}, unlike in Python f formatted strings
                println!("Could not parse {} to a number. Please try again.", guess.trim());
                continue;
            },
        };

        println!("You guessed: {guess}");

        // cmp => compares 
        match guess.cmp(&secret_number) {
            std::cmp::Ordering::Less => println!("Too small!"),
            std::cmp::Ordering::Greater => println!("Too big!"),
            std::cmp::Ordering::Equal => {
                println!("You win!");
                break;
            },
        }
    }
    
}
