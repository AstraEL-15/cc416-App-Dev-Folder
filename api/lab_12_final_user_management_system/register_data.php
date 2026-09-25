<?php
// NO cookie check here either!
include 'initialize.php';

$firstname = $_POST['firstname'] ?? '';
$lastname = $_POST['lastname'] ?? '';
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
$confirm = $_POST['confirm_password'] ?? '';

// 1. Check for empty fields
if (empty($firstname) || empty($lastname) || empty($username) || empty($password) || empty($confirm)) {
    header("Location: user_add.php?error=" . urlencode("All fields are required"));
    exit;
}
// 2. Check if passwords match
elseif ($password !== $confirm) {
    header("Location: user_add.php?error=" . urlencode("Passwords do not match"));
    exit;
}
// 3. Save the new user and send them to the login page
else {
    // Check if username already exists
    $check_query = "SELECT id FROM users WHERE username = '$username'";
    $check_result = $connection->query($check_query);

    if ($check_result && $check_result->num_rows > 0) {
        header("Location: user_add.php?error=" . urlencode("That username is already taken. Please choose another."));
        exit;
    }

    // Hash the password securely
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Use $hashed_password in the SQL query instead of $password
    $sql = "INSERT INTO users (username, password, firstname, lastname) VALUES ('$username', '$hashed_password', '$firstname', '$lastname')";

    // Execute the SQL query
    if ($connection->query($sql) === TRUE) {
        // Redirect to login page with a green success message
        header('Location: login.php?msg=' . urlencode("Account created successfully! Please login."));
        exit;
    } else {
        header("Location: user_add.php?error=" . urlencode("Error creating account: " . $connection->error));
        exit;
    }
}
