
// Global var
static mut COUNTER: u32 = 0;

// Calls unsafe rust
// But isn't unsafe itself !!!
fn add_to_count(inc: u32) {
    unsafe {
        COUNTER += inc;
    }
}

fn main() {
        let mut num = 5;

    let r1 = &num as *const i32;
    let r2 = &mut num as *mut i32;

    //r2 shouldn't be allowed as it might change the value
    // while r1 is immutable and assumes the value to be constant
    unsafe {
        println!("r1 is: {}", *r1);
        println!("r2 is: {}", *r2);
    }

    // Has to be called inside an unsafe code block
    // to compile
    unsafe {
        scary_function();
    }

    add_to_count(3);

    unsafe {
        println!("COUNTER: {}", COUNTER);
    }
}

unsafe fn scary_function() {}
