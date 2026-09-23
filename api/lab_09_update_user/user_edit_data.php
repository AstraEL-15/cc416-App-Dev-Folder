<?php 
include 'initialize.php';

// The professor's code expects the ID from the URL parameter[cite: 7]
$user_id = $_GET['user-id'];

$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$username = $_POST['username'];
// In a real app we'd hash this, but we'll stick to the lab's plain-text logic
$password = $_POST['password']; 
$confirm_password = $_POST['confirm_password'] ?? ''; // Added fallback in case it's skipped

$error_message = "";

if (empty($firstname)) {
    $error_message = "Firstname is required";
} elseif (empty($lastname)) {
    $error_message = "Lastname is required";
} elseif (empty($username)) {
    $error_message = "Username is required";
} elseif (!empty($password) && $password !== $confirm_password) {
    $error_message = "Password and confirm password do not match";
}

if (!empty($error_message)) {
    $_SESSION['alert_message'] = $error_message;
    // Send them back to the dashboard on error
    header('Location: ../lab_08_read_user_records/user_records.php');
    exit();
} else {
    // If password was left blank in our UI, we only update the text fields
    if (empty($password)) {
        $sql = "UPDATE users SET username='$username', firstname='$firstname', lastname='$lastname' WHERE id=$user_id";
    } else {
        // Professor's exact update query structure[cite: 7]
        $sql = "UPDATE users SET username='$username', password='$password', firstname='$firstname', lastname='$lastname' WHERE id=$user_id";
    }
    
    if ($connection->query($sql) === TRUE) {
        $_SESSION['alert_message'] = "Record updated successfully!";
        header('Location: ../lab_08_read_user_records/user_records.php');
        exit();
    } else {
        echo "Error updating record: " . $connection->error;
    }
}
?>