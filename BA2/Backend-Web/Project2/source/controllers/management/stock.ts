import { NextFunction, Request, Response } from "express";
import { databaseManager } from "../../database/DatabaseManager";
import { Item } from "../../database/tables";
import { itemArraySchemaNoId, itemArraySchemaWithId } from "../../validators/items";

async function updateItemsInStock(req: Request, res: Response, _: NextFunction) {
    return itemArraySchemaWithId.validateAsync(req.body)
        .catch(err => res.status(400).json({ err: err.details[0] }))
        .then(async (body: any) => {
            let items: Array<Partial<Item>> = body
            return databaseManager.updateItems(items)
                .catch(err => res.status(400).json({ msg: "Encountered an database error", error: err }))
                .then((succes) => res.status(200).json({ inserted_ids: succes }))
        })
}

async function addItemsToStock(req: Request, res: Response, _: NextFunction) {
    return itemArraySchemaNoId.validateAsync(req.body)
        .catch(err => res.status(400).json({ err: err.details[0] }))
        .then(async (body: any) => {
            let items: Array<Partial<Item>> = body
            return databaseManager.addItems(items)
                .catch(err => res.status(400).json({ msg: "Encountered an database error", error: err }))
                .then(ids => res.status(202).json({ msg: "OK!", ids: ids }))
        })
}

export default { addItemsToStock, updateItemsInStock }
