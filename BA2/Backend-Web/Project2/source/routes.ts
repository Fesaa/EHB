import express from "express"

import * as publicRoutes from "./controllers/public"
import * as customerRoutes from "./controllers/customer"
import * as managementRoutes from "./controllers/management"

import { databaseManager } from "./database/DatabaseManager"

import { authScheme, customerAuthScheme } from "./validators/keys"

const router = express.Router()

router.get("/stock", publicRoutes.getItemsInStock)
router.post("/register", publicRoutes.registerNewCustomer)

const customerRouter = express.Router()
customerRouter.use(async (req, res, next) => {
    return customerAuthScheme.validateAsync(req.headers, { allowUnknown: true })
        .then(async (headers: { user_id: number, key: string }) => {
            return databaseManager.isAuthenticated(
                headers.user_id,
                headers.key
            )
                .then(isAuthenticated => {
                    if (!isAuthenticated) {
                        return res.status(401).json({ msg: "Not authenticated" })
                    }
                    next()
                })
                .catch(err => res.status(400).json({ msg: "Database error", error: err }))
        })
        .catch(err => res.status(400).json({ msg: "Missing header", error: err.details[0] }))
})
customerRouter.post("/order", customerRoutes.placeOrder)

router.use("/customer", customerRouter)

const managementRouter = express.Router()
managementRouter.use(async (req, res, next) => {
    return authScheme.validateAsync(req.headers, { allowUnknown: true })
        .then(async _ => {
            return databaseManager.isManagement(req.header("Authentication") ?? "")
                .then(isManagement => {
                    if (!isManagement) {
                        return res.status(401).json({ msg: "Insufficient privilages" })
                    }
                    next()
                })
                .catch(err => res.status(400).json({ msg: "Database error", error: err }))
        })
        .catch(err => res.status(400).json({ msg: "Missing header", error: err.details[0] }))
})
managementRouter.post("/stock", managementRoutes.addItemsToStock)
managementRouter.put("/stock", managementRoutes.updateItemsInStock)
managementRouter.delete("/stock", managementRoutes.removeItemsFromStock)

router.use("/management", managementRouter)

export = router
