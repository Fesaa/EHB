import { Db, SQLite3Driver } from "sqlite-ts";
import Sqlite3 = require("sqlite3")
import { exec } from 'child_process'

import { Item, Customer, Key, Order, OrderItem } from "./tables"

class DatabaseManager {

    private static entities = {
        Item,
        Customer,
        Key,
        Order,
        OrderItem
    }

    private db: Db<{
        Item: typeof Item,
        Customer: typeof Customer,
        Key: typeof Key,
        Order: typeof Order,
        OrderItem: typeof OrderItem
    }> | null = null

    constructor() { }

    /**
    * Async initialization of the database
    * has to be called before using any other methods
    **/
    public async init() {
        const PATH = process.env.DB ?? ":memory:"
        const sqlite3DB = new Sqlite3.Database(PATH)

        Db.init({
            driver: new SQLite3Driver(sqlite3DB),

            entities: DatabaseManager.entities,
            createTables: true
        })
            .then(db => {
                this.db = db
                if (process.env.DUMMY_VARS) {
                    exec('cat init.sql | sqlite3 bin/temp.sql', (err, stdout, stderr) => {
                        console.log(err)
                        console.log(stdout)
                        console.log(stderr)
                    });
                }
            })


    }

    /**
    * Register a new customer to the database
    *
    * @param name The name of the customer
    * @returns The auth key of the customer
    **/
    public async registerNewCostumer(name: string): Promise<{ id: number, key: string }> {
        const customer = await this.db!.tables.Customer.insert({ name })
        const id = customer.insertId
        const key = await this.generateNewKey(id)
        return { id: id, key: key }
    }

    /**
    * Check if a key has management privilages
    **/
    public async isManagement(key: string): Promise<boolean> {
        if (process.env.AUTH_ALL ?? false) {
            return true
        }
        const db_key = await this.db!.tables.Key.single().where((k) => k.equals({ key: key }))
        return Promise.resolve(db_key != null && db_key.admin)
    }

    /**
    * Check if a user is authenticated correctly
    **/
    public async isAuthenticated(id: number, key: string): Promise<boolean> {
        const out = await this.db!.tables.Key.single().where(k => k.equals({ customer_id: id, key: key }))
        return Promise.resolve(out != null)
    }


    private async generateNewKey(customer_id: number, admin: boolean = false): Promise<string> {
        const key = Math.random().toString(36).substring(2, 15)
        // We are not checking if the customer_id is valid, as the method is private
        // so we can assume that the logic is correct
        await this.db!.tables.Key.insert({ customer_id, key, admin })
        return Promise.resolve(key)
    }

    /**
    * query the database for a customer
    * 
    * @param id the id of the customer
    * @returns instance of customer or null if not found
    **/
    public async getCustomerById(id: number): Promise<Customer | null> {
        return this.db!.tables.Customer.single().where((customer) => customer.equals({ id }))
    }

    /**
    * query the database for a customer
    * 
    * @param name the name of the customer
    * @returns instance of customer or null if not found
    **/
    public async getCustomerByName(name: string): Promise<Customer | null> {
        return this.db!.tables.Customer.single().where((customer) => customer.equals({ name }))
    }

    /**
    * Query the database for all items in stock
    * i.e. any items with an amount > 0
    *
    * @param [after=-1] after item with id
    * @param [limit=null] limit the output size
    *
    * @returns Array of Item
    **/
    public async getStock(after: number = -1, limit: number | null = null): Promise<Item[]> {
        const query = this.db!.tables.Item
            .select()
            .where((item) => item.greaterThan({ amount: 0, id: after }))
        if (limit) {
            return query.limit(limit)
        }
        return query
    }

    /**
    * Update items into the datbase
    *
    * @param items Array of items to update
    * @returns Array of ids of succesfully updated items
    **/
    public async updateItems(items: Partial<Item>[]): Promise<number[]> {
        let successIds: number[] = []
        await this.db!.transaction(({ exec, tables }) => {
            for (const item of items) {
                if (item.id) {
                    exec(tables.Item.update(item)
                        .where(id => id.equals({ id: item.id })))
                        .then((id) => {
                            if (id.rowsAffected != 0) {
                                successIds.push(item.id!)
                            }
                        })
                }
            }
        })
        return Promise.resolve(successIds)
    }

    /**
    * Insert new items into the datbase
    *
    * @param items Array of items to insert
    * @returns Array of ids of the inserted items
    **/
    public async addItems(items: Partial<Item>[]): Promise<number[]> {
        let generatedIds: number[] = []
        await this.db!.transaction(({ exec, tables }) => {
            for (const item of items) {
                if (item.id) {
                    exec(tables.Item.update(item)
                        .where(id => id.equals({ id: item.id })))
                        .then((id) => {
                            if (id.rowsAffected != 0) {
                                generatedIds.push(item.id!)
                            }
                        }
                        )
                } else {
                    exec(tables.Item.insert(item))
                        .then((id) => generatedIds.push(id.insertId))
                }
            }
        })
        return Promise.resolve(generatedIds)
    }


    /** Delete items from stock
    *
    * @param ids the ids to delete
    **/
    public async deleteItems(ids: Number[]): Promise<number> {
        const res = await this.db!.tables.Item.delete().where(item => item.in({ id: ids }))
        return Promise.resolve(res.rowsAffected)
    }

    /**
    * Places an order, and adds it to the order list.
    * Will return Promise#reject the moment an item is not present, or does not have enough in stock
    *
    * @param customer_id id for the ordering customer
    * @param items item to order
    *
    * @returns the order id
    **/
    public async placeOrder(customer_id: number, items: Array<{ id: number, amount: number }>): Promise<Number> {
        const stockArray = await this.getStock()
        const stock: { [key: number]: Item } = {}
        stockArray.forEach(item => stock[item.id] = item)

        const updates: Array<Partial<Item>> = []
        for (const item of items) {
            const stockItem = stock[item.id]
            if (stockItem == null) {
                return Promise.reject(`Cannot order item with id ${item.id} as it does not exists`)
            }
            if (item.amount > stockItem.amount) {
                return Promise.reject(`Cannot order item with id ${item.id} as there are not enough in stock. (${stockItem.amount} < ${item.amount})`)
            }
            updates.push({
                id: item.id,
                amount: stockItem.amount - item.amount
            })
        }

        await this.updateItems(updates)

        const order = await this.db!.tables.Order.insert({
            customer_id: customer_id,
            order_date: new Date()
        })

        const orderItems: Array<OrderItem> = []
        for (const item of items) {
            orderItems.push({
                amount: item.amount,
                item_id: item.id,
                order_id: order.insertId
            })
        }

        await this.db!.tables.OrderItem.insert(orderItems)

        return Promise.resolve(order.insertId)
    }

}

const databaseManager = new DatabaseManager()

export { databaseManager }
