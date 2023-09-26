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

export { Item, Customer }
