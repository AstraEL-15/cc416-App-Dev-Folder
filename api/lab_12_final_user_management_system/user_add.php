<?php
if (!isset($_COOKIE['lab12_user_id'])) { 
    header('Location: login.php'); 
    exit; 
}
include 'initialize.php';

$firstname = $_POST['firstname'] ?? '';
$lastname = $_POST['lastname'] ?? '';
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

// Validate that none of the fields from the modal are empty
if (empty($firstname) || empty($lastname) || empty($username) || empty($password)) {
    // Redirect back to the dashboard with an error, NOT the old user_add.php page
    header("Location: user_records.php?error=" . urlencode("All fields are required to create a user"));
    exit;
} else {
    // Insert the new user into the database
    $sql = "INSERT INTO users (username, password, firstname, lastname) VALUES ('$username', '$password', '$firstname', '$lastname')";
    
    if ($connection->query($sql) === TRUE) {
        // This is what gives you the green banner when successful
        header('Location: user_records.php?msg=' . urlencode("New user created successfully!"));
        exit;
    } else {
        header("Location: user_records.php?error=" . urlencode("Error creating user: " . $connection->error));
        exit;
    }
}
?>