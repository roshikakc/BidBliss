<?php
// Define database credentials
$servername = "localhost";   // Host name, usually "localhost" for local development
$username = "root";      // MySQL username
$password = "root";      // MySQL password
$dbname = "bidbliss_db";   // Name of the database to connect to

// Create a connection
$conn = mysqli_connect('localhost','root','root','bidbliss_db');

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
echo "Connected successfully";

?>