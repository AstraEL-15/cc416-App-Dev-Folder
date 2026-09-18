<?php
$host = getenv('DB_HOST') ?: 'mysql-22f856ab-ernestlenard1234-479d.c.aivencloud.com';
$user = getenv('DB_USER') ?: 'avnadmin';
$pass = getenv('DB_PASS') ?: 'Password here'; // Copy password from Aiven Overview tab
$db   = getenv('DB_NAME') ?: 'defaultdb';
$port = getenv('DB_PORT') ?: 28562;

$conn = mysqli_init();
mysqli_ssl_set($conn, NULL, NULL, __DIR__ . '/ca.pem', NULL, NULL);

try {
    mysqli_real_connect($conn, $host, $user, $pass, $db, (int)$port, NULL, MYSQLI_CLIENT_SSL);
} catch (mysqli_sql_exception $e) {
    die("Aiven Database Connection Failed: " . $e->getMessage());
}
?>