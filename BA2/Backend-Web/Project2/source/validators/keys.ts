import * as Joi from 'joi'

const authScheme = Joi.object({
    authentication: Joi.string()
        .required()
})

const customerAuthScheme = Joi.object({
    user_id: Joi.number()
        .integer()
        .min(0)
        .required(),
    key: Joi.string()
        .required()
})

export { authScheme, customerAuthScheme }
