<?php 
require_once "../../database.php";

$table_name="products";
$sql = 
"CREATE TABLE  $table_name
(id INT AUTO_INCREMENT PRIMARY KEY, 
name VARCHAR(255) NOT NULL,
price VARCHAR(255) NOT NULL,
product_detail VARCHAR(255) NOT NULL,
image VARCHAR(255) NOT NULL
)";

$result = $conn->query($sql);
if($result){
    echo "Table has been created ($table_name) <br/>";
    
}else{    
    echo "Table has not been created ($table_name) <br/>";
}
?>