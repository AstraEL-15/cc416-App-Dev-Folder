<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'initialize.php';

// Fetch all users from Aiven DB
$result = mysqli_query($conn, "SELECT * FROM users ORDER BY id DESC");
$users = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $users[] = $row;
    }
}

// Check if directed back to add_user tab on error
$defaultTab = isset($_GET['tab']) ? $_GET['tab'] : 'users';
?>
<!DOCTYPE html>
<html lang="en" data-theme="winter">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management Dashboard</title>
    <!-- DaisyUI + Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.10.2/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js for single-page dynamic view switching -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-base-200 min-h-screen font-sans" x-data="{ currentTab: '<?php echo $defaultTab; ?>' }">

    <div class="flex min-h-screen">
        
        <!-- SIDEBAR -->
        <aside class="w-64 bg-base-100 border-r border-base-300 flex flex-col justify-between p-4 shadow-sm">
            <div class="space-y-6">
                <!-- App Brand / Logo -->
                <div class="flex items-center gap-3 px-2 py-3 border-b border-base-200">
                    <div class="w-10 h-10 rounded-xl bg-primary text-primary-content flex items-center justify-center font-bold text-xl shadow">
                        U
                    </div>
                    <div>
                        <h1 class="font-extrabold text-lg text-base-content leading-tight">AdminPortal</h1>
                        <p class="text-xs text-base-content/60 font-medium">Management Hub</p>
                    </div>
                </div>

                <!-- Navigation Links -->
                <nav class="space-y-1">
                    <button 
                        @click="currentTab = 'users'" 
                        :class="currentTab === 'users' ? 'btn-primary shadow-sm' : 'btn-ghost text-base-content/70 hover:text-base-content'" 
                        class="btn w-full justify-start gap-3 font-semibold text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                        User Directory
                    </button>

                    <button 
                        @click="currentTab = 'add_user'" 
                        :class="currentTab === 'add_user' ? 'btn-primary shadow-sm' : 'btn-ghost text-base-content/70 hover:text-base-content'" 
                        class="btn w-full justify-start gap-3 font-semibold text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" /></svg>
                        Add New User
                    </button>
                </nav>
            </div>

            <!-- Footer Badge -->
            <div class="bg-base-200/60 rounded-xl p-3 text-xs text-base-content/60 flex items-center justify-between">
                <span>Database Status</span>
                <span class="badge badge-success badge-xs gap-1 font-semibold text-white">Connected</span>
            </div>
        </aside>

        <!-- MAIN CONTENT AREA -->
        <main class="flex-1 p-8 overflow-y-auto space-y-6">

            <!-- Global Alert Banner -->
            <?php if (isset($_SESSION['alert_message'])): ?>
                <div class="alert alert-info shadow-md rounded-xl text-white font-medium flex justify-between">
                    <span><?php echo $_SESSION['alert_message']; ?></span>
                    <button onclick="this.parentElement.remove()" class="btn btn-xs btn-ghost text-white">✕</button>
                </div>
                <?php unset($_SESSION['alert_message']); ?>
            <?php endif; ?>

            <!-- VIEW 1: USER DIRECTORY TABLE -->
            <div x-show="currentTab === 'users'" x-transition class="space-y-6">
                <!-- Header -->
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-black text-base-content">User Directory</h2>
                        <p class="text-sm text-base-content/60">View and manage registered system accounts</p>
                    </div>
                    <button @click="currentTab = 'add_user'" class="btn btn-primary gap-2 shadow">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                        Add New User
                    </button>
                </div>

                <!-- Stats Summary Row -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="stat bg-base-100 rounded-2xl border border-base-300 shadow-sm">
                        <div class="stat-title text-xs font-bold uppercase tracking-wider">Total Registered</div>
                        <div class="stat-value text-primary mt-1"><?php echo count($users); ?></div>
                        <div class="stat-desc mt-1">Synced with Aiven MySQL</div>
                    </div>
                </div>

                <!-- Table Container -->
                <div class="card bg-base-100 border border-base-300 shadow-sm">
                    <div class="overflow-x-auto">
                        <table class="table table-zebra w-full">
                            <thead>
                                <tr class="bg-base-200/50 text-base-content/70">
                                    <th>ID</th>
                                    <th>Full Name</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th class="text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($users)): ?>
                                    <?php foreach ($users as $user): ?>
                                        <tr class="hover">
                                            <td class="font-mono text-xs opacity-60">#<?php echo htmlspecialchars($user['id']); ?></td>
                                            <td class="font-bold text-base-content">
                                                <?php echo htmlspecialchars($user['firstname'] . ' ' . $user['lastname']); ?>
                                            </td>
                                            <td>
                                                <span class="badge badge-ghost font-mono text-xs">
                                                    @<?php echo htmlspecialchars($user['username'] ?? 'N/A'); ?>
                                                </span>
                                            </td>
                                            <td class="text-base-content/70">
                                                <?php echo htmlspecialchars($user['email'] ?? 'N/A'); ?>
                                            </td>
                                            <td class="text-right">
                                                <a href="view.php?id=<?php echo $user['id']; ?>" class="btn btn-ghost btn-xs text-primary font-semibold">View</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" class="text-center py-8 text-base-content/50">No users found in database.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- VIEW 2: ADD USER FORM (Embedded directly) -->
            <div x-show="currentTab === 'add_user'" x-transition class="max-w-2xl mx-auto space-y-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-black text-base-content">Add New User</h2>
                        <p class="text-sm text-base-content/60">Create a new account record in the Aiven database</p>
                    </div>
                    <button @click="currentTab = 'users'" class="btn btn-ghost btn-sm gap-2">
                        ← Back to Directory
                    </button>
                </div>

                <div class="card bg-base-100 border border-base-300 shadow-sm">
                    <div class="card-body">
                        <form method="POST" action="user_add_data.php" class="space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="form-control">
                                    <label class="label"><span class="label-text font-semibold">First Name</span></label>
                                    <input type="text" name="firstname" class="input input-bordered w-full" placeholder="John" required />
                                </div>
                                <div class="form-control">
                                    <label class="label"><span class="label-text font-semibold">Last Name</span></label>
                                    <input type="text" name="lastname" class="input input-bordered w-full" placeholder="Doe" required />
                                </div>
                            </div>

                            <div class="form-control">
                                <label class="label"><span class="label-text font-semibold">Username</span></label>
                                <input type="text" name="username" class="input input-bordered w-full" placeholder="johndoe" required />
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="form-control">
                                    <label class="label"><span class="label-text font-semibold">Password</span></label>
                                    <input type="password" name="password" class="input input-bordered w-full" placeholder="••••••••" required />
                                </div>
                                <div class="form-control">
                                    <label class="label"><span class="label-text font-semibold">Confirm Password</span></label>
                                    <input type="password" name="confirm_password" class="input input-bordered w-full" placeholder="••••••••" required />
                                </div>
                            </div>

                            <div class="pt-4 flex items-center justify-end gap-3">
                                <button type="button" @click="currentTab = 'users'" class="btn btn-ghost">Cancel</button>
                                <button type="submit" class="btn btn-primary px-8 shadow">Save User</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </main>
    </div>

</body>
</html>