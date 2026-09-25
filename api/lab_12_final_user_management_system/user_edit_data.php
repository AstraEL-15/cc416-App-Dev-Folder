<?php
if (!isset($_COOKIE['lab12_user_id'])) {
    header('Location: login.php');
    exit;
}
include 'initialize.php';

// 1. Fetch ID using $_POST instead of $_GET
$user_id = $_POST['user-id'] ?? '';
$firstname = $_POST['firstname'] ?? '';
$lastname = $_POST['lastname'] ?? '';
$username = $_POST['username'] ?? '';

// 2. Validate that the required fields (including the hidden ID) are not empty
if (empty($user_id) || empty($firstname) || empty($lastname) || empty($username)) {
    header("Location: user_records.php?error=" . urlencode("All fields are required"));
    exit;
} else {
    // 3. Check if username already exists for a DIFFERENT user
    $check_query = "SELECT id FROM users WHERE username = '$username' AND id != '$user_id'";
    $check_result = $connection->query($check_query);

    if ($check_result && $check_result->num_rows > 0) {
        header("Location: user_records.php?error=" . urlencode("That username is already taken by another user."));
        exit;
    }

    // 4. Update the user data
    $sql = "UPDATE users SET username='$username', firstname='$firstname', lastname='$lastname' WHERE id='$user_id'";

    if ($connection->query($sql) === TRUE) {
        header('Location: user_records.php?msg=' . urlencode("User updated successfully"));
        exit;
    } else {
        header("Location: user_records.php?error=" . urlencode("Error updating record: " . $connection->error));
        exit;
    }
}
