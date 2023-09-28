import * as Joi from 'joi'

const authScheme = Joi.object({
    authentication: Joi.string()
        .required()
})

const customerAuthScheme = Joi.object({
    username: Joi.string()
        .lowercase()
        .alphanum()
        .required()
        .min(5)
        .max(20),

    key: Joi.string()
        .required()
})

export { authScheme, customerAuthScheme }
