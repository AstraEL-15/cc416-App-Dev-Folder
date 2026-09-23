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
    $query = "SELECT * FROM users WHERE username='".$username."' AND password='".$password."'";
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        // Set global cookies for successful login
        setcookie("user_id", $row['id'], time() + 86400, "/");
        setcookie("username", $row['username'], time() + 86400, "/");
        
        // Go to dashboard
        header('Location: ../lab_08_read_user_records/user_records.php');
        exit;
    } else {
        header('Location: login.php?error=' . urlencode("Username and Password not found!"));
        exit;
    }
}
?>