import { NextFunction, Request, Response } from "express";
import { databaseManager } from "../../database/DatabaseManager";
import { Item } from "../../database/tables";
import { itemArraySchemaNoId, itemArraySchemaWithId } from "../../validators/items";

async function updateItemsInStock(req: Request, res: Response, _: NextFunction) {
    try {
        await itemArraySchemaWithId.validateAsync(req.body)
    } catch (err) {
        return res.status(400).json({ errors: err })
    }

    let items: Array<Partial<Item>> = req.body
    const success = await databaseManager.updateItems(items)
    const failed: number[] = []
    for (const item of items) {
        if (!success.includes(item.id!)) {
            failed.push(item.id!)
        }
    }

    if (success.length == 0) {
        return res.status(400).json({ msg: "Request contianed no valid ids", failed_ids: failed })
    } else if (failed.length == 0) {
        return res.status(202).json({ msg: "All ids updated succesfully" })
    }

    return res.status(202).json({ msg: "At least one ID was valid", successfull_ids: success, failed_ids: failed })
}

async function addItemsToStock(req: Request, res: Response, _: NextFunction) {
    try {
        await itemArraySchemaNoId.validateAsync(req.body)
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
        })
    }
    try {
        const ids = await databaseManager.addItems(items)
        return res.status(202).json({ msg: "OK!", ids: ids })
    } catch (err) {
        return res.status(400).json({ msg: "Encountered an datbase error", error: err })
    }
}

export default { addItemsToStock, updateItemsInStock }
