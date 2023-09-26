import express from "express"
import controller from "../controllers/orders"
import controller2 from "../controllers/management/stock"

const router = express.Router()

router.get("/stock", controller.getAllItemsInStock)
router.post("/admin/add", controller2.addItemToStock)

export = router
