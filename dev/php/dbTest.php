<?php
$servername = "localhost";
$username = "liftoff";
$password = "L4ss13D0^^3l";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
echo "Connected successfully";

$conn->close();
?>