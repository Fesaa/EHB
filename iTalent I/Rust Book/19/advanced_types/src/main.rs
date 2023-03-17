
type Thunk = Box<dyn Fn() + Send + 'static>;

fn takes_long_type(f: Thunk) {
    // --snip--
}

fn returns_long_type() -> Thunk {
    // --snip--
    Box::new(|| println!("hi"))
}

fn add_one(x: i32) -> i32 {
    x + 1
}

// Functions are first class types in rust, hooray
// Different from Rust Book code
// This actually does the function twice
// The book adds it
fn do_twice(f: fn(i32) -> i32, arg: i32) -> i32 {
    f(f(arg))
}


fn main() {
    let answer = do_twice(add_one, 5);

    println!("The answer is: {}", answer);

    let f: Thunk = Box::new(|| println!("hi"));
}
