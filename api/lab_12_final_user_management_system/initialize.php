<?php
// Note: We don't need session_start() because we are using cookies for Vercel!

// Pull credentials directly from Vercel Environment Variables
$host     = getenv('DB_HOST');
$port     = getenv('DB_PORT');
$user     = getenv('DB_USER');
$password = getenv('DB_PASS');
$database = getenv('DB_NAME');

// Resolve IP for Vercel serverless compatibility
$ip = gethostbyname($host);

$connection = new mysqli($ip, $user, $password, $database, $port);

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}
?>