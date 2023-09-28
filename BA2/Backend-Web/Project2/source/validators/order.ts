import * as Joi from 'joi'


const placeOrderSchema = Joi.array().items(
    Joi.object({
        id: Joi.number()
            .integer()
            .min(0)
            .required(),
        amount: Joi.number()
            .integer()
            .min(0)
            .required()
    })
).required()
    .min(1)


export { placeOrderSchema }
