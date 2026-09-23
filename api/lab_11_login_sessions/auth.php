<?php
include 'initialize.php';

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($username)) {
    $_SESSION['alert_message'] = "Username is required";
    header('Location: login.php');
    exit;
} elseif (empty($password)) {
    $_SESSION['alert_message'] = "Password is required";
    header('Location: login.php');
    exit;
} else {
    $query = "SELECT * FROM users WHERE username='".$username."' AND password='".$password."'";
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        // Set cookies that last for 1 day, available across all folders ("/")
        setcookie("user_id", $row['id'], time() + 86400, "/");
        setcookie("username", $row['username'], time() + 86400, "/");
        
        // Step out of Lab 11 and into Lab 08
        header('Location: ../lab_08_read_user_records/user_records.php');
        exit;
    } else {
        $_SESSION['alert_message'] = "Username and Password not found!";
        header('Location: login.php');
        exit;
    }
}
?>