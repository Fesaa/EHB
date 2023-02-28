fn main() {
    let string1 = String::from("abcd");
    let string2 = "xyz";

    let result = longest(string1.as_str(), string2);
    println!("The longest string is {}", result);
    let result = longest_with_an_announcement(string1.as_str(), string2, "HEY");
    println!("The longest string is {}", result);


    let novel = String::from("Call me Ishmael. Some years ago...");
    let first_sentence = novel.split('.').next().expect("Could not find a '.'");
    let _i = ImportantExcerpt {
        _part: first_sentence,
    };
}

struct ImportantExcerpt<'a> {
    _part: &'a str,
}

// 'a are lifetimes annotation. And tell the complier that the lifetime of the return value is the dependent as the variable passed to the function
// Since they all use the same symbol
// In practice 'a will have the smallest lifetime between x & y
fn longest<'a>(x: &'a str, y: &'a str) -> &'a str {
    if x.len() > y.len() {
        x
    } else {
        y
    }
}

fn longest_with_an_announcement<'a, T>(
    x: &'a str,
    y: &'a str,
    ann: T,
) -> &'a str
where
    T: std::fmt::Display,
{
    println!("Announcement! {}", ann);
    if x.len() > y.len() {
        x
    } else {
        y
    }
}
