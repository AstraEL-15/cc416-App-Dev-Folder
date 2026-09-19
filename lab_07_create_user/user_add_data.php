<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'initialize.php';
$connection = $conn;

$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$username = $_POST['username'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

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
    header('Location: dashboard.php?tab=add_user');
    exit();
} else {
    $sql = "INSERT INTO users (firstname, lastname, username, password) 
            VALUES ('$firstname', '$lastname', '$username', '$password')";

    if (mysqli_query($connection, $sql)) {
        $_SESSION['alert_message'] = "User added successfully!";
        header('Location: dashboard.php?tab=users');
        exit();
    } else {
        $_SESSION['alert_message'] = "Error adding user: " . mysqli_error($connection);
        header('Location: dashboard.php?tab=add_user');
        exit();
    }
}
?>