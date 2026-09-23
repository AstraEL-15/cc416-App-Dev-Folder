<?php
include 'initialize.php';

$firstname = $_POST['firstname'] ?? '';
$lastname = $_POST['lastname'] ?? '';
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
$confirm = $_POST['confirm_password'] ?? '';

if (empty($firstname) || empty($lastname) || empty($username) || empty($password)) {
    header('Location: user_add.php?error=' . urlencode("All fields are required"));
    exit;
} elseif ($password !== $confirm) {
    header('Location: user_add.php?error=' . urlencode("Passwords do not match"));
    exit;
} else {
    $sql = "INSERT INTO users (firstname, lastname, username, password) VALUES ('$firstname', '$lastname', '$username', '$password')";
    
    if ($connection->query($sql) === TRUE) {
        // If logged in, go to dashboard. If not, go to login.
        $dest = isset($_COOKIE['lab12_user_id']) ? 'user_records.php' : 'login.php';
        header("Location: $dest?msg=" . urlencode("New user created successfully!"));
        exit;
    } else {
        header('Location: user_add.php?error=' . urlencode("Database error: " . $connection->error));
        exit;
    }
}
?>