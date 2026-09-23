<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Load local environment variables if the file exists (ignored by GitHub)
if (file_exists(__DIR__ . '/../local_env.php')) {
    include_once __DIR__ . '/../local_env.php';
}
// 1. Credentials from Environment Variables (Vercel) or Defaults
$host = trim(getenv('DB_HOST') ?: 'mysql-22f856ab-ernestlenard1234-479d.c.aivencloud.com');
$user = trim(getenv('DB_USER') ?: 'avnadmin');
$pass = trim(getenv('DB_PASS') ?: '');// Set DB_PASS in Vercel Environment Variables
$db   = trim(getenv('DB_NAME') ?: 'defaultdb');
$port = (int)(getenv('DB_PORT') ?: 28562);

// 2. Resolve Host IP to bypass local DNS resolution delays
$ip = gethostbyname($host);

$conn = mysqli_init();
if (!$conn) {
    die("Database Initialization Failed: mysqli_init failed.");
}

// 3. Search for ca.pem across all relative project directories
$possible_ca_paths = [
    __DIR__ . '/ca.pem',
    __DIR__ . '/../ca.pem',
    $_SERVER['DOCUMENT_ROOT'] . '/ca.pem' ?? ''
];

$ca_path = null;
foreach ($possible_ca_paths as $path) {
    if (!empty($path) && file_exists($path)) {
        $ca_path = $path;
        break;
    }
}

if ($ca_path) {
    $conn->ssl_set(NULL, NULL, $ca_path, NULL, NULL);
}

// 4. Attempt Connection with Fallback (IP first, then Domain Host)
$connected = @$conn->real_connect($ip, $user, $pass, $db, $port, NULL, MYSQLI_CLIENT_SSL);

if (!$connected) {
    $connected = @$conn->real_connect($host, $user, $pass, $db, $port, NULL, MYSQLI_CLIENT_SSL);
}

if (!$connected) {
    die("Database Connection Failed: " . mysqli_connect_error());
}

// 5. Dual variable mapping for Lab 07 and Lab 08 compatibility
$connection = $conn;
?>