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
    // 3. Redirect back to the records page instead of the old edit page
    header("Location: user_records.php?error=" . urlencode("All fields are required"));
    exit;
} else {
    // 4. Update the user data (excluding password, since the modal doesn't provide one)
    $sql = "UPDATE users SET username='$username', firstname='$firstname', lastname='$lastname' WHERE id='$user_id'";
    
    if ($connection->query($sql) === TRUE) {
        header('Location: user_records.php?msg=' . urlencode("User updated successfully"));
        exit;
    } else {
        header("Location: user_records.php?error=" . urlencode("Error updating record: " . $connection->error));
        exit;
    }
}
?>