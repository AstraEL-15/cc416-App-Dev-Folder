<?php
include 'initialize.php';

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($username)) {
    header('Location: login.php?error=' . urlencode("Username is required"));
    exit;
} elseif (empty($password)) {
    header('Location: login.php?error=' . urlencode("Password is required"));
    exit;
} else {
    // Escape the username to prevent basic SQL injection
    $safe_username = mysqli_real_escape_string($connection, $username);

    // 1. Ask the database for the user by username ONLY
    $query = "SELECT * FROM users WHERE username='$safe_username'";
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_assoc($result);

    // 2. Check if the user exists AND if the typed password matches the hashed password
    if ($row && password_verify($password, $row['password'])) {
        // Passwords match! Set Lab 12 specific cookies
        setcookie("lab12_user_id", $row['id'], time() + 86400, "/");
        setcookie("lab12_username", $row['username'], time() + 86400, "/");

        header('Location: user_records.php');
        exit;
    } else {
        // Login failed. We use a generic message so attackers don't know which part they got wrong.
        header('Location: login.php?error=' . urlencode("Invalid username or password!"));
        exit;
    }
}
