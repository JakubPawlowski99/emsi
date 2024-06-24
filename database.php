<?php
$servername = "127.0.0.1";
$username = "jakubp";
$password = "M34LJvtiB3S!FAV";
$dbname = "jakubpawlowski99";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Connected successfully";
}

// // Close connection
// $conn->close();
?>