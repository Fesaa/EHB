import { Column, Primary } from "sqlite-ts";


class Item {
    @Primary()
    id: number = 0

    @Column("NVARCHAR")
    name: string = ""

    @Column("NVARCHAR")
    description: string = ""

    @Column("DECIMAL")
    price: number = 0

    @Column("INTEGER")
    amount: number = 0
}

class Customer {
    @Primary()
    id: number = 0

    @Column("NVARCHAR")
    name: string = ""
}

class Key {
    @Column("INTEGER")
    customer_id: number = 0

    @Column("NVARCHAR")
    key: string = ""

    @Column("BOOLEAN")
    admin: boolean = false

}

class Order {
    @Primary()
    id: number = 0

    @Column("INTEGER")
    customer_id: number = 0

    @Column("DATETIME")
    order_date: Date = new Date()
}

class OrderItem {
    @Column("INTEGER")
    order_id: number = 0

    @Column("INTEGER")
    item_id: number = 0

    @Column("INTEGER")
    amount: number = 0
}

export { Item, Customer, Key, Order, OrderItem }
