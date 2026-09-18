<?php
// Database configuration for default XAMPP setup
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lab_app"; 
// STUDENT ACTIVITY: Change "lab_app" above to "wrong_database" to observe the connection error!

// Create the MySQLi connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    // If the connection fails, the script stops here and prints the error
    die("Connection failed: " . $conn->connect_error);
}
?>