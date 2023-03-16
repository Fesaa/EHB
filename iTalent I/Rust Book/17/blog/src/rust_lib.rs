pub struct RPost {
    content: String,
}

pub struct RDraftPost {
    content: String,
}

pub struct RPendingReviewPost {
    content: String,
    counter: u8,
}

pub enum ApproveRequestResponse {
    Success(RPost),
    Fail(RPendingReviewPost),
}

impl RPost {
    pub fn new() -> RDraftPost {
        RDraftPost {
            content: String::new(),
        }
    }

    pub fn content(&self) -> &str {
        &self.content
    }
}

impl RDraftPost {
    pub fn add_text(&mut self, text: &str) {
        self.content.push_str(text);
    }

    pub fn request_review(self) -> RPendingReviewPost {
        RPendingReviewPost {
            content: self.content,
            counter: 0,
        }
    }
}

impl RPendingReviewPost {
    pub fn approve(mut self) -> ApproveRequestResponse {
        self.counter += 1;

        if self.counter < 2 {
            ApproveRequestResponse::Fail(self)
        } else {
            ApproveRequestResponse::Success(RPost {
                content: self.content,
            })
        }
    }

    pub fn reject(self) -> RDraftPost {
        RDraftPost { 
            content: self.content,
        }
    }
}