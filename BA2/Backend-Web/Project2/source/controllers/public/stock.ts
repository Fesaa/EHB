import { NextFunction, Request, Response } from "express";
import { databaseManager } from "../../database/DatabaseManager";
import { stockRequestQuery, stockRequest } from "../../validators/items";

async function getItemsInStock(req: Request, res: Response, _: NextFunction) {
    return stockRequestQuery.validateAsync(req.query)
        .catch((err) => res.status(400).json({ errors: err.details[0] }))
        .then(async (query: stockRequest) =>
            databaseManager.getStock(query.after, query.limit)
                .catch((err) => res.status(400).json({ errors: err.details[0] }))
                .then((stock) => res.status(200).json(stock)))
}

export default { getItemsInStock }
