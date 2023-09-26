import http from "http";
import morgan from "morgan";
import express, { Express } from "express";
import routes from "./routes/orders"

const router: Express = express();

// Loggings
router.use(morgan("dev"));
router.use(express.urlencoded({ extended: false }));
router.use(express.json());
router.use((req, res, next) => {
    res.header('Access-Control-Allow-Origin', '*');
    res.header('Access-Control-Allow-Headers', 'origin, X-Requested-With,Content-Type,Accept, Authorization');
    if (req.method === 'OPTIONS') {
        res.header('Access-Control-Allow-Methods', 'GET PATCH DELETE POST');
        return res.status(200).json({});
    }
    next();
});

router.use("/", routes)

router.use((_, res, __) => {
    return res.status(404).json({
        message: 'Endpoint was not found.'
    });
});

const server = http.createServer(router);
const PORT = process.env.PORT ?? 6060;
server.listen(PORT, () => console.log(`The server is running on port ${PORT}`));


