<?php
$servername = "mysql-container";
$username = "v1_user";
$password = "root";
$dbname = "v1";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
