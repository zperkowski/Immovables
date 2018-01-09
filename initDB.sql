CREATE TABLE users(
  id    INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
  email TEXT NOT NULL,
  pwd   TEXT NOT NULL,
  name  TEXT
);

CREATE TABLE immovables(
  id        INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
  title     TEXT NOT NULL,
  address   TEXT(100) NOT NULL,
  price     REAL NOT NULL,
  m2        REAL,
  rooms     INT,
  floors    INT,
  balconies INT,
  desc      TEXT,
  picture   BLOB,
  ownerid   INTEGER NOT NULL,
  buyerid   INTEGER DEFAULT NULL,
  FOREIGN KEY (ownerid) REFERENCES users(id),
  FOREIGN KEY (buyerid) REFERENCES users(id)
);

INSERT INTO users VALUES (0, "admin@example.com", "admin", "Administrator");

