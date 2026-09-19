<?php
// 1. Start the session at the VERY top before anything else happens
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. Include database connection and bridge the variable
include 'initialize.php';
$connection = $conn;

// 3. Grab form data
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$username = $_POST['username'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

$error_message = null;

// 4. Validate input
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
    $error_message = "Password and confirm password not match";
}

// 5. Handle success or error
if (!empty($error_message)) {
    $_SESSION['alert_message'] = $error_message;
    header('Location: user_add.php');
    exit(); // Always exit after a header redirect
} else {
    $sql = "INSERT INTO users (firstname, lastname, username, password) 
            VALUES ('$firstname', '$lastname', '$username', '$password')";

    if (mysqli_query($connection, $sql)) {
        $_SESSION['alert_message'] = "User added successfully!";
        header('Location: dashboard.php');
        exit();
    } else {
        $_SESSION['alert_message'] = "Error adding user: " . mysqli_error($connection);
        header('Location: user_add.php');
        exit();
    }
}
?>