<?php
// 1. Force Safari/Vercel to render HTML, never download
header('Content-Type: text/html; charset=utf-8');

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// 2. Redirect root visitors to Lab 07
if ($uri === '/' || $uri === '') {
    header("Location: /lab_07_create_user/user_add.php");
    exit();
}

// 3. Find and execute the requested PHP file
$file = realpath(__DIR__ . '/..' . $uri);

if ($file && file_exists($file) && !is_dir($file)) {
    require $file;
} else {
    http_response_code(404);
    echo "<h2>404 Not Found: " . htmlspecialchars($uri) . "</h2>";
}
?>