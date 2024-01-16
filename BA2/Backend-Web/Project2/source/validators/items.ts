import * as Joi from "joi"


const itemArraySchemaNoId = Joi.array().items(Joi.object({
    name: Joi.string()
        .required(),
    description: Joi.string()
        .required(),
    price: Joi.number()
        .min(0)
        .required(),
    amount: Joi.number()
        .min(0)
        .default(0),
}))

const itemArraySchemaWithId = Joi.array().items(Joi.object({
    name: Joi.string()
        .optional(),
    description: Joi.string()
        .optional(),
    price: Joi.number()
        .min(0)
        .optional(),
    amount: Joi.number()
        .min(0)
        .optional(),
    id: Joi.number()
        .required()
}))

interface stockRequest {
    after: number
    limit: number | null
}

const stockRequestQuery = Joi.object({
    after: Joi.number()
        .integer()
        .min(0)
        .default(0),
    limit: Joi.number()
        .integer()
        .min(1)
        .optional()
})

const idArraySchema = Joi.array().items(
    Joi.number()
        .integer()
        .min(1)
)

export { itemArraySchemaNoId, itemArraySchemaWithId, stockRequestQuery, stockRequest, idArraySchema }
