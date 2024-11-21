
<?php 
require_once "../../database.php";

$table_name="order";
$sql = 
"CREATE TABLE  `$table_name`
(id INT AUTO_INCREMENT PRIMARY KEY, 
user_id INT(255) NOT NULL,
name VARCHAR(255) NOT NULL,
number VARCHAR(255) NOT NULL,
address VARCHAR(255) NOT NULL,
total_product VARCHAR(255) NOT NULL,
total_price VARCHAR(255) NOT NULL,
placed_on VARCHAR(255) NOT NULL,
payment_status VARCHAR(255) NOT NULL DEFAULT 'Pending'
)";

$result = $conn->query($sql);
if($result){
    echo "Table has been created ($table_name) <br/>";
    
}else{    
    echo "Table has not been created ($table_name) <br/>";
}
?>