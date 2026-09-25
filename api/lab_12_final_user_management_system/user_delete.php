<?php
if (!isset($_COOKIE['lab12_user_id'])) {
    header('Location: login.php');
    exit;
}
include 'initialize.php';

$user_id = $_GET['user-id'] ?? '';

if (!empty($user_id)) {
    // Prevent a user from deleting themselves
    if ($user_id == $_COOKIE['lab12_user_id']) {
        header('Location: user_records.php?error=' . urlencode("You cannot delete your own active account."));
        exit;
    }

    $sql = "DELETE FROM users WHERE id='$user_id'";
    if ($connection->query($sql) === TRUE) {
        header('Location: user_records.php?msg=' . urlencode("Record deleted successfully"));
        exit;
    } else {
        header('Location: user_records.php?error=' . urlencode("Error deleting record"));
        exit;
    }
}
header('Location: user_records.php');
exit;
