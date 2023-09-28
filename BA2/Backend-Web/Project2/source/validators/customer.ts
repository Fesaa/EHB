import * as Joi from "joi"

const customerSchema = Joi.object({
    name: Joi.string()
        .required()
        .alphanum()
        .min(5)
        .max(20)
})

export { customerSchema }
