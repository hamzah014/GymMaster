<?php
$servername = "localhost";
$username = "root";
$password = "hamzah017";
$dbname = "gymmaster";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

//echo "Connected successfully";
?>