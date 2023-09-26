import { NextFunction, Request, Response } from "express";
import { databaseManager } from "../../database/DatabaseManager";



async function getAllItemsInStock(req: Request, res: Response, next: NextFunction) {
    const items = await databaseManager.getAllItemsInStock()
    return res.status(200).json(items)
}

export default { getAllItemsInStock }
