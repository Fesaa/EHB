import express from "express"

import publicRoutes from "./controllers/public/stock"

import managementRoutes from "./controllers/management/stock"
const router = express.Router()

router.get("/stock", publicRoutes.getAllItemsInStock)
router.post("/management/stock", managementRoutes.addItemToStock)

export = router
