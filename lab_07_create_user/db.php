<?php
$host = trim(getenv('DB_HOST') ?: 'localhost');
$user = trim(getenv('DB_USER') ?: 'root');
$pass = trim(getenv('DB_PASS') ?: '');
$db   = trim(getenv('DB_NAME') ?: 'defaultdb');
$port = trim(getenv('DB_PORT') ?: 3306);

$conn = mysqli_init();
$ca_path = file_exists(__DIR__ . '/ca.pem') ? __DIR__ . '/ca.pem' : __DIR__ . '/../ca.pem';
$conn->ssl_set(NULL, NULL, $ca_path, NULL, NULL);
$conn->real_connect($host, $user, $pass, $db, (int)$port, NULL, MYSQLI_CLIENT_SSL);

if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}
?>