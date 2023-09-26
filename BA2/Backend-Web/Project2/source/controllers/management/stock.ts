import { NextFunction, Request, Response } from "express";
import { insertItem } from "../../db";

async function addItemToStock(req: Request, res: Response, next: NextFunction) {
    let name: string = req.body.name
    let price: Number = req.body.price
    let amount: Number = req.body.amount

    insertItem({
        name: name,
        price: price,
        amount: amount,
    })

    return res.status(200).json({ msg: "OK!" })

}

export default { addItemToStock }
