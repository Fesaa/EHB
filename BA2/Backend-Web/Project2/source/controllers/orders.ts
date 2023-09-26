import { NextFunction, Request, Response } from "express";
import { stockedItemStmt } from "../db";


interface Item {
    id: Number;
    name: String;
    price: Number,
    stock: Number
}

async function getAllItemsInStock(req: Request, res: Response, next: NextFunction) {
    return res.status(200).json(stockedItemStmt.all())
}

export default { getAllItemsInStock }
