import * as Joi from 'joi'

const authScheme = Joi.object({
    "authentication": Joi.string()
        .required()
})

export { authScheme }
