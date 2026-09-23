<?php
// Force browser to render as HTML page instead of downloading
header('Content-Type: text/html; charset=utf-8');

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Redirect root domain visit directly to Lab 07
if ($uri === '/' || $uri === '' || $uri === '/index.php') {
    header("Location: /lab_07_create_user/user_add.php");
    exit();
}

// Map incoming path to project root
$file = __DIR__ . '/..' . $uri;

if (file_exists($file) && !is_dir($file)) {
    require $file;
} else {
    http_response_code(404);
    echo "<h1>404 Not Found</h1><p>The path " . htmlspecialchars($uri) . " does not exist.</p>";
}
?>