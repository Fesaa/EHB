CREATE TABLE IF NOT EXISTS migrations (
    version TEXT NOT NULL,
    desc TEXT NOT NULL,
    checksum INT NOT NULL,
    time INT NOT NULL
)