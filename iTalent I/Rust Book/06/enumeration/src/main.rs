

enum IpAddrKind {
    V4(u8, u8, u8, u8),
    V6(String),
}

enum Message {
    Quit,
    Move { x: i32, y: i32 },
    Write(String),
    ChangeColor(i32, i32, i32),
}

impl Message {
    fn call(&self) {
        match &self {
            Message::Quit => println!("QUITED"),
            Message::Move { x, y } => println!("({}, {})", x, y),
            Message::Write(s) => println!("{}", s),
            Message::ChangeColor(_, _, _) => println!("Pretty colours UwU"),
        }
    }

    // Option is better than being able to return None
    // since you'll match some value of Some out and always check for None. Option<T> won't be able to be used.
    fn maybe(&self) -> Option<bool> {
        match &self {
            Message::Quit => Some(true),
            Message::ChangeColor(_, _, _) => Some(false),
            _ => None,
        }
    }
}


fn main() {
    let _home = IpAddrKind::V4(192, 168, 0, 1);
    let _loopback = IpAddrKind::V6(String::from("::1"));

    let m = Message::Write(String::from("hello"));
    m.call();

    match m.maybe() {
        Some(_) => println!("<3"),
        None => println!("</3"),
    }

    // if let workflow
    let config_max = Some(3u8);
    if let Some(max) = config_max {
        println!("The maximum is configured to be {}", max);
    }
}
