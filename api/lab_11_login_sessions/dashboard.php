<?php include 'initialize.php'; ?>
<?php
// Secure the page: kick out unauthenticated users
if(!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.10.2/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-base-100 h-screen flex items-center justify-center font-sans">

    <div class="text-center space-y-6">
        <h3 class="text-4xl font-extrabold text-primary">
            Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!
        </h3>
        <p class="text-base-content/70">You have successfully logged into the system.</p>
        
        <div class="flex justify-center gap-4 mt-6">
            <a href="../lab_08_read_user_records/user_records.php" class="btn btn-info">Go to Admin Panel</a>
            <a href="logout.php" class="btn btn-error btn-outline">Logout</a>
        </div>
    </div>

</body>
</html>