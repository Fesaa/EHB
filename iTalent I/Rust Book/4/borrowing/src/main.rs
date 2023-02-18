fn main() {
    

    let mut s =  String::from("Hello!");

    change(&mut s);

    println!("{}", s);


}

fn change(my_string: &mut String) {
    my_string.push_str(" Darling <3")
}
