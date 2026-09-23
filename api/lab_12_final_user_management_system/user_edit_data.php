<?php
if (!isset($_COOKIE['lab12_user_id'])) { 
    header('Location: login.php'); 
    exit; 
}
include 'initialize.php';

$user_id = $_GET['user-id'] ?? '';
$firstname = $_POST['firstname'] ?? '';
$lastname = $_POST['lastname'] ?? '';
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
$confirm = $_POST['confirm_password'] ?? '';

if (empty($firstname) || empty($lastname) || empty($username) || empty($password)) {
    header("Location: user_edit.php?user-id=$user_id&error=" . urlencode("All fields are required"));
    exit;
} elseif ($password !== $confirm) {
    header("Location: user_edit.php?user-id=$user_id&error=" . urlencode("Passwords do not match"));
    exit;
} else {
    $sql = "UPDATE users SET username='$username', password='$password', firstname='$firstname', lastname='$lastname' WHERE id='$user_id'";
    
    if ($connection->query($sql) === TRUE) {
        header('Location: user_records.php?msg=' . urlencode("Record updated successfully"));
        exit;
    } else {
        header("Location: user_edit.php?user-id=$user_id&error=" . urlencode("Error updating record: " . $connection->error));
        exit;
    }
}
?>