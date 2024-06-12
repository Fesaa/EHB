CREATE TABLE new_users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    cookie TEXT NOT NULL,
    username TEXT UNIQUE NOT NULL,
    password TEXT NOT NULL
);

INSERT INTO new_users (id, cookie)
SELECT id, cookie
FROM users;

DROP TABLE users;
ALTER TABLE new_users RENAME TO users;
