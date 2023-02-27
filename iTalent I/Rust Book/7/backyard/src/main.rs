use crate::garden::vegetables::Asparagus;

pub mod garden;

fn main() {
    let plant = Asparagus {};
    println!("I'm growing {:?}!", plant);

    // Can be called as test_super is public
    garden::vegetables::test_super();

    // Cannot be called as print_name is private
    //garden::print_name()

    let my_garden = garden::create_details(String::from("My beautiful garden!"), 200);

    println!("{}", my_garden.get_area())
}

