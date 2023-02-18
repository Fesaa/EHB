fn main() {
    let mut s = String::from("hello");

    s.push_str(" world!");

    println!("{}", s);

    let s1 = String::from("hello");
    // s1 is moved to s2, s1 is no longer valid 
    let s2 = s1;

    // Will error, s1 is no longer valid
    //println!("{}, world!", s1);

    // Has s1 initial data
    println!("{} world!", s2);


    // x is stored on the stack, is the size of i32 is known. x is this "deep-copied" to y. Rather than moved
    let x = 5;
    let y = x;

    println!("x = {}, y = {}", x, y);
}
