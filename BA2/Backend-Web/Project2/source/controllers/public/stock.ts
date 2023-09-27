import { NextFunction, Request, Response } from "express";
import { databaseManager } from "../../database/DatabaseManager";

async function getItemsInStock(req: Request, res: Response, next: NextFunction) {
    let items;
    if (req.query.after) {
        let after: number = Number(req.query.after);
        if (Number.isNaN(after)) {
            return res.status(401).json({ msg: `Cannot convert <${req.query.after}> to an integer` })
        }
        items = await databaseManager.getItemsInStockAfter(after)
    } else {
        items = await databaseManager.getAllItemsInStock()
    }
    return res.status(200).json(items)
}

export default { getItemsInStock }
