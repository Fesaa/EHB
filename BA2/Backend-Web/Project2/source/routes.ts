import express from "express"

import * as publicRoutes from "./controllers/public"
import * as managementRoutes from "./controllers/management"

import { databaseManager } from "./database/DatabaseManager"

import { authScheme } from "./validators/keys"

const router = express.Router()

router.get("/stock", publicRoutes.getItemsInStock)
router.post("/register", publicRoutes.registerNewCustomer)

const authRouter = express.Router()
authRouter.use(async (req, res, next) => {
    return authScheme.validateAsync(req.headers, { allowUnknown: true })
        .then(async _ => {
            return databaseManager.isManagement(req.header("Authentication") ?? "")
                .then(isManagement => {
                    if (!isManagement) {
                        return res.status(401).json({ msg: "Insufficient privilages" })
                    }
                    next()
                })
                .catch(err => res.status(400).json({ msg: "Database error", error: err.details[0] }))
        })
        .catch(err => res.status(400).json({ msg: "Missing header", error: err.details[0] }))
})
authRouter.post("/stock", managementRoutes.addItemsToStock)
authRouter.put("/stock", managementRoutes.updateItemsInStock)
authRouter.delete("/stock", managementRoutes.removeItemsFromStock)

router.use("/management", authRouter)

export = router
