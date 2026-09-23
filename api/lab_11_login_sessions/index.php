<?php
// Start the session just so we can immediately destroy it
session_start();

// Wipe out any existing session memory (forces a fresh start every time you launch the URL)
session_unset();
session_destroy();

// Redirect straight to the login page
header('Location: login.php');
exit;
?>