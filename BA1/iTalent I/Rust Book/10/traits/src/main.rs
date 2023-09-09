
pub trait Summary {
    fn summarize_author(&self) -> String;

    fn summarize(&self) -> String {
        format!("(Read more from {}...)", self.summarize_author())
    }
}

pub struct NewsArticle {
    pub headline: String,
    pub location: String,
    pub author: String,
    pub content: String,
}

impl Summary for NewsArticle {
    fn summarize(&self) -> String {
        format!("{}, by {} ({})", self.headline, self.author, self.location)
    }

    fn summarize_author(&self) -> String {
        format!("{}", self.author)
    }
}

pub struct Tweet {
    pub username: String,
    pub content: String,
    pub reply: bool,
    pub retweet: bool,
}

impl Summary for Tweet {
    fn summarize_author(&self) -> String {
        format!("@{}", self.username)
    }
}

// &impl Trait as type accepts any type that implements that Trait
// Syntactic sugar for fn name<T: Trait>(var: T)
pub fn notify(item: &impl Summary) {
    println!("Breaking news! {}", item.summarize());
}

// Multiple traits can be required by using + 
// fn name<T: Trait + Trait1 + Trait2>(var: T)
pub fn multi_notify<T: Summary>(item1: &T, item2: &T) {
    notify(item1);
    notify(item2);
}

// Different syntax to avoid clutter in the definition line
fn _some_function<T, U>(_t: &T, _u: &U) -> i32
where
    T: std::fmt::Display + Clone,
    U: Clone + std::fmt::Debug,
{
0
}

fn main() {
    let tweet = Tweet {
        username: String::from("horse_ebooks"),
        content: String::from(
            "of course, as you probably already know, people",
        ),
        reply: false,
        retweet: false,
    };

    notify(&tweet);
}
