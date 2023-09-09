pub mod vegetables;

pub struct Details {
    pub name: String,
    area: u8

}

// Does not need the pub keyword to make fn accessible
impl Details {

    // Needs pub to be accessible
    pub fn get_area(self: &Self) -> u8 {
        self.area
    }
}

fn print_name() {
    println!("You are in the garden!")
}

pub fn create_details(name: String, area: u8) -> Details {
    Details { name, area}
}