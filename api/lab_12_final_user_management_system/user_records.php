<?php
require_once 'initialize.php';

// Ensure user is authenticated
if (!isset($_COOKIE['lab12_user_session'])) {
    header('Location: login.php');
    exit;
}

// Fetch user records
$stmt = $pdo->query("SELECT id, username, email, role, created_at FROM users ORDER BY id DESC");
$users = $stmt->fetchAll(PDO_FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Lab 12</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.7.2/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-base-200 min-h-screen flex">

    <!-- Pinned Left Sidebar -->
    <aside class="w-64 bg-base-100 shadow-2xl flex flex-col justify-between h-screen sticky top-0 p-4 border-r border-base-300">
        <div>
            <!-- Header Brand -->
            <div class="flex items-center gap-3 px-2 py-4 mb-6 border-b border-base-300">
                <div class="p-2 bg-primary text-primary-content rounded-lg font-black text-xl">
                    ⚡
                </div>
                <div>
                    <h1 class="font-bold text-lg leading-tight">Admin Portal</h1>
                    <span class="text-xs text-base-content/60">Lab 12 System</span>
                </div>
            </div>

            <!-- Navigation Actions -->
            <ul class="menu p-0 gap-2">
                <li>
                    <a class="active bg-primary text-primary-content font-medium">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" /></svg>
                        Dashboard
                    </a>
                </li>
                <li>
                    <button type="button" onclick="document.getElementById('add_user_modal').showModal()" class="hover:bg-base-200 text-base-content font-medium">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-success" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                        Add New User
                    </button>
                </li>
            </ul>
        </div>

        <!-- Logout Anchored to Bottom -->
        <div class="pt-4 border-t border-base-300">
            <a href="logout.php" class="btn btn-error btn-outline w-full flex justify-between items-center">
                <span>Logout</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
            </a>
        </div>
    </aside>

    <!-- Main Content Area (Middle) -->
    <main class="flex-1 p-8 overflow-y-auto">
        <!-- Dashboard Top Bar -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h2 class="text-2xl font-bold">User Management Dashboard</h2>
                <p class="text-sm text-base-content/60">Overview of registered accounts</p>
            </div>
            <div class="stat bg-base-100 shadow-md rounded-box w-auto py-2 px-6 border border-base-300">
                <div class="stat-title text-xs">Total Users</div>
                <div class="stat-value text-primary text-2xl"><?php echo count($users); ?></div>
            </div>
        </div>

        <!-- Users Table -->
        <div class="card bg-base-100 shadow-xl border border-base-300">
            <div class="card-body p-0">
                <div class="overflow-x-auto">
                    <table class="table table-zebra w-full">
                        <thead>
                            <tr class="bg-base-200/50">
                                <th>ID</th>
                                <th>User</th>
                                <th>Role</th>
                                <th>Created At</th>
                                <th class="text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                            <tr class="hover">
                                <td class="font-bold opacity-50">#<?php echo htmlspecialchars($user['id']); ?></td>
                                <td>
                                    <div class="font-bold"><?php echo htmlspecialchars($user['username']); ?></div>
                                    <div class="text-xs opacity-50"><?php echo htmlspecialchars($user['email']); ?></div>
                                </td>
                                <td>
                                    <span class="badge <?php echo $user['role'] === 'admin' ? 'badge-secondary' : 'badge-ghost'; ?> badge-sm uppercase font-semibold">
                                        <?php echo htmlspecialchars($user['role']); ?>
                                    </span>
                                </td>
                                <td class="text-sm opacity-70"><?php echo htmlspecialchars($user['created_at']); ?></td>
                                <td class="text-right space-x-2">
                                    <!-- In-Page Edit Button -->
                                    <button 
                                        type="button"
                                        onclick='openEditModal(<?php echo json_encode($user); ?>)' 
                                        class="btn btn-sm btn-warning btn-square btn-outline" 
                                        title="Edit User">
                                        ✏️
                                    </button>
                                    
                                    <!-- Delete Form -->
                                    <form action="user_delete.php" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                        <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                                        <button type="submit" class="btn btn-sm btn-error btn-square btn-outline" title="Delete User">
                                            🗑️
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <!-- IN-PAGE MODAL: ADD USER -->
    <dialog id="add_user_modal" class="modal">
        <div class="modal-box">
            <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
            </form>
            <h3 class="font-bold text-lg mb-4">Add New User</h3>
            <form action="user_add_data.php" method="POST" class="space-y-4">
                <div>
                    <label class="label"><span class="label-text">Username</span></label>
                    <input type="text" name="username" class="input input-bordered w-full" required />
                </div>
                <div>
                    <label class="label"><span class="label-text">Email</span></label>
                    <input type="email" name="email" class="input input-bordered w-full" required />
                </div>
                <div>
                    <label class="label"><span class="label-text">Password</span></label>
                    <input type="password" name="password" class="input input-bordered w-full" required />
                </div>
                <div>
                    <label class="label"><span class="label-text">Role</span></label>
                    <select name="role" class="select select-bordered w-full">
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <div class="modal-action">
                    <button type="submit" class="btn btn-primary w-full">Create User</button>
                </div>
            </form>
        </div>
    </dialog>

    <!-- IN-PAGE MODAL: EDIT USER -->
    <dialog id="edit_user_modal" class="modal">
        <div class="modal-box">
            <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
            </form>
            <h3 class="font-bold text-lg mb-4">Edit User</h3>
            <form action="user_edit_data.php" method="POST" class="space-y-4">
                <input type="hidden" name="id" id="edit_id">
                <div>
                    <label class="label"><span class="label-text">Username</span></label>
                    <input type="text" name="username" id="edit_username" class="input input-bordered w-full" required />
                </div>
                <div>
                    <label class="label"><span class="label-text">Email</span></label>
                    <input type="email" name="email" id="edit_email" class="input input-bordered w-full" required />
                </div>
                <div>
                    <label class="label"><span class="label-text">Role</span></label>
                    <select name="role" id="edit_role" class="select select-bordered w-full">
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <div class="modal-action">
                    <button type="submit" class="btn btn-warning w-full">Save Changes</button>
                </div>
            </form>
        </div>
    </dialog>

    <!-- Modal Population Script -->
    <script>
        function openEditModal(user) {
            document.getElementById('edit_id').value = user.id;
            document.getElementById('edit_username').value = user.username;
            document.getElementById('edit_email').value = user.email;
            document.getElementById('edit_role').value = user.role || 'user';
            document.getElementById('edit_user_modal').showModal();
        }
    </script>
</body>
</html>