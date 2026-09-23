<?php
// KEEP YOUR EXISTING PHP DATABASE CONNECTION AND QUERY AT THE TOP
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// include '../../local_env.php';
// ... your existing mysqli query code ...
?>
<!DOCTYPE html>
<html lang="en" data-theme="winter">
<head>
    <meta charset="UTF-8">
    <title>User Records Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.10.2/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-base-200/50 min-h-screen p-6 md:p-10 font-sans">
    
    <div class="max-w-6xl mx-auto">
        
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
            <div>
                <h2 class="text-3xl font-extrabold text-primary">User's Record List</h2>
                <p class="text-base-content/70 mt-1">Manage your registered users and their details.</p>
            </div>
            <div class="flex items-center gap-4">
                <!-- User Badge -->
                <div class="badge badge-neutral p-4 font-semibold shadow-sm">
                    Hello, John (Juan)
                </div>
                <!-- Add User Button -->
                <a href="../lab_07_create_user/user_add.php" class="btn btn-primary shadow-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Add User
                </a>
            </div>
        </div>

        <!-- Table Card -->
        <div class="card bg-base-100 shadow-xl border border-base-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="table table-zebra w-full">
                    <!-- Table Header -->
                    <thead class="bg-base-200/50 text-base-content text-sm uppercase font-bold">
                        <tr>
                            <th>Username</th>
                            <th>Firstname</th>
                            <th>Lastname</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        <?php
                        // START YOUR PHP WHILE LOOP HERE
                        // Example: while ($row = $result->fetch_assoc()) {
                        ?>
                        
                        <tr class="hover">
                            <td class="font-medium text-base-content">
                                <!-- Example: <?php echo htmlspecialchars($row['username']); ?> -->
                                zen3
                            </td>
                            <td>Zen</td>
                            <td>Three</td>
                            <td>
                                <div class="flex justify-center gap-2">
                                    <!-- Edit Button -->
                                    <a href="../lab_07_create_user/user_edit.php?id=YOUR_ID" class="btn btn-sm btn-info btn-outline">
                                        Edit
                                    </a>
                                    <!-- Delete Button -->
                                    <a href="../lab_07_create_user/user_delete.php?id=YOUR_ID" class="btn btn-sm btn-error btn-outline" onclick="return confirm('Are you sure you want to delete this user?');">
                                        Delete
                                    </a>
                                </div>
                            </td>
                        </tr>

                        <?php
                        // END YOUR PHP WHILE LOOP HERE
                        // Example: } 
                        ?>

                    </tbody>
                </table>
            </div>
        </div>
        
    </div>
</body>
</html>