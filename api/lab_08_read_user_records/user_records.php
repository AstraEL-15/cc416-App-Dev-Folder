<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include 'initialize.php'; 
?>
<!DOCTYPE html>
<html lang="en" data-theme="winter">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User's Record List</title>
    <!-- DaisyUI & Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.10.2/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-base-200/50 min-h-screen p-6 md:p-10 font-sans">

    <div class="max-w-6xl mx-auto">
        
        <!-- Alerts -->
        <?php if (isset($_SESSION['alert_message'])): ?>
            <div class="alert alert-success shadow-sm rounded-xl mb-6 text-white font-medium flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                <span><?php echo $_SESSION['alert_message']; ?></span>
            </div>
            <?php unset($_SESSION['alert_message']); ?>
        <?php endif; ?>
        
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
            <div>
                <h2 class="text-3xl font-extrabold text-primary">User's Record List</h2>
                <p class="text-base-content/70 mt-1">Manage your registered users and their details.</p>
            </div>
            <div class="flex items-center gap-4">
                <div class="badge badge-neutral p-4 font-semibold shadow-sm">
                    Hello, John (Juan)
                </div>
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
                <table class="table table-zebra w-full text-left">
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
                        $query = "SELECT * FROM users";
                        $result = mysqli_query($connection, $query);
                        if ($result && mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                            <tr class="hover">
                                <td class="font-medium text-base-content"><?php echo htmlspecialchars($row['username']); ?></td>
                                <td><?php echo htmlspecialchars($row['firstname']); ?></td>
                                <td><?php echo htmlspecialchars($row['lastname']); ?></td>
                                <td>
                                    <div class="flex justify-center gap-2">
                                        <!-- Edit Button -->
                                        <a href="../lab_07_create_user/user_edit.php?user-id=<?php echo $row['id']; ?>" class="btn btn-sm btn-info btn-outline">
                                            Edit
                                        </a>
                                        <!-- Delete Button -->
                                        <button onclick="deleteRecord(<?php echo $row['id']; ?>)" class="btn btn-sm btn-error btn-outline">
                                            Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php 
                            }
                        } else {
                        ?>
                            <tr>
                                <td colspan="4" class="py-8 text-center text-base-content/50 font-medium">No users found.</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        
    </div>

<script>
    function deleteRecord(id) {
        if (confirm("Are you sure you want to delete this user?")) {
            window.location.href = "../lab_07_create_user/user_delete.php?user-id=" + id;
        }
    }
</script>
</body>
</html>