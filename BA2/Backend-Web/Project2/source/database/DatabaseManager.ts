import { Db, SQLite3Driver } from "sqlite-ts";
import Sqlite3 = require("sqlite3")

import { Item, Customer, Key } from "./tables"

class DatabaseManager {

    private static entities = {
        Item,
        Customer,
        Key
    }

    private db: Db<{
        Item: typeof Item,
        Customer: typeof Customer,
        Key: typeof Key
    }> | null = null

    constructor() { }

    /**
    * Async initialization of the database
    * has to be called before using any other methods
    **/
    public async init() {
        const PATH = process.env.DB ?? ":memory:"
        const sqlite3DB = new Sqlite3.Database(PATH)

        this.db = await Db.init({
            driver: new SQLite3Driver(sqlite3DB),

            entities: DatabaseManager.entities,
            createTables: true
        })
    }

    /**
    * Register a new customer to the database
    *
    * @param name The name of the customer
    * @returns The auth key of the customer
    **/
    public async registerNewCostumer(name: string): Promise<string> {
        const customer = await this.db!.tables.Customer.insert({ name })
        const id = customer.insertId
        return this.generateNewKey(id)
    }

    /**
    * Check if a key has management privilages
    **/
    public async isManagement(key: string): Promise<boolean> {
        if (process.env.AUTH_ALL ?? false) {
            return true
        }
        const out = await this.db!.tables.Key.single().where((k) => k.equals({ key: key }))
        return out != null && out.admin
    }


    private async generateNewKey(customer_id: number, admin: boolean = false): Promise<string> {
        const key = Math.random().toString(36).substring(2, 15)
        // We are not checking if the customer_id is valid, as the method is private
        // so we can assume that the logic is correct
        await this.db!.tables.Key.insert({ customer_id, key, admin })
        return Promise.resolve(key)
    }

    /**
    * Query the database for a customer
    * 
    * @param id The id of the customer
    * @returns Instance of Customer or null if not found
    **/
    public async getCustomerById(id: number): Promise<Customer | null> {
        return this.db!.tables.Customer.single().where((customer) => customer.equals({ id }))
    }

    /**
    * Query the database for all items in stock
    * i.e. any items with an amount > 0
    *
    * @returns Array of Item
    **/
    public async getAllItemsInStock(): Promise<Item[]> {
        return this.db!.tables.Item
            .select()
            .where((item) => item.greaterThan({ amount: 0 }))
    }

    /**
    * Query the database for all items in stock
    * and past a certain item id
    *
    * @returns Array of Item
    **/
    public async getItemsInStockAfter(id: number): Promise<Item[]> {
        return this.db!.tables.Item
            .select()
            .where((item) => item.greaterThan({ amount: 0, id: id }))
    }

    /**
    * Insert new items into the datbase
    * Or update if item is passed with an id
    *
    * @param items Array of items to insert
    * @returns Array of ids of the inserted items
    **/
    public async addNewItems(items: Partial<Item>[]): Promise<number[]> {
        let generatedIds: number[] = []
        await this.db!.transaction(({ exec, tables }) => {
            for (const item of items) {
                if (item.id) {
                    exec(tables.Item.update(item).where(id => id.equals({ id: item.id })))
                } else {
                    exec(tables.Item.insert(item)).then((id) => generatedIds.push(id.insertId))
                }
            }
        })
        return Promise.resolve(generatedIds)
    }

}

const databaseManager = new DatabaseManager()

export { databaseManager }
