// Item will be passed when the trait is implemented
pub trait Iterator {
    type Item;

    fn next(&mut self) -> Option<Self::Item>;
}

struct Counter {
    numbers: [u32]
}

impl Iterator for Counter {
    type Item = u32;

    fn next(&mut self) -> Option<Self::Item> {
        // Impl
        Option::None
    }
}

use std::ops::Add;

#[derive(Debug, Copy, Clone, PartialEq)]
struct Point {
    x: i32,
    y: i32,
}

// Implements non function traits
// Like implementing __add__ in python on a class
impl Add for Point {
    type Output = Point;

    fn add(self, other: Point) -> Point {
        Point {
            x: self.x + other.x,
            y: self.y + other.y,
        }
    }
}

trait Pilot {
    fn fly(&self);
}

trait Wizard {
    fn fly(&self);
}

struct Human;

impl Pilot for Human {
    fn fly(&self) {
        println!("This is your captain speaking.");
    }
}

impl Wizard for Human {
    fn fly(&self) {
        println!("Up!");
    }
}

impl Human {
    fn fly(&self) {
        println!("*waving arms furiously*");
    }
}

trait Animal {
    fn baby_name() -> String;
}

struct Dog;

impl Dog {
    fn baby_name() -> String {
        String::from("Spot")
    }
}

impl Animal for Dog {
    fn baby_name() -> String {
        String::from("puppy")
    }
}

use std::fmt;

// : fmt::Display is the super trait
// i.e. any types implementing OutlinePrint
// Have to implement fmt::Display 
trait OutlinePrint: fmt::Display {
    fn outline_print(&self) {
        let output = self.to_string();
        let len = output.len();
        println!("{}", "*".repeat(len + 4));
        println!("*{}*", " ".repeat(len + 2));
        println!("* {} *", output);
        println!("*{}*", " ".repeat(len + 2));
        println!("{}", "*".repeat(len + 4));
    }
}

impl fmt::Display for Point {
    fn fmt(&self, f: &mut fmt::Formatter) -> fmt::Result {
        write!(f, "({}, {})", self.x, self.y)
    }
}

impl OutlinePrint for Point {}

// Cheats the needed internal trait or type rule
struct Wrapper(Vec<String>);

impl fmt::Display for Wrapper {
    fn fmt(&self, f: &mut fmt::Formatter) -> fmt::Result {
        // self.0 accesses the actual vec
        // join method on an iterable
        // !!! Different from python where
        // join is called on a string and takes a 
        // iterable !!
        write!(f, "[{}]", self.0.join(", "))
    }
}

fn main() {
    assert_eq!(
        Point { x: 1, y: 0 } + Point { x: 2, y: 3 },
        Point { x: 3, y: 3 }
    );

    // Pas default parameter explicitly
    // to use overloaded functions
    let person = Human;
    Pilot::fly(&person);
    Wizard::fly(&person);
    person.fly();

    // Calling functions impl directly
    // on types without a self 
    // Is possible
    println!("A baby dog is called a {}", Dog::baby_name());


    // Trait impls need extra syntax
    // Looks a bit info and out of place
    // <> isn't used anywhere else I think
    // Makes me wonder if this would remove any
    // Unique dog functions or only 
    // Overwrite those impl for Animal
    println!("A baby dog is called a {}", <Dog as Animal>::baby_name());

    Point{x: 10, y: 20}.outline_print();

    let w = Wrapper(vec![String::from("hello"), String::from("world")]);
    println!("w = {}", w);
}

