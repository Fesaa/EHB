import express from "express"
import * as Joi from 'joi'

import publicRoutes from "./controllers/public/stock"

import managementRoutes from "./controllers/management/stock"
import { databaseManager } from "./database/DatabaseManager"
const router = express.Router()

router.get("/stock", publicRoutes.getAllItemsInStock)

const authRouter = express.Router()

const authScheme = Joi.object({
    "authentication": Joi.string()
        .required()
})

authRouter.use(async (req, res, next) => {
    try {
        await authScheme.validateAsync(req.headers, {
            allowUnknown: true
        })
    } catch (err: any) {
        return res.status(400).json({ msg: "Missing header", error: err.details[0] })
    }

    if (!(await databaseManager.isManagement(req.header("authentication")!))) {
        return res.status(401).json({ msg: "Insufficient privilages" })
    }

    next();
})
authRouter.post("/stock", managementRoutes.addItemToStock)

router.use("/management", authRouter)

export = router
