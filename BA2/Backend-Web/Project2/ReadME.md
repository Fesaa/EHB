# Project 2 - Node.js 

Een eenvoudige API geschreven typescript met behulp van
- https://github.com/budiadiono/sqlite-ts
- https://github.com/hapijs/joi
- https://github.com/expressjs/express

Met als context, een kleine (web) winkel.

## Git
De source code is te vinden op [GitHub](https://github.com/Fesaa/EHB/tree/main/BA2/Backend-Web/Project2), met development via de `backend-web/project2` branch. Een volledige commit history is te vinden via pull requests, mocht dit nodig zijn.

## API design
The API is opgesplitst in drie endpoint paden
- [Publiek](source/controllers/public/) zonder authenticatie => `/`
- [Klant](source/controllers/customer/), met verplichte `user_id` en `key` headers => `/customer`
- [Managers](source/controllers/management/), met verplicht `authentication` header => `/management`

Deze worden geconfiguered in `routes.ts`.

#### Public endpoints
`GET /stock?after=<int?>&limit=<int?>` => 200
```json
[
    {
        "id": int,
        "name": string,
        "description": string,
        "price": int,
        "amount": int
    }*
]
```
`POST /register?name=<string>` => 202
```json
{
    "msg": string,
    "auth_key": string,
    "user_id": int
}
```

### Klant eindpoints
`GET /customer/orders` => 200
```json
[
    {
        "order": {
            "id": int,
            "customer_id": int,
            "order_date": string
        },
        "items": [
            {
                "order_id": int,
                "item_id": int,
                "amount": int
            }*
        ]
    }*
]
```
`POST /customer/order` => 202
```json
{
    "msg": string,
    "order_id": int
}
```

### Management endpoints
`POST /management/stock` => 201
```json
{
    "msg": string,
    "ids": [
        int*
    ]
}
```
`PUT /management/stock` => 200
```json
{
    "inserted_ids": [
        int*
    ]
}
```
`DELETE /management/stock` => 202
```json
{
    "msg": string,
    "count": int
}
```

Endpoints kunnen ook een `400` validatie error, authentication of `500` database error



## Database Structure
The sqlite3 database contains five tables;

`Item(id, name, description, price, amount)`\
`Customer(id, name)`\
`Key(customer_id, key, admin)`\
`Order(id,customer_id, order_date)`\
`OrderItem(order_id, item_id, amount)`\
