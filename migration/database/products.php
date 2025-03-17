<?php
require_once './../migration.php';

$table_name="products";
$sql = 
"CREATE TABLE  $table_name
(product_id INT AUTO_INCREMENT PRIMARY KEY, 
product_name VARCHAR(255) NOT NULL,
product_actual_price VARCHAR(255) NOT NULL,
product_detail VARCHAR(255) NOT NULL,
product_image VARCHAR(255) NOT NULL,
product_latest_price VARCHAR(255) NOT NULL,
product_expire_date DATE NOT NULL,
product_category VARCHAR(255),
is_featured TINYINT(1) DEFAULT 0, 
auction_date DATE ,
product_user_id INT, -- Foreign key column
FOREIGN KEY (product_user_id) REFERENCES user(user_id)
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

