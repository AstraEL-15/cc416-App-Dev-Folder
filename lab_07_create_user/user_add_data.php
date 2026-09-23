<?php
// Force PHP to display errors instead of a white screen
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!file_exists(__DIR__ . '/initialize.php')) {
    die("CRITICAL ERROR: initialize.php is missing from the lab_07_create_user folder. Please copy it from Lab 08 into Lab 07.");
}
require_once __DIR__ . '/initialize.php';

// 2. Check if the database connection was successfully created
if (!isset($connection)) {
    if (isset($conn)) {
        $connection = $conn;
    } else {
        die("CRITICAL ERROR: The database connection variable is missing. Check your initialize.php file.");
    }
}

$firstname        = trim($_POST['firstname'] ?? '');
$lastname         = trim($_POST['lastname'] ?? '');
$username         = trim($_POST['username'] ?? '');
$password         = $_POST['password'] ?? '';
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
    echo "<script>window.location.href = 'user_add.php';</script>";
    exit();
} else {
    // Sanitize input variables to prevent SQL injection and Vercel WAF payload flags
    $firstname_clean = mysqli_real_escape_string($connection, $firstname);
    $lastname_clean  = mysqli_real_escape_string($connection, $lastname);
    $username_clean  = mysqli_real_escape_string($connection, $username);
    $password_clean  = mysqli_real_escape_string($connection, $password);

    $sql = "INSERT INTO users (firstname, lastname, username, password) 
            VALUES ('$firstname_clean', '$lastname_clean', '$username_clean', '$password_clean')";

    if (mysqli_query($connection, $sql)) {
        $_SESSION['alert_message'] = "User added successfully!";
        // JavaScript redirect bypasses Vercel 403 header proxy limitations
        echo "<script>
                alert('User added successfully!');
                window.location.href = '/lab_08_read_user_records/user_records.php';
              </script>";
        exit();
    } else {
        $_SESSION['alert_message'] = "Error adding user: " . mysqli_error($connection);
        echo "<script>window.location.href = 'user_add.php';</script>";
        exit();
    }
}
?>