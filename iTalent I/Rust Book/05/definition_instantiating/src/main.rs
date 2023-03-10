struct User {
    active: bool,
    username: String,
    email: String,
    sign_in_count: u64,
}

// Unnamed field () around, named {}
struct Color(i32, i32, i32);

fn main() {
    // --snip--

    let user1 = User {
        email: String::from("someone@example.com"),
        username: String::from("someusername123"),
        active: true,
        sign_in_count: 1,
    };

    // ..user1 notation implies that all none filled in fields are copied from user1
    // Important! user1 can no longer be used, non stack fields have been moved to the memory is destroyed. 
    // Added a username field, would keep user1 'alive'
    let user2 = User {
        email: String::from("another@example.com"),
        ..user1
    };

    let user3 = build_user(user2.username, user2.email);

    print_user(user3);

    let _black = Color(0, 0, 0);
}

fn build_user(username: String, email: String) -> User {
    User {
        active: true,
        username,
        email,
        sign_in_count: 1
    }
}

fn print_user(user: User) {
    println!("{}, {}, {}, {}", user.active, user.username, user.email, user.sign_in_count);
}
