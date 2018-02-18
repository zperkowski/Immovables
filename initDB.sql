CREATE TABLE users (
  id     INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
  email  TEXT                              NOT NULL UNIQUE,
  pwd    TEXT                              NOT NULL,
  name   TEXT,
  number TEXT
);

CREATE TABLE immovables (
  id        INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
  title     TEXT                              NOT NULL,
  address   TEXT(100)                         NOT NULL,
  price     REAL                              NOT NULL,
  m2        REAL,
  rooms     INT,
  floors    INT,
  balconies INT,
  desc      TEXT,
  ownerid   INTEGER                           NOT NULL,
  buyerid   INTEGER DEFAULT NULL,
  FOREIGN KEY (ownerid) REFERENCES users (id),
  FOREIGN KEY (buyerid) REFERENCES users (id)
);

CREATE TABLE pictures (
  id      INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
  id_immo INTEGER                           NOT NULL,
  picture BLOB                              NOT NULL,
  FOREIGN KEY (id_immo) REFERENCES immovables (id)
);

INSERT INTO immovables VALUES (
  NULL,
  'Title1',
  'Admin Street 1',
  100.11,
  35.3,
  2,
  1,
  0,
  'Desc1',
  1,
  NULL
);

INSERT INTO immovables VALUES (
  NULL,
  'Title2',
  'Admin Street 2',
  100.11,
  35.3,
  2,
  1,
  0,
  'Desc2',
  1,
  NULL
);

INSERT INTO immovables VALUES (
  NULL,
  'Title3',
  'User Street 1',
  100.11,
  35.3,
  2,
  1,
  1,
  'Desc2',
  2,
  NULL
);
