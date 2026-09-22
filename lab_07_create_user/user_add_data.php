<?php
// Force PHP to display errors instead of a white screen
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 1. Check if initialize.php actually exists in this folder
if (!file_exists('initialize.php')) {
    die("CRITICAL ERROR: initialize.php is missing from the lab_07_create_user folder. Please copy it from Lab 08 into Lab 07.");
}

include 'initialize.php';

// 2. Check if the database connection was successfully created
if (!isset($connection)) {
    if (isset($conn)) {
        $connection = $conn;
    } else {
        die("CRITICAL ERROR: The database connection variable is missing. Check your initialize.php file.");
    }
}

$firstname = $_POST['firstname'] ?? '';
$lastname = $_POST['lastname'] ?? '';
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';

$error_message = null;

if (empty($firstname)) {
    $error_message = "Firstname is required";
} elseif (empty($lastname)) {
    $error_message = "Lastname is required";
} elseif (empty($username)) {
    $error_message = "Username is required";
} elseif (empty($password)) {
    $error_message = "Password is required";
} elseif (empty($confirm_password)) {
    $error_message = "Confirm Password is required";
} elseif ($password !== $confirm_password) {
    $error_message = "Password and confirm password do not match";
}

if (!empty($error_message)) {
    $_SESSION['alert_message'] = $error_message;
    header('Location: user_add.php');
    exit();
} else {
    $sql = "INSERT INTO users (firstname, lastname, username, password) 
            VALUES ('$firstname', '$lastname', '$username', '$password')";

    if (mysqli_query($connection, $sql)) {
        $_SESSION['alert_message'] = "User added successfully!";
        header('Location: ../lab_08_read_user_records/user_records.php');
        exit();
    } else {
        $_SESSION['alert_message'] = "Error adding user: " . mysqli_error($connection);
        header('Location: user_add.php');
        exit();
    }
}
?>