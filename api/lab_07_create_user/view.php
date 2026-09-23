<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'db.php';

// Get user ID safely from the URL parameter
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    die("Invalid User ID requested.");
}

// Fetch record matching ID
$query = "SELECT * FROM users WHERE id = $id";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

if (!$user) {
    die("User record not found.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View User Details</title>
    <!-- Task E: Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800 p-8">

    <div class="max-w-lg mx-auto bg-white rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-bold mb-6 text-gray-900 border-b pb-3">User Profile Details</h1>

        <div class="space-y-4">
            <div>
                <span class="text-xs font-bold text-gray-500 uppercase tracking-wide">ID</span>
                <p class="text-base text-gray-800 font-medium"><?= htmlspecialchars((string)($user['id'] ?? $id)) ?></p>
            </div>
            <div>
                <span class="text-xs font-bold text-gray-500 uppercase tracking-wide">First Name</span>
                <p class="text-base text-gray-800 font-medium"><?= htmlspecialchars((string)($user['firstname'] ?? $user['first_name'] ?? 'N/A')) ?></p>
            </div>
            <div>
                <span class="text-xs font-bold text-gray-500 uppercase tracking-wide">Last Name</span>
                <p class="text-base text-gray-800 font-medium"><?= htmlspecialchars((string)($user['lastname'] ?? $user['last_name'] ?? 'N/A')) ?></p>
            </div>
            <div>
                <span class="text-xs font-bold text-gray-500 uppercase tracking-wide">Email</span>
                <p class="text-base text-gray-800 font-medium"><?= htmlspecialchars((string)($user['email'] ?? $user['user_email'] ?? 'N/A')) ?></p>
            </div>
        </div>

        <div class="mt-8 pt-4 border-t flex justify-end">
            <a href="dashboard.php" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700 transition-colors">
                Back to Dashboard
            </a>
        </div>
    </div>

</body>
</html>