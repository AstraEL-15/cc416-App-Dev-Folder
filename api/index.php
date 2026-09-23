<?php
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Redirect root domain visit directly to Lab 07 user_add.php (or index.php)
if ($uri === '/' || $uri === '' || $uri === '/index.php') {
    header("Location: /lab_07_create_user/user_add.php");
    exit();
}

// Map incoming request path to your actual lab files
$file = __DIR__ . '/..' . $uri;

if (file_exists($file) && !is_dir($file)) {
    require $file;
} else {
    http_response_code(404);
    echo "<h1>404 Not Found</h1><p>The path " . htmlspecialchars($uri) . " does not exist.</p>";
}
?>