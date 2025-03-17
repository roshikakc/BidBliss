<?php 

require_once './../migration.php';

$table_name="cart";
$sql = 
"CREATE TABLE $table_name
(cart_id INT AUTO_INCREMENT PRIMARY KEY, 
name VARCHAR(255) NOT NULL,
price VARCHAR(255) NOT NULL,
quantity VARCHAR(255) NOT NULL,
image VARCHAR(255) NOT NULL,
user_id INT, -- Foreign key column
FOREIGN KEY (user_id) REFERENCES user(user_id)
pid INT, -- Foreign key column
FOREIGN KEY (pid) REFERENCES products(product_id)
 ON DELETE CASCADE 
 ON UPDATE CASCADE
)";

$result = $conn->query($sql);
if($result){
    echo "Table has been created ($table_name) <br/>";
    
}else{    
    echo "Table has not been created ($table_name) <br/>";
}
?>