import DataBase, { Database } from "better-sqlite3"

function initDB(): Database {
    const FILE = process.env.DB ?? ":memory:";
    const db = new DataBase(FILE, {
        timeout: 1000,
        verbose: console.log,
    })
    db.exec(`
            CREATE TABLE IF NOT EXISTS customers (
                id INTEGER PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                last_name VARCHAR(255) NOT NULL,
                register_date DATETIME NOT NULL
            );`)

    db.exec(`
            CREATE TABLE IF NOT EXISTS orders (
                id INTEGER PRIMARY KEY,
                customer_id INTEGER NOT NULL,
                date DATETIME NOT NULL,

                FOREIGN KEY (customer_id)
                    REFERENCES customers(id)
            );`)

    db.exec(`
            CREATE TABLE IF NOT EXISTS items (
                id INTEGER PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                price DECIMAL(5, 2) NOT NULL,
                stock INTEGER NOT NULL
            );`)

    db.exec(`
            CREATE TABLE IF NOT EXISTS order_entries (
                order_id INTEGER NOT NULL,
                item_id INTEGER NOT NULL,
                amount INTEGER NOT NULL,

                FOREIGN KEY (order_id)
                    REFERENCES orders(id)
                FOREIGN KEY (item_id)
                    REFERENCES items(id)
    );`)
    return db
}


const db = initDB()

const stockedItemStmt = db.prepare("SELECT name,price,stock FROM items WHERE stock > 0;")
const addItemToStockStmt = db.prepare("INSERT INTO items (name, price, stock) VALUES (@name, @price, @amount);")
const insertItem = db.transaction((item) => {
    addItemToStockStmt.run(item)
})

export { db, stockedItemStmt, insertItem }
