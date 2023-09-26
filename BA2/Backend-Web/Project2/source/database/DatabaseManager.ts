import { Db, SQLite3Driver } from "sqlite-ts";
import Sqlite3 = require("sqlite3")

import { Item, Customer } from "./tables"

class DatabaseManager {

    private static entities = {
        Item,
        Customer
    }

    private sqlite3DB: Sqlite3.Database

    private db: Db<{
        Item: typeof Item,
        Customer: typeof Customer
    }>
        | null = null

    constructor() {

        const PATH = process.env.DB ?? ":memory:"
        this.sqlite3DB = new Sqlite3.Database(PATH)
    }

    async init() {
        this.db = await Db.init({
            driver: new SQLite3Driver(this.sqlite3DB),

            entities: DatabaseManager.entities,
            createTables: true
        })
    }

    async getAllItemsInStock(): Promise<Item[]> {
        return this.db!.tables.Item.select().where((item) => item.greaterThan({ amount: 0 }))
    }

    async addNewItems(items: Partial<Item>[]): Promise<number[]> {
        let generatedIds: number[] = []
        await this.db!.transaction(({ exec, tables }) => {
            for (const item of items) {
                exec(tables.Item.insert(item)).then((id) => generatedIds.push(id.insertId))
            }
        })
        return Promise.resolve(generatedIds)
    }

}

const databaseManager = new DatabaseManager()

export { databaseManager }
