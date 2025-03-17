<?php 
require_once './../migration.php';

$table_name="user";
$sql = 
"CREATE TABLE  $table_name
(user_id INT AUTO_INCREMENT PRIMARY KEY, 
user_name VARCHAR(255) NOT NULL,
password VARCHAR(255) NOT NULL,
email VARCHAR(255) NOT NULL,
created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
location` VARCHAR(255),
profile_image VARCHAR(255),
user_type VARCHAR(255) NOT NULL DEFAULT 'user'
)";

$result = $conn->query($sql);
if($result){
    echo "Table has been created ($table_name) <br/>";
    
}else{    
    echo "Table has not been created ($table_name) <br/>";
}
?>