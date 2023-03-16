struct Point {
    x: i32,
    y: i32,
}

struct Point3D {
    x: i32,
    y: i32,
    z: i32,
}

enum Color {
    Rgb(i32, i32, i32),
    Hsv(i32, i32, i32),
}

enum Message {
    Quit,
    Move { x: i32, y: i32 },
    Write(String),
    ChangeColor(Color),
}


fn main() {
    let favorite_color: Option<&str> = None;
    let is_tuesday = false;
    let age: Result<u8, _> = "34".parse();

    if let Some(color) = favorite_color {
        println!("Using your favorite color, {color}, as the background");
    } else if is_tuesday {
        println!("Tuesday is green day!");
    } else if let Ok(age) = age {
        if age > 30 {
            println!("Using purple as the background color");
        } else {
            println!("Using orange as the background color");
        }
    } else {
        println!("Using blue as the background color");
    }

    let mut stack = Vec::new();

    stack.push(1);
    stack.push(2);
    stack.push(3);

    while let Some(top) = stack.pop() {
        println!("{}", top);
    }

    let v = vec!['a', 'b', 'c'];

    for (index, value) in v.iter().enumerate() {
        println!("{} is at index {}", value, index);
    }

    let x = Some(5);
    let y = 10;

    match x {
        Some(50) => println!("Got 50"),
        Some(y) => println!("Matched, y = {y}"),
        _ => println!("Default case, x = {:?}", x),
    }

    println!("at the end: x = {:?}, y = {y}", x);


    let p = Point { x: 0, y: 7 };

    // Black magic matching
    // Creates new variables matching the values of the fields
    // With variables the name of the fields unless specified
    let Point { x, y } = p;
    assert_eq!(0, x);
    assert_eq!(7, y);

    let Point { x: a, y: b } = p;
    assert_eq!(0, a);
    assert_eq!(7, b);

    // Hot stuff
    // This is really really cool
    match p {
        Point { x, y: 0 } => println!("On the x axis at {x}"),
        Point { x: 0, y } => println!("On the y axis at {y}"),
        Point { x, y } => {
            println!("On neither axis: ({x}, {y})");
        }
    }

    let msg = Message::ChangeColor(Color::Hsv(0, 160, 255));

    // Can match the inner struct directly
    // These match stuff are so cool and clear what they do
    match msg {
        Message::ChangeColor(Color::Rgb(r, g, b)) => {
            println!("Change color to red {r}, green {g}, and blue {b}");
        }
        Message::ChangeColor(Color::Hsv(h, s, v)) => {
            println!("Change color to hue {h}, saturation {s}, value {v}")
        }
        _ => (),
    }

    // Kinda cool, but looks horrible and isn't very clear what it's doing lol
    let ((_feet, _inches), Point { x: _, y: _ }) = ((3, 10), Point { x: 3, y: -10 });


    let numbers = (2, 4, 8, 16, 32);
    // Ignoring some stuff
    match numbers {
        (first, _, third, _, fifth) => {
            println!("Some numbers: {first}, {third}, {fifth}")
        }
    }

    let s = Some(String::from("Hello!"));

    // Use _ to not move ownership 
    if let Some(_) = s {
        println!("found a string");
    }

    println!("{:?}", s);

    let origin = Point3D { x: 0, y: 0, z: 0 };
    let numbers = (2, 4, 8, 16, 32);

    // .. always matched rest of the struct, tuple, ..
    match origin {
        Point3D { x, .. } => println!("x is {}", x),
    }

    match numbers {
        (first, .., last) => {
            println!("Some numbers: {first}, {last}");
        }
    }

    let num = Some(4);

    // Called match guards
    // Extra if condition for the match to be valid
    match num {
        Some(x) if x % 2 == 0 => println!("The number {} is even", x),
        Some(x) => println!("The number {} is odd", x),
        None => (),
    }

    enum TestEnum {
        Hello { id: i32 },
    }

    let msg = TestEnum::Hello { id: 5 };

    // @ lets you bind the matched value in a range to a var to be used
    // Cool, but kinda wack syntax
    match msg {
        TestEnum::Hello {
            id: id_variable @ 3..=7,
        } => println!("Found an id in range: {}", id_variable),
        TestEnum::Hello { id: 10..=12 } => {
            println!("Found an id in another range")
        }
        TestEnum::Hello { id } => println!("Found some other id: {}", id),
    }


}
