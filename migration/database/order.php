<?php
require_once './../migration.php';

$table_name = "order";
$sql =
    "CREATE TABLE  `$table_name` 
    (order_id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    seller_id INT NOT NULL, -- This comes from the user_id in the products table
    buyer_id INT NOT NULL,  -- This comes from the session (logged-in user)
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status ENUM('pending', 'confirmed', 'shipped', 'delivered') DEFAULT 'pending',
    FOREIGN KEY (product_id) REFERENCES products(product_id) ON DELETE CASCADE,
    FOREIGN KEY (seller_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (buyer_id) REFERENCES users(user_id) ON DELETE CASCADE
)";

$result = $conn->query($sql);
if ($result) {
    echo "Table has been created ($table_name) <br/>";
} else {
    echo "Table has not been created ($table_name) <br/>";
}
