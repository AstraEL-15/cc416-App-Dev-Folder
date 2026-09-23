<?php
// Destroy Lab 12 cookies
setcookie("lab12_user_id", "", time() - 3600, "/");
setcookie("lab12_username", "", time() - 3600, "/");

// Send back to login with a success message
header('Location: login.php?msg=' . urlencode("You have been successfully logged out."));
exit;
?>