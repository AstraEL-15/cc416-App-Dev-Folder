<?php
$host = trim(getenv('DB_HOST') ?: 'mysql-22f856ab-ernestlenard1234-479d.c.aivencloud.com');
$user = trim(getenv('DB_USER') ?: 'avnadmin');
$pass = trim(getenv('DB_PASS') ?: '');
$db   = trim(getenv('DB_NAME') ?: 'defaultdb');
$port = trim(getenv('DB_PORT') ?: 28562);

// Force IPv4 lookup to bypass getaddrinfo failures
$ip = gethostbyname($host);

$conn = mysqli_init();
$ca_path = file_exists(__DIR__ . '/ca.pem') ? __DIR__ . '/ca.pem' : __DIR__ . '/../ca.pem';
$conn->ssl_set(NULL, NULL, $ca_path, NULL, NULL);

$conn->real_connect($ip, $user, $pass, $db, (int)$port, NULL, MYSQLI_CLIENT_SSL);

if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}
?>