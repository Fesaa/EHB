import { NextFunction, Request, Response } from "express";
import { databaseManager } from "../../database/DatabaseManager";
import { customerSchema } from "../../validators/customer";


async function registerNewCustomer(req: Request, res: Response, _: NextFunction) {
    customerSchema.validateAsync(req.query)
        .then(async (query: { name: string }) => {
            databaseManager.registerNewCostumer(query.name)
                .then(c => res.status(202).json({ msg: "Succesfully registered", auth_key: c.key, user_id: c.id }))
                .catch((err) => res.status(500).json({ msg: "Registration failed", errors: err }))
        })
        .catch((err) => res.status(400).json({ errors: err.details[0] }))
}

export { registerNewCustomer }
