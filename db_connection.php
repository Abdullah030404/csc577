<?php
$servername = "localhost"; // The server you're connecting to
$username = "root"; // The username for your database
$password = ""; // The password for your database
$dbname = "tahfizdb"; // The name of your database

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

