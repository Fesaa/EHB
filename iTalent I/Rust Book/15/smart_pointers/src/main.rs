// !! Does not compile !!
// enum List {
// Cons(i32, List),
// Nil,
// }
// Rust can't know how much memory this might take, so it won't compile.

enum List {
    Cons(i32, Box<List>),
    Nil,
}

impl List {

    pub fn display(&self, i : u32) {
        match self {
            Cons(value, cont) => {
                println!("Layer {} has value: {}", i, value);
                cont.display(i+1);
            },
            Nil => println!("End of List"),
        }
        
    }
}


use crate::List::{Cons, Nil};

struct MyBox<T>(T);

impl<T> MyBox<T> {
    fn new(x: T) -> MyBox<T> {
        MyBox(x)
    }
}

use std::ops::Deref;

impl<T> Deref for MyBox<T> {
    type Target = T;

    fn deref(&self) -> &Self::Target {
        &self.0
    }
}

struct CustomSmartPointer {
    data: String,
}

impl Drop for CustomSmartPointer {
    fn drop(&mut self) {
        println!("Dropping CustomSmartPointer with data `{}`!", self.data);
    }
}

enum NewList {
    NewCons(i32, Rc<NewList>),
    NewNil,
}

use crate::NewList::{NewCons, NewNil};
use std::rc::Rc;



fn main() {
    let b = Box::new(5);
    println!("b = {}", b);

    let list = Cons(1, Box::new(Cons(2, Box::new(Cons(3, Box::new(Nil))))));
    list.display(0);

    let my_b = MyBox::new(78);
    println!("MyBox contains: {}", *my_b);

    let _c = CustomSmartPointer {
        data: String::from("my stuff"),
    };
    let _d = CustomSmartPointer {
        data: String::from("other stuff"),
    };
    println!("CustomSmartPointers created.");
    std::mem::drop(_c);
    println!("CustomSmartPointer dropped before the end of main.");

    let a = Rc::new(NewCons(5, Rc::new(NewCons(10, Rc::new(NewNil)))));
    println!("count after creating a = {}", Rc::strong_count(&a));
    let _b = NewCons(3, Rc::clone(&a));
    println!("count after creating b = {}", Rc::strong_count(&a));
    {
        let _c = NewCons(4, Rc::clone(&a));
        println!("count after creating c = {}", Rc::strong_count(&a));
    }
    println!("count after c goes out of scope = {}", Rc::strong_count(&a));
}