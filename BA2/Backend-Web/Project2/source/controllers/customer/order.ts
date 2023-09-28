import { NextFunction, Request, Response } from "express";
import { placeOrderSchema } from "../../validators/order";
import { databaseManager } from "../../database/DatabaseManager";

async function placeOrder(req: Request, res: Response, _: NextFunction) {
    return placeOrderSchema.validateAsync(req.body)
        .then(async (items: Array<{ id: number, amount: number }>) => {
            databaseManager.placeOrder(+req.header("user_id")!, items)
                .then(order_id => (
                    res.status(202).json({ msg: "Order succesful!", order_id: order_id })
                ))
                .catch(err => res.status(500).json({ error: err }))
        })
        .catch((err) => res.status(400).json({ errors: err.details[0] }))
}

async function getAllOrders(req: Request, res: Response, _: NextFunction) {

}

async function getOrderData(req: Request, res: Response, _: NextFunction) {

}


export { placeOrder, getAllOrders, getOrderData }
