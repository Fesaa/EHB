import { NextFunction, Request, Response } from "express";
import { placeOrderSchema } from "../../validators/order";
import { databaseManager } from "../../database/DatabaseManager";

/**
* Any requests here can be assumed to contain headers
*  - user_id as number
*  - key as string
* when responding to
*
*
* We are returning all databaseManager errors as 401, as auth errors 
* should be more commen, and this terrible language doesn't have 
* the slightest bit of decent error handling. Throwing errors
* and no actual types, drunk people istg
**/


async function placeOrder(req: Request, res: Response, _: NextFunction) {
    return placeOrderSchema.validateAsync(req.body)
        .then(async (items: Array<{ id: number, amount: number }>) => {
            databaseManager.placeOrder(+req.header("user_id")!, items)
                .then(order_id => res.status(202).json({ msg: "Order succesful!", order_id: order_id }))
                .catch(err => res.status(401).json({ error: err }))
        })
        .catch((err) => res.status(400).json({ errors: err.details[0] }))
}

async function getAllOrders(req: Request, res: Response, _: NextFunction) {
    databaseManager.getAllOrders(+req.header("user_id")!)
        .then(orders => res.status(200).json({ orders: orders }))
        .catch(err => res.status(401).json({ error: err }))
}

export { placeOrder, getAllOrders }
