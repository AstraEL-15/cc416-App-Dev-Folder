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
    // Basic query (as per professor's structure)
    $query = "SELECT * FROM users WHERE username='".$username."' AND password='".$password."'";
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        // Set Lab 12 specific cookies
        setcookie("lab12_user_id", $row['id'], time() + 86400, "/");
        setcookie("lab12_username", $row['username'], time() + 86400, "/");
        
        header('Location: user_records.php');
        exit;
    } else {
        header('Location: login.php?error=' . urlencode("Username and Password not found!"));
        exit;
    }
}
?>