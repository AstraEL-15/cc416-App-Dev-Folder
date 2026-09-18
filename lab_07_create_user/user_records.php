<?php include 'initialize.php'; ?>
<!DOCTYPE html>
<html lang="en" data-theme="winter">
<head>
    <meta charset="UTF-8">
    <title>Record List</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.10.2/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-base-200/50 min-h-screen flex items-center justify-center p-6 font-sans">
    <div class="max-w-md w-full card bg-base-100 shadow-xl border border-base-200">
        <div class="card-body text-center">
            <h3 class="text-2xl font-extrabold text-primary mb-4">User's Record List</h3>
            
            <?php
            if (isset($_SESSION['alert_message'])) {
                echo '<div class="alert alert-success shadow-sm rounded-xl mb-4 text-white font-medium"><span>' . $_SESSION['alert_message'] . '</span></div>';
                unset($_SESSION['alert_message']);
            }
            ?>
            
            <div class="mt-4">
                <a href="user_add.php" class="btn btn-outline btn-primary w-full">Add Another User</a>
            </div>
        </div>
    </div>
</body>
</html>
