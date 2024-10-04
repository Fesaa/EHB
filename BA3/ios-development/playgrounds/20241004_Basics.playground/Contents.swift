import UIKit

var greeting = "Hello, playground"

var fruits = ["Apple", "Pear", "Banana"]

for fruit in fruits {
    print("I like \(fruit)")
}

fruits.append("Orange")
fruits.append("Apple")

print("Fruits has a size of \(fruits.count)")

let uniqueFruits: Set<String> = Set(fruits)

print("Unique fruits has a size of \(uniqueFruits.count)")

fruits.sort()

for fruit in fruits {
    print("I like \(fruit)")
}

var myDictionary: [String: Int] = [:]
myDictionary["Apple"] = 1
myDictionary["Pear"] = 2

print("My dictionary has \(myDictionary.count) elements")

myDictionary["Banana"] = 3

for (key, value) in myDictionary {
    print("\(key) has a value of \(value)")
}

myDictionary["Orange"] = 0


