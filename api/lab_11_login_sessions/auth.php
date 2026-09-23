<?php
include 'initialize.php';

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($username)) {
    $_SESSION['alert_message'] = "Username is required";
    session_write_close();
    header('Location: login.php');
    exit;
} elseif (empty($password)) {
    $_SESSION['alert_message'] = "Password is required";
    session_write_close();
    header('Location: login.php');
    exit;
} else {
    $query = "SELECT * FROM users WHERE username='".$username."' AND password='".$password."'";
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['username'] = $row['username'];
        
        // Force PHP to save session data before redirecting on Vercel
        session_write_close();
        
        // STEP OUT OF LAB 11 AND INTO LAB 08
        header('Location: ../lab_08_read_user_records/user_records.php');
        exit;
    } else {
        $_SESSION['alert_message'] = "Username and Password not found!";
        session_write_close();
        header('Location: login.php');
        exit;
    }
}
?>