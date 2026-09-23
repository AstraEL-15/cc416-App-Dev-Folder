<?php include 'initialize.php'; ?>
<?php
$username = $_POST['username'];
$password = $_POST['password'];

if(empty($username)) {
    $_SESSION['alert_message'] = "Username is required";
    header('Location: login.php');
}
elseif(empty($password)) {
    $_SESSION['alert_message'] = "Password is required";
    header('Location: login.php');
}
else {
    $query = "SELECT * FROM users WHERE username='".$username."' AND password='".$password."'";
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_assoc($result);

    if($row) {
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['username'] = $row['username'];
        header('Location: dashboard.php');
    }
    else {
        $_SESSION['alert_message'] = "Username and Password not found!";
        header('Location: login.php');
    }
}
?>