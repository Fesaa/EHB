import { NextFunction, Request, Response } from "express";
import { databaseManager } from "../../database/DatabaseManager";

async function addItemToStock(req: Request, res: Response, next: NextFunction) {
    let name: string = req.body.name
    let price: number = req.body.price
    let amount: number = req.body.amount


    const ids = await databaseManager.addNewItems([{
        name: name,
        price: price,
        amount: amount
    }])
    return res.status(200).json({ msg: "OK!", ids: ids })

}

export default { addItemToStock }
