$host = getenv('DB_HOST') ?: 'localhost';
$user = getenv('DB_USER') ?: 'root';
$pass = getenv('DB_PASS') ?: '';
$db   = getenv('DB_NAME') ?: 'defaultdb';
$port = getenv('DB_PORT') ?: 3306;

$conn = mysqli_init();

// Check for ca.pem in the current folder or parent folder
$ca_path = file_exists(__DIR__ . '/ca.pem') ? __DIR__ . '/ca.pem' : __DIR__ . '/../ca.pem';
$conn->ssl_set(NULL, NULL, $ca_path, NULL, NULL);

// Connect to Aiven cloud database
$conn->real_connect($host, $user, $pass, $db, (int)$port, NULL, MYSQLI_CLIENT_SSL);