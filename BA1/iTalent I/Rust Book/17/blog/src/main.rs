use blog::Post;
use blog::rust_lib::{RPost, ApproveRequestResponse, RPendingReviewPost};

fn main() {
    let mut post = Post::new();

    post.add_text("I ate a salad for lunch today").unwrap();
    assert_eq!("", post.content());

    post.request_review();
    assert_eq!("", post.content());
    post.add_text("I ate a salad for lunch today").unwrap_or_else(|er| {
        print!("{}", er)
    });

    post.approve();
    post.approve();
    assert_eq!("I ate a salad for lunch today", post.content());


    let mut post = RPost::new();

    post.add_text("I ate a salad for lunch today");

    let post = post.request_review();

    let post = approve_till_done(post);


    assert_eq!("I ate a salad for lunch today", post.content());
}

fn approve_till_done(post: RPendingReviewPost) -> RPost {
    match post.approve() {
        ApproveRequestResponse::Success(post) => post,
        ApproveRequestResponse::Fail(post) => approve_till_done(post),
    }
}