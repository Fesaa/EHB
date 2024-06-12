CREATE TABLE IF NOT EXISTS users
(
    id INTEGER PRIMARY KEY AUTOINCREMENT ,
    cookie TEXT    NOT NULL
);


CREATE TABLE IF NOT EXISTS chats
(
    id      TEXT PRIMARY KEY,
    user_id int  NOT NULL,
    name    TEXT NOT NULl,
    FOREIGN KEY (user_id) REFERENCES users (id)
);

CREATE TABLE IF NOT EXISTS messages
(
    chat_id TEXT NOT NULL,
    user    INT  NOT NULL,
    message TEXT NOT NULL,
    FOREIGN KEY (chat_id) REFERENCES chats (id)
);