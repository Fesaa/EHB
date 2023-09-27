import { NextFunction, Request, Response } from "express";
import { databaseManager } from "../../database/DatabaseManager";
import { Item } from "../../database/tables";
import * as Joi from 'joi';


const itemArraySchema = Joi.array().items(Joi.object({
    name: Joi.string()
        .required(),
    description: Joi.string()
        .required(),
    price: Joi.number()
        .min(0)
        .required(),
    amount: Joi.number()
        .min(0)
        .default(0),
    id: Joi.number()
        .optional()
}))

async function addItemsToStock(req: Request, res: Response, _: NextFunction) {
    try {
        await itemArraySchema.validateAsync(req.body)
    } catch (err) {
        return res.status(400).json({ errors: err })
    }

    let items: Array<Partial<Item>> = [];
    for (const item of req.body) {
        items.push({
            name: item.name,
            description: item.description,
            price: item.price,
            amount: item.amount,
            id: item.id,
        })
    }
    try {
        const ids = await databaseManager.addNewItems(items)
        return res.status(200).json({ msg: "OK!", ids: ids })
    } catch (err) {
        return res.status(400).json({ msg: "Encountered an datbase error", error: err })
    }

}

export default { addItemToStock: addItemsToStock }
