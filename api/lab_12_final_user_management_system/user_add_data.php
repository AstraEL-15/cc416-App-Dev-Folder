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
$confirm = $_POST['confirm_password'] ?? '';

// 1. Check if ANY field is empty
if (empty($firstname) || empty($lastname) || empty($username) || empty($password) || empty($confirm)) {
    header("Location: user_records.php?error=" . urlencode("All fields are required to create a user"));
    exit;
} 
// 2. Check if passwords match
elseif ($password !== $confirm) {
    header("Location: user_records.php?error=" . urlencode("Passwords do not match"));
    exit;
} 
// 3. Save the user
else {
    $sql = "INSERT INTO users (username, password, firstname, lastname) VALUES ('$username', '$password', '$firstname', '$lastname')";
    
    if ($connection->query($sql) === TRUE) {
        header('Location: user_records.php?msg=' . urlencode("New user created successfully!"));
        exit;
    } else {
        header("Location: user_records.php?error=" . urlencode("Error creating user: " . $connection->error));
        exit;
    }
}
?>