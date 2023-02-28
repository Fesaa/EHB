use std::fs::File;
use std::io::{self, ErrorKind, Read};
use std::num::IntErrorKind;


fn main() {

    // Handle the error in the program


    // Error handling by using match to go over Result<T, E>
    let greeting_file_result = File::open("hello.txt");
    let _greeting_file = match greeting_file_result {
        Ok(file) => file,
        Err(error) => match error.kind() {
            ErrorKind::NotFound => match File::create("hello.txt") {
                Ok(fc) => fc,
                Err(e) => panic!("Problem creating the file: {:?}", e),
            },
            other_error => {
                panic!("Problem opening the file: {:?}", other_error);
            }
        },
    };

    // Unwrap errors
    // "lambda"-function; |var| {func}
    let _greeting_file = File::open("hello.txt").unwrap_or_else(|error| {
        if error.kind() == ErrorKind::NotFound {
            File::create("hello.txt").unwrap_or_else(|error| {
                panic!("Problem creating the file: {:?}", error);
            })
        } else {
            panic!("Problem opening the file: {:?}", error);
        }
    });


    // Panic and exit the program. The error cannot be handled without manual interference // the big of an error to handle


    // Default error message
    let _greeting_file = File::open("hello.txt").unwrap();

    // Custom error message
    let _greeting_file = File::open("hello.txt")
        .expect("hello.txt should be included in this project");
}


// Don't handle the error, but return it as a possible outcome. Error will have to be handled by the receiver
fn _read_username_from_file() -> Result<String, io::Error> {
    let username_file_result = File::open("hello.txt");

    let mut username_file = match username_file_result {
        Ok(file) => file,
        Err(e) => return Err(e),
    };

    let mut username = String::new();

    match username_file.read_to_string(&mut username) {
        Ok(_) => Ok(username),
        Err(e) => Err(e),
    }
}

// Same as above
fn __read_username_from_file() -> Result<String, io::Error> {

    // The ? operator returns the function with the error if one is present. And returns is Ok() value to the var if not.
    // Can de used on more than Result. But can only be used if the return type of the function allows it.
    // Option<T> can be used with ?, it will return the None option. 
    let mut username_file = File::open("hello.txt")?;
    let mut username = String::new();
    username_file.read_to_string(&mut username)?;
    Ok(username)
}

// Chaining ? operator
// Not extremely clear what's happening as ? is quite easily overlooked.
fn ___read_username_from_file() -> Result<String, io::Error> {
    let mut username = String::new();

    File::open("hello.txt")?.read_to_string(&mut username)?;

    Ok(username)
}


// Custom u32 type to force a number between 1 and 100
// Returning a Result to give the user the option how to react to the not valid Guess
// let guess: u32 = Guess::new(guess.trim().parse()?)?.value();
pub struct Guess {
    value: u32
}

impl Guess {
    pub fn new(value: u32) -> Result<Guess, IntErrorKind> {
        if value > 0 && value < 101 {
            return Ok(Guess { value });
        } 

        Err(IntErrorKind::InvalidDigit)
    }

    pub fn value(&self) -> u32 {
        self.value
    }
}
