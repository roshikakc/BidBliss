
<?php 
require_once "../../database.php";

$table_name="user";
$sql = 
"CREATE TABLE  $table_name
(id INT AUTO_INCREMENT PRIMARY KEY, 
name VARCHAR(255) NOT NULL,
password VARCHAR(255) NOT NULL,
email VARCHAR(255) NOT NULL,
user_type VARCHAR(255) NOT NULL DEFAULT 'user'
)";

$result = $conn->query($sql);
if($result){
    echo "Table has been created ($table_name) <br/>";
    
}else{    
    echo "Table has not been created ($table_name) <br/>";
}
?>