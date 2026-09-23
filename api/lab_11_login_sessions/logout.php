<?php
// Destroy the cookies
setcookie("user_id", "", time() - 3600, "/");
setcookie("username", "", time() - 3600, "/");

// Destroy any lingering local folder sessions just in case
session_start();
session_unset();
session_destroy();

// Send them back to the door
header('Location: login.php');
exit;
?>