
const THREE_HOURS_IN_SECONDS: u32 = 60 * 60 * 3;


fn main() {
    let x = 5;
    println!("The value of x is: {x}");
    
    /* 
    Cannot change the var, as it was not created with the mut keyword
    x = 6;
    println!("The value of x is: {x}");
    
    as such
    */

    let mut y = 5;
    println!("The value of y is: {y}");

    y = 6;
    println!("The value of y is: {y}");

    println!("Three hours is {} seconds!", THREE_HOURS_IN_SECONDS);


    let x = 5;

    let x = x + 1;

    {
        let x = x * 2;
        println!("The value of x in the inner scope is: {x}");
    }

    println!("The value of x is: {x}");
    
}
