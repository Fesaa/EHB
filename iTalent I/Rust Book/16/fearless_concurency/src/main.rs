use std::thread;
use std::time::Duration;

fn main() {
    let handle = thread::spawn(|| {
        for i in 1..10 {
            println!("Hi number {} from the spawned thread!", i);
            thread::sleep(Duration::from_millis(1));
        }
    });

    for i in 1..5 {
        println!("Hi number {} from the main thread!", i);
        thread::sleep(Duration::from_millis(1));
    }

    handle.join().unwrap();

    let v = vec![1, 2, 3];

    // Remember! move forces handle_2 to take ownership of all values used
    let handle_2 = thread::spawn(move || {
        println!("Here is a vector created in the main thread {:?}", v)
    });

    handle_2.join().unwrap();
}