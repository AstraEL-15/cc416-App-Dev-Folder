<?php
if (!isset($_COOKIE['lab12_user_id'])) {
    header('Location: login.php');
    exit;
}
include 'initialize.php';

// --- SEARCH & PAGINATION SETUP ---
// 1. Get the current search term if there is one
$search = isset($_GET['search']) ? mysqli_real_escape_string($connection, $_GET['search']) : '';

// 2. Figure out what page we are on (default to 1)
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10; // Show 10 people at a time
$offset = ($page - 1) * $limit;

// 3. Build the search filter for our SQL queries
$whereClause = "";
if (!empty($search)) {
    $whereClause = "WHERE username LIKE '%$search%' OR firstname LIKE '%$search%' OR lastname LIKE '%$search%'";
}

// 4. Count total users (so we know how many page numbers to generate)
$countQuery = "SELECT COUNT(*) as total FROM users $whereClause";
$countResult = mysqli_query($connection, $countQuery);
$totalRecords = mysqli_fetch_assoc($countResult)['total'];
$totalPages = ceil($totalRecords / $limit);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab 12 - Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@3.9.0/dist/full.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-base-200 min-h-screen flex">

    <!-- Sidebar Panel -->
    <aside class="w-64 bg-base-100 shadow-2xl flex flex-col justify-between h-screen sticky top-0 border-r border-base-300">
        <div>
            <!-- Brand / User Info -->
            <div class="p-6 border-b border-base-300 bg-primary/5">
                <h2 class="text-2xl font-black text-primary">Admin Panel</h2>
                <p class="text-sm mt-3 text-base-content/80">
                    Welcome back,<br>
                    <span class="font-bold text-lg text-base-content"><?php echo htmlspecialchars($_COOKIE['lab12_username']); ?></span>
                </p>
            </div>

            <!-- Sidebar Navigation -->
            <ul class="menu p-4 w-full gap-2 text-base">
                <li>
                    <a href="user_records.php" class="active bg-primary text-primary-content shadow-sm">Dashboard</a>
                </li>
                <li>
                    <button type="button" onclick="document.getElementById('add_user_modal').showModal()" class="text-base-content hover:bg-base-200 mt-2 font-medium">
                        + Add New User
                    </button>
                </li>
            </ul>
        </div>

        <!-- Bottom Logout -->
        <div class="p-4 border-t border-base-300">
            <a href="logout.php" class="btn btn-error btn-outline w-full font-bold">Logout</a>
        </div>
    </aside>

    <!-- Main Dashboard Content -->
    <main class="flex-1 p-10 overflow-y-auto">
        <div class="max-w-5xl mx-auto">
            <!-- Page Header -->
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-3xl font-bold">User Records</h2>
            </div>

            <!-- Alerts -->
            <?php if (isset($_GET['msg'])): ?>
                <div class="alert alert-success shadow-lg rounded-xl mb-6 text-white">
                    <span><?php echo htmlspecialchars($_GET['msg']); ?></span>
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-error shadow-lg rounded-xl mb-6 text-white">
                    <span><?php echo htmlspecialchars($_GET['error']); ?></span>
                </div>
            <?php endif; ?>

            <!-- Search Bar -->
            <form method="GET" action="user_records.php" class="flex gap-2 mb-6">
                <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>" placeholder="Search by name or username..." class="input input-bordered w-full max-w-md" />
                <button type="submit" class="btn btn-primary">Search</button>
                <?php if(!empty($search)): ?>
                    <a href="user_records.php" class="btn btn-outline">Clear</a>
                <?php endif; ?>
            </form>

            <!-- Data Table -->
            <div class="card bg-base-100 shadow-xl border border-base-300">
                <div class="card-body p-0">
                    <div class="overflow-x-auto">
                        <table class="table table-zebra w-full text-base">
                            <thead class="bg-base-200 text-base-content text-sm">
                                <tr>
                                    <th>Username</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th class="text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // 5. Get the actual users, alphabetized (ASC), with limits applied
                                $query = "SELECT * FROM users $whereClause ORDER BY username ASC LIMIT $limit OFFSET $offset";
                                $result = mysqli_query($connection, $query);
                                
                                if (mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<tr>";
                                        echo "<td class='font-medium'>" . htmlspecialchars($row['username']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['firstname']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['lastname']) . "</td>";
                                        
                                        echo "<td class='text-right space-x-2'>";
                                        
                                        $id = $row['id'];
                                        $username = addslashes($row['username']);
                                        $firstname = addslashes($row['firstname']);
                                        $lastname = addslashes($row['lastname']);
                                        
                                        // Edit & Delete Buttons
                                        echo "<button type='button' onclick=\"openEditModal($id, '$username', '$firstname', '$lastname')\" class='btn btn-warning btn-sm'>Edit</button>";
                                        echo "<a href='user_delete.php?user-id=" . $row['id'] . "' class='btn btn-error btn-sm' onclick=\"return confirm('Are you sure you want to delete this user?');\">Delete</a>";
                                        echo "</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='4' class='text-center py-4 text-base-content/60'>No users found.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Pagination (The numbers underneath) -->
            <?php if ($totalPages > 1): ?>
            <div class="flex justify-center mt-8">
                <div class="join">
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <a href="?page=<?php echo $i; ?><?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?>" 
                           class="join-item btn <?php echo $i === $page ? 'btn-active' : ''; ?>">
                            <?php echo $i; ?>
                        </a>
                    <?php endfor; ?>
                </div>
            </div>
            <?php endif; ?>

        </div>
    </main>

    <!-- IN-PAGE MODAL: ADD NEW USER -->
    <dialog id="add_user_modal" class="modal">
        <div class="modal-box">
            <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
            </form>
            <h3 class="font-bold text-2xl mb-6">Add New User</h3>
            
            <form action="user_add_data.php" method="POST" class="space-y-4">
                <div class="form-control">
                    <label class="label"><span class="label-text font-semibold">Username</span></label>
                    <input type="text" name="username" class="input input-bordered w-full" required />
                </div>
                <div class="form-control">
                    <label class="label"><span class="label-text font-semibold">First Name</span></label>
                    <input type="text" name="firstname" class="input input-bordered w-full" required />
                </div>
                <div class="form-control">
                    <label class="label"><span class="label-text font-semibold">Last Name</span></label>
                    <input type="text" name="lastname" class="input input-bordered w-full" required />
                </div>
                <div class="form-control">
                    <label class="label"><span class="label-text font-semibold">Password</span></label>
                    <input type="password" name="password" class="input input-bordered w-full" required />
                </div>
                <!-- Confirm Password Field added previously -->
                <div class="form-control">
                    <label class="label"><span class="label-text font-semibold">Confirm Password</span></label>
                    <input type="password" name="confirm_password" class="input input-bordered w-full" required />
                </div>
                <div class="modal-action mt-6">
                    <button type="submit" class="btn btn-primary w-full text-lg">Save User</button>
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
            <h3 class="font-bold text-2xl mb-6">Edit User</h3>
            
            <form action="user_edit_data.php" method="POST" class="space-y-4">
                <input type="hidden" name="user-id" id="edit_id">
                
                <div class="form-control">
                    <label class="label"><span class="label-text font-semibold">Username</span></label>
                    <input type="text" name="username" id="edit_username" class="input input-bordered w-full" required />
                </div>
                <div class="form-control">
                    <label class="label"><span class="label-text font-semibold">First Name</span></label>
                    <input type="text" name="firstname" id="edit_firstname" class="input input-bordered w-full" required />
                </div>
                <div class="form-control">
                    <label class="label"><span class="label-text font-semibold">Last Name</span></label>
                    <input type="text" name="lastname" id="edit_lastname" class="input input-bordered w-full" required />
                </div>
                <div class="modal-action mt-6">
                    <button type="submit" class="btn btn-warning w-full text-lg">Update User</button>
                </div>
            </form>
        </div>
    </dialog>

    <!-- JavaScript to populate the Edit Modal dynamically -->
    <script>
    function openEditModal(id, username, firstname, lastname) {
        document.getElementById('edit_id').value = id;
        document.getElementById('edit_username').value = username;
        document.getElementById('edit_firstname').value = firstname;
        document.getElementById('edit_lastname').value = lastname;
        document.getElementById('edit_user_modal').showModal();
    }
    </script>
</body>
</html>