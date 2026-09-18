<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
// 1. Database connection (using your existing local setup for now)
require_once 'db.php'; 

// 2. Pagination Logic (Task A)
$limit = 5; 
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Get total records for pagination buttons
$total_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM users");
$total_rows = mysqli_fetch_assoc($total_query)['total'];
$total_pages = ceil($total_rows / $limit);

// Fetch users for the current page
$query = "SELECT * FROM users LIMIT $offset, $limit";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <!-- Task E: Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js for Skeleton Toggle -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body class="bg-gray-50 text-gray-800 p-8">

    <!-- x-data manages the loading state for Task D -->
    <div class="max-w-4xl mx-auto" x-data="{ loading: true }" x-init="setTimeout(() => loading = false, 800)">
        
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-900">User Dashboard</h1>
            <a href="user_add.php" class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700">Add New User</a>
        </div>

        <!-- Task D: Skeleton Loader -->
        <div x-show="loading" class="animate-pulse space-y-4 bg-white p-6 rounded shadow">
            <div class="h-6 bg-gray-200 rounded w-1/4 mb-4"></div>
            <div class="h-10 bg-gray-200 rounded w-full"></div>
            <div class="h-10 bg-gray-200 rounded w-full"></div>
            <div class="h-10 bg-gray-200 rounded w-full"></div>
        </div>

        <!-- Task A: Data Table -->
        <div x-show="!loading" style="display: none;" class="bg-white rounded shadow overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-100 border-b">
                        <th class="p-4 font-semibold">ID</th>
                        <th class="p-4 font-semibold">Name</th>
                        <th class="p-4 font-semibold">Email</th>
                        <th class="p-4 font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody>
    <?php if (mysqli_num_rows($result) > 0): ?>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <?php 
                // Safe fallbacks to handle different column names and prevent null warnings
                $id    = $row['id'] ?? $row['user_id'] ?? '';
                $name  = trim(($row['firstname'] ?? $row['first_name'] ?? '') . ' ' . ($row['lastname'] ?? $row['last_name'] ?? ''));
                if (empty($name)) { $name = $row['username'] ?? 'User'; }
                $email = $row['email'] ?? $row['user_email'] ?? 'N/A';
            ?>
            <tr class="border-b hover:bg-gray-50">
                <td class="p-4"><?= htmlspecialchars((string)$id) ?></td>
                <td class="p-4"><?= htmlspecialchars((string)$name) ?></td>
                <td class="p-4"><?= htmlspecialchars((string)$email) ?></td>
                <td class="p-4">
                    <!-- Task F: Clean Alert Confirmation without syntax breaks -->
                    <a href="view.php?id=<?= urlencode((string)$id) ?>" 
                       onclick="return confirm('Are you sure you want to view user: <?= htmlspecialchars((string)$name, ENT_QUOTES) ?>?');" 
                       class="text-blue-600 hover:underline">View</a>
                </td>
            </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr><td colspan="4" class="p-4 text-center">No users found.</td></tr>
    <?php endif; ?>
</tbody>
            </table>
        </div>

        <!-- Pagination Controls -->
        <div class="mt-6 flex justify-center space-x-2" x-show="!loading" style="display: none;">
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <a href="?page=<?= $i ?>" class="px-4 py-2 border rounded <?= ($i == $page) ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-100' ?>">
                    <?= $i ?>
                </a>
            <?php endfor; ?>
        </div>

    </div>
</body>
</html>