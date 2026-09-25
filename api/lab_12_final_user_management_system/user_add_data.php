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
} else {
    // 3. Check if username already exists
    $check_query = "SELECT id FROM users WHERE username = '$username'";
    $check_result = $connection->query($check_query);

    if ($check_result && $check_result->num_rows > 0) {
        header("Location: user_records.php?error=" . urlencode("That username is already taken. Please choose another."));
        exit;
    }

    // Hash the password securely
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Use $hashed_password in the SQL query instead of $password
    $sql = "INSERT INTO users (username, password, firstname, lastname) VALUES ('$username', '$hashed_password', '$firstname', '$lastname')";

    // 4. Check if the user was created successfully and redirect accordingly
    if ($connection->query($sql) === TRUE) {
        header('Location: user_records.php?msg=' . urlencode("New user created successfully!"));
        exit;
    } else {
        header("Location: user_records.php?error=" . urlencode("Error creating user: " . $connection->error));
        exit;
    }
}
