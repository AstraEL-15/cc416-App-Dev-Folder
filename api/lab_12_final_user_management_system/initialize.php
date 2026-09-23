<?php
// Force PHP to show errors on the screen instead of a white page
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Fallback to local XAMPP credentials if environment variables are not set
$host = getenv('DB_HOST') ?: '127.0.0.1'; 
$user = getenv('DB_USER') ?: 'root';
$password = getenv('DB_PASS') ?: '';
$database = getenv('DB_NAME') ?: 'lab_app'; // Make sure this matches your local database name!
$port = getenv('DB_PORT') ?: 3306;

// Create connection
$connection = new mysqli($host, $user, $password, $database, $port);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}
?>