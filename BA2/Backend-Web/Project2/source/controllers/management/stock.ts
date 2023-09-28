import { NextFunction, Request, Response } from "express";
import { databaseManager } from "../../database/DatabaseManager";
import { Item } from "../../database/tables";
import { idArraySchema, itemArraySchemaNoId, itemArraySchemaWithId } from "../../validators/items";

async function updateItemsInStock(req: Request, res: Response, _: NextFunction) {
    return itemArraySchemaWithId.validateAsync(req.body)
        .then(async (body: any) => {
            let items: Array<Partial<Item>> = body
            return databaseManager.updateItems(items)
                .then((succes) => res.status(200).json({ inserted_ids: succes }))
                .catch(err => res.status(400).json({ msg: "Encountered an database error", error: err }))
        })
        .catch(err => res.status(400).json({ err: err.details[0] }))
}

async function addItemsToStock(req: Request, res: Response, _: NextFunction) {
    return itemArraySchemaNoId.validateAsync(req.body)
        .then(async (body: any) => {
            let items: Array<Partial<Item>> = body
            return databaseManager.addItems(items)
                .then(ids => res.status(202).json({ msg: "OK!", ids: ids }))
                .catch(err => res.status(400).json({ msg: "Encountered an database error", error: err }))
        })
        .catch((err) => res.status(400).json({ err: err.details[0] }))
}

async function removeItemsFromStock(req: Request, res: Response, _: NextFunction) {
    return idArraySchema.validateAsync(req.body)
        .then(async (ids: Array<Number>) => {
            return databaseManager.deleteItems(ids)
                .then(amount => res.status(202).json({ msg: `Deleted ${amount} items from stock` }))
                .catch(err => res.status(400).json({ msg: "Encountered an database error", error: err }))
        })
        .catch((err) => res.status(400).json({ err: err.details[0] }))
}

export { addItemsToStock, updateItemsInStock, removeItemsFromStock }
