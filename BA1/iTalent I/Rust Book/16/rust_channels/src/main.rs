use std::sync::mpsc;
use std::thread;
use std::time::Duration;

fn main() {
    let (tx, rx) = mpsc::channel();

    thread::spawn(move || {
        let val = String::from("Hi cuties <3");
        tx.send(val).unwrap();

        let vals = vec![
            String::from("How"),
            String::from("are"),
            String::from("you"),
            String::from("doing"),
            String::from("today?")
        ];

        for val in vals {
            tx.send(val).unwrap();
            thread::sleep(Duration::from_secs(1));
        }
    });

    let received = rx.recv().unwrap();
    println!("Got: {}", received);

    for received in rx {
        println!("Got: {}", received);
    }
}
