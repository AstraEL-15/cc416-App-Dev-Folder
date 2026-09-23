<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include 'initialize.php'; 
?>
<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- DaisyUI & Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.10.2/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-base-100 h-screen font-sans flex overflow-hidden">

    <!-- Sidebar Navigation -->
    <aside class="w-64 bg-base-200 border-r border-base-300 flex flex-col hidden md:flex">
        <div class="p-6 text-2xl font-bold text-primary border-b border-base-300">
            Admin Panel
        </div>
        <ul class="menu p-4 w-full text-base-content flex-1 space-y-2 font-medium">
            <li>
                <a id="btn-dashboard" class="active" onclick="toggleView('dashboard')">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" /></svg>
                    Dashboard
                </a>
            </li>
            <li>
                <a id="btn-add-user" onclick="toggleView('add-user')">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                    Add User
                </a>
            </li>
        </ul>
    </aside>

    <!-- Main Content Area -->
    <main class="flex-1 overflow-y-auto p-6 md:p-10 relative">
        
        <!-- Session Alerts -->
        <?php if (isset($_SESSION['alert_message'])): ?>
            <div class="alert alert-info shadow-lg rounded-xl mb-6 text-white font-medium flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                <span><?php echo $_SESSION['alert_message']; ?></span>
            </div>
            <?php unset($_SESSION['alert_message']); ?>
        <?php endif; ?>

        <!-- VIEW 1: DASHBOARD TABLE -->
        <div id="view-dashboard" class="block max-w-6xl mx-auto">
            <div class="mb-8">
                <h2 class="text-3xl font-extrabold text-primary">User's Record List</h2>
                <p class="text-base-content/70 mt-1">Manage your registered users and their details.</p>
            </div>

            <div class="card bg-base-200 shadow-xl border border-base-300 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="table table-zebra w-full text-left">
                        <thead class="bg-base-300 text-base-content text-sm uppercase font-bold">
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
                                            <a href="../lab_07_create_user/user_edit.php?user-id=<?php echo $row['id']; ?>" class="btn btn-sm btn-info btn-outline">Edit</a>
                                            <button onclick="deleteRecord(<?php echo $row['id']; ?>)" class="btn btn-sm btn-error btn-outline">Delete</button>
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

        <!-- VIEW 2: ADD USER FORM (Hidden by default) -->
        <div id="view-add-user" class="hidden max-w-md mx-auto">
            <div class="mb-8 text-center">
                <h2 class="text-3xl font-extrabold text-primary">Create New User</h2>
                <p class="text-base-content/70 mt-1">Add a new record to the database.</p>
            </div>

            <div class="card bg-base-200 shadow-xl border border-base-300">
                <div class="card-body">
                    <!-- Form still submits to your existing processor file! -->
                    <form method="POST" action="../lab_07_create_user/user_add_data.php" class="space-y-4">
                        <div class="form-control">
                            <label class="label"><span class="label-text font-semibold">Firstname</span></label>
                            <input type="text" name="firstname" class="input input-bordered bg-base-100 w-full" required />
                        </div>
                        <div class="form-control">
                            <label class="label"><span class="label-text font-semibold">Lastname</span></label>
                            <input type="text" name="lastname" class="input input-bordered bg-base-100 w-full" required />
                        </div>
                        <div class="form-control">
                            <label class="label"><span class="label-text font-semibold">Username</span></label>
                            <input type="text" name="username" class="input input-bordered bg-base-100 w-full" required />
                        </div>
                        <div class="form-control">
                            <label class="label"><span class="label-text font-semibold">Password</span></label>
                            <input type="password" name="password" class="input input-bordered bg-base-100 w-full" required />
                        </div>
                        <div class="form-control">
                            <label class="label"><span class="label-text font-semibold">Confirm Password</span></label>
                            <input type="password" name="confirm_password" class="input input-bordered bg-base-100 w-full" required />
                        </div>
                        <div class="form-control mt-6">
                            <button type="submit" class="btn btn-primary w-full">Save User</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </main>

<script>
    // Delete Confirmation Logic
    function deleteRecord(id) {
        if (confirm("Are you sure you want to delete this user?")) {
            window.location.href = "../lab_07_create_user/user_delete.php?user-id=" + id;
        }
    }

    // Toggle between Dashboard and Add User panels
    function toggleView(view) {
        const dashboardView = document.getElementById('view-dashboard');
        const addUserView = document.getElementById('view-add-user');
        const btnDashboard = document.getElementById('btn-dashboard');
        const btnAddUser = document.getElementById('btn-add-user');

        if (view === 'dashboard') {
            dashboardView.classList.remove('hidden');
            addUserView.classList.add('hidden');
            btnDashboard.classList.add('active');
            btnAddUser.classList.remove('active');
        } else if (view === 'add-user') {
            addUserView.classList.remove('hidden');
            dashboardView.classList.add('hidden');
            btnAddUser.classList.add('active');
            btnDashboard.classList.remove('active');
        }
    }
</script>
</body>
</html>