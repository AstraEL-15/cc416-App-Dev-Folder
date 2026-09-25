<?php
// If they have the Lab 12 cookie, send them to the dashboard
if (isset($_COOKIE['lab12_user_id'])) {
    header('Location: user_records.php');
    exit;
} else {
    // Otherwise, send them to login
    header('Location: login.php');
    exit;
}
