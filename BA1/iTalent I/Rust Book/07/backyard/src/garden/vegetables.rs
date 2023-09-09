#[derive(Debug)]
pub struct Asparagus {}

pub fn test_super() {
    // ALl functions are inherited from their super
    super::print_name()
}