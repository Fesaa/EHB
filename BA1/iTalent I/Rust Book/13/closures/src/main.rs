use std::thread;

#[derive(Debug)]
struct Rectangle {
    width: u32,
    _height: u32,
}

#[derive(Debug, PartialEq, Copy, Clone)]
enum ShirtColor {
    Red,
    Blue,
}

struct Inventory {
    shirts: Vec<ShirtColor>,
}


impl Inventory {
    fn giveaway(&self, user_preference: Option<ShirtColor>) -> ShirtColor {
        // unwrap_or_else returns called in Option<T> if Some is returned.
        // And calls the closure (lambda like function) if it's None
        // A closure takes the form:
        // |list of parameters| body
        user_preference.unwrap_or_else(|| self.most_stocked())
    }

    fn most_stocked(&self) -> ShirtColor {
        let mut red_counter = 0;
        let mut blue_counter = 0;

        for color in &self.shirts {
            match color {
                ShirtColor::Red => red_counter += 1,
                ShirtColor::Blue => blue_counter += 1,
            }
        }

        if red_counter > blue_counter {
            ShirtColor::Red
        } else {
            ShirtColor::Blue
        }

    }
}



fn main() {
    let store = Inventory {
        shirts: vec![ShirtColor::Blue, ShirtColor::Red, ShirtColor::Blue],
    };

    let user_pref1 = Some(ShirtColor::Red);
    let giveaway1 = store.giveaway(user_pref1);
    println!(
        "The user with preference {:?} gets {:?}",
        user_pref1, giveaway1
    );

    let user_pref2 = None;
    let giveaway2 = store.giveaway(user_pref2);
    println!(
        "The user with preference {:?} gets {:?}",
        user_pref2, giveaway2
    );


    // We can define variables to be closures
    let _succ= |x: i32| -> i32 {x + 1} ;

    // Type annotations aren't needed if the closures is called
    let succ = |x| x + 1 ;

    let _two = succ(1);

    // We cannot use the closures with any other types now!
    // let _float_two = succ(1f32); 
    // would not compile 


    // Closures can, same as functions, borrow a (mutable) reference or take ownership

    // Borrow
    let list = vec![1, 2, 3];
    println!("Before defining closure: {:?}", list);

    // Not mutable variable
    let only_borrows = || println!("From closure: {:?}", list);

    println!("Before calling closure: {:?}", list);
    only_borrows();
    println!("After calling closure: {:?}", list);

    // Borrow & mutable
    let mut list = vec![1, 2, 3];
    println!("Before defining closure: {:?}", list);

    // Mutable variable
    let mut borrows_mutably = || {list.push(7)};

    borrows_mutably();
    println!("After calling closure: {:?}", list);


    // Take ownership
    let list = vec![1, 2, 3];
    println!("Before defining closure: {:?}", list);

    // Move keyword passes ownership
    // This should always be sure that the reference is still valid when the thread finishes
    // would throw
    // error[E0373]: closure may outlive the current function, but it borrows `list`, which is owned by the current function
    thread::spawn(move || println!("From thread: {:?}", list))
        .join()
        .unwrap();


    // sort_by_key takes a closure that can be called several times AND does not take ownership!
    let mut list = [
        Rectangle { width: 10, _height: 1 },
        Rectangle { width: 3, _height: 5 },
        Rectangle { width: 7, _height: 12 },
    ];

    let mut num_sort_operations = 0;

    list.sort_by_key(|r| {
        num_sort_operations += 1;
        r.width
    });
    println!("{:#?}, sorted in {num_sort_operations} operations", list);
}
