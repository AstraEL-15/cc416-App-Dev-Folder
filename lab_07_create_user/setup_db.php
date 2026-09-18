<?php
require_once 'db.php';

$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(50) NOT NULL,
    lastname VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL
);";

$sql_insert = "INSERT INTO users (firstname, lastname, email) VALUES 
('Zen', 'One', 'zen1@example.com'),
('Zen', 'Two', 'zen2@example.com'),
('Zen', 'Three', 'zen3@example.com');";

if (mysqli_query($conn, $sql)) {
    mysqli_query($conn, $sql_insert);
    echo "<h1 style='color:green;'>Table 'users' created and populated on Aiven successfully!</h1>";
    echo "<a href='dashboard.php'>Go to Dashboard</a>";
} else {
    echo "Error creating table: " . mysqli_error($conn);
}
?>