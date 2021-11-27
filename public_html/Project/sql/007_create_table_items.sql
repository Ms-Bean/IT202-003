CREATE TABLE IF NOT EXISTS Products(
    id int AUTO_INCREMENT PRIMARY  KEY,
    name varchar(30) UNIQUE,
    category varchar(30),
    description text,
    stock int DEFAULT  0,
    cost int DEFAULT  99999,
    visibility varchar(30),
    created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    modified TIMESTAMP DEFAULT CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP
)