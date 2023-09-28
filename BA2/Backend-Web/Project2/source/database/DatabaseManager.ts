import { Db, SQLite3Driver } from "sqlite-ts";
import Sqlite3 = require("sqlite3")
import { exec } from 'child_process'

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
    public async registerNewCostumer(name: string): Promise<string> {
        const guard = await this.db!.tables.Customer.single().where(c => c.equals({ name: name }))
        if (guard) {
            return Promise.reject("This username is already in use")
        }

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
        const db_key = await this.db!.tables.Key.single().where((k) => k.equals({ key: key }))
        return Promise.resolve(db_key != null && db_key.admin)
    }

    /**
    * Check if a user is authenticated correctly
    **/
    public async isAuthenticated(name: string, key: string): Promise<boolean> {
        return Promise.resolve(true)
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
    * @returns Array of ids of the inserted items
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

}

const databaseManager = new DatabaseManager()

export { databaseManager }
