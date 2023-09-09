fn main() {
    let v1 = vec![1, 2, 3];

    // Does nothing
    let v1_iter = v1.iter();

    // Can loop over all elements in an iterator with a for loop
    for val in v1_iter {
        println!("Got: {}", val);
    }

    // Has to mutable as next() changes the iterator
    let mut v1_iter = v1.iter();

    assert_eq!(v1_iter.next(), Some(&1));
    assert_eq!(v1_iter.next(), Some(&2));
    assert_eq!(v1_iter.next(), Some(&3));
    assert_eq!(v1_iter.next(), None);

    // Can also call, into_iter to take ownership or iter_mut for mutable references


    let v1: Vec<i32> = vec![1, 2, 3];

    // We can call several methods on an iterator. map returns a new iterator, and has to be collected to be useful!
    let v2: Vec<_> = v1.iter().map(|x| x + 1).collect();

    // Sum takes ownership of the iterator
    let sum_of_v1: i32 = v1_iter.sum();

    println!("{}", sum_of_v1);

    // Can't use this loop, as sum() consumed the iterator
//    for val in v1_iter {
//        println!("Got: {}", val);
//    }

    assert_eq!(v2, vec![2, 3, 4]);
}
