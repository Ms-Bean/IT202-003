CREATE TABLE IF NOT EXISTS Orders(
    id int AUTO_INCREMENT PRIMARY  KEY,
    user_id int,
    total_price int,
    created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    payment_method VARCHAR(30),
    address TEXT
)
