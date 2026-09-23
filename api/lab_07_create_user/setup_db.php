<?php
require_once 'db.php';

// 1. Drop old table structure if it exists
$sql_drop = "DROP TABLE IF EXISTS users;";
mysqli_query($conn, $sql_drop);

// 2. Create table with username and password columns
$sql_create = "CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(50) NOT NULL,
    lastname VARCHAR(50) NOT NULL,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NULL
);";

// 3. Insert initial dummy data matching the new structure
$sql_insert = "INSERT INTO users (firstname, lastname, username, password, email) VALUES 
('Zen', 'One', 'zen1', 'password123', 'zen1@example.com'),
('Zen', 'Two', 'zen2', 'password123', 'zen2@example.com'),
('Zen', 'Three', 'zen3', 'password123', 'zen3@example.com');";

if (mysqli_query($conn, $sql_create)) {
    mysqli_query($conn, $sql_insert);
    echo "<h1 style='color:green;'>Table 'users' reset successfully with 'username' and 'password' columns!</h1>";
    echo "<a href='dashboard.php'>Go to Dashboard</a>";
} else {
    echo "Error resetting table: " . mysqli_error($conn);
}
?>