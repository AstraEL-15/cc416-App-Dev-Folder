<?php
session_start();

// SECURITY CHECK: If there is no active session, kick them out
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.7.2/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-base-200 min-h-screen p-8">
    
    <!-- Navigation Bar -->
    <div class="navbar bg-base-100 shadow-xl rounded-box mb-8 px-6">
        <div class="flex-1">
            <span class="text-xl font-bold">Lab 11 System</span>
        </div>
        <div class="flex-none">
            <span class="mr-4">Logged in as: <strong class="text-primary"><?php echo htmlspecialchars($_SESSION['username']); ?></strong></span>
            <!-- LOGOUT BUTTON -->
            <a href="logout.php" class="btn btn-error btn-sm">Logout</a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="card bg-base-100 shadow-xl max-w-4xl mx-auto">
        <div class="card-body">
            <h2 class="card-title text-3xl mb-4">Welcome to the Dashboard!</h2>
            <p>You have successfully bypassed the login screen because you have an active session.</p>
            <p class="text-sm text-gray-500 mt-4">To test the login flow again, click the Logout button above.</p>
        </div>
    </div>

</body>
</html>