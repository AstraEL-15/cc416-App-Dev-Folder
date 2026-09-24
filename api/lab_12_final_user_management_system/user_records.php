<?php
if (!isset($_COOKIE['lab12_user_id'])) {
    header('Location: login.php');
    exit;
}
include 'initialize.php';

// --- SEARCH & PAGINATION SETUP ---
$search = isset($_GET['search']) ? mysqli_real_escape_string($connection,$_GET['search']) : '';
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10;
$offset = ($page - 1) *$limit;

$whereClause = "";
if (!empty($search)) {$whereClause = "WHERE username LIKE '%$search%' OR firstname LIKE '%$search\%' OR lastname LIKE '\%$search%'";
}

$countQuery = "SELECT COUNT(*) as total FROM users $whereClause";
$countResult = mysqli_query($connection, $countQuery);$totalRecords = mysqli_fetch_assoc($countResult)['total'];$totalPages = ceil($totalRecords / $limit);
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
            <div class="p-6 border-b border-base-300 bg-primary/5">
                <h2 class="text-2xl font-black text-primary">Admin Panel</h2>
                <p class="text-sm mt-3 text-base-content/80">
                    Welcome back,<br>
                    <span class="font-bold text-lg text-base-content"><?php echo htmlspecialchars($_COOKIE['lab12_username']); ?></span>
                </p>
            </div>
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
        <div class="p-4 border-t border-base-300">
            <a href="logout.php" class="btn btn-error btn-outline w-full font-bold">Logout</a>
        </div>
    </aside>

    <!-- Main Dashboard Content -->
    <main class="flex-1 p-10 overflow-y-auto flex flex-col">
       <div class="max-w-5xl mx-auto w-full flex-1 flex flex-col">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-3xl font-bold">User Records</h2>
            </div>

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

            <!-- Live Search Bar -->
            <div class="flex gap-2 mb-6">
                <!-- Removed the form tags so it doesn't reload the page on Enter -->
                <input type="text" id="searchInput" value="<?php echo htmlspecialchars($search); ?>" placeholder="Type to search users..." class="input input-bordered w-full max-w-md" autocomplete="off" />
            </div>

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
                            <!-- Added ID here for JavaScript to target -->
                            <tbody id="table-body">
                                <?php
                               $query = "SELECT * FROM users $whereClause ORDER BY username ASC LIMIT $offset, $limit";
                                $result = mysqli_query($connection,$query);
                                
                                if (mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<tr>";
                                        echo "<td class='font-medium'>" . htmlspecialchars($row['username']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['firstname']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['lastname']) . "</td>";
                                        
                                        echo "<td class='text-right space-x-2'>";
                                        
                                        $id =$row['id'];
                                        $username = addslashes($row['username']);
                                        $firstname = addslashes($row['firstname']);
                                        $lastname = addslashes($row['lastname']);
                                        
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

            <!-- Pagination Wrapper for JavaScript -->
            <div id="pagination-wrapper" class="mt-auto pb-4">
                <?php if ($totalPages > 1): ?>
                <div class="flex justify-center mt-8">
                    <div class="join">
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <a href="?page=<?php echo $i; ?><?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?>" 
                               class="join-item btn <?php echo $i ===$page ? 'btn-active' : ''; ?>">
                                <?php echo $i; ?>
                            </a>
                        <?php endfor; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>

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

    <script>
    // EDIT MODAL FUNCTION
    function openEditModal(id, username, firstname, lastname) {
    document.getElementById('edit_id').value = id;
    document.getElementById('edit_username').value = username;
    document.getElementById('edit_firstname').value = firstname;
    document.getElementById('edit_lastname').value = lastname;
    document.getElementById('edit_user_modal').showModal();
}

    // LIVE SEARCH WITH SKELETON LOADING
    let typingTimer;
    const searchInput = document.getElementById('searchInput');

    // 1. Define what our skeleton rows look like
    const skeletonHTML = `
        <tr>
            <td><div class="skeleton h-4 w-32"></div></td>
            <td><div class="skeleton h-4 w-24"></div></td>
            <td><div class="skeleton h-4 w-24"></div></td>
            <td class="text-right space-x-2">
             <div class="skeleton h-8 w-12 inline-block rounded-lg"></div>
             <div class="skeleton h-8 w-16 inline-block rounded-lg"></div>
        </td>
    </tr>
`.repeat(5); // Show 5 fake rows while loading

searchInput.addEventListener('input', function() {
    clearTimeout(typingTimer);
    
    // 2. Immediately show skeletons and fade pagination
    document.getElementById('table-body').innerHTML = skeletonHTML;
    document.getElementById('pagination-wrapper').style.opacity = '0.5';
    document.getElementById('pagination-wrapper').style.pointerEvents = 'none'; // Prevent clicking
    
    // 3. Wait 300ms before fetching new data
    typingTimer = setTimeout(() => {
        const searchTerm = searchInput.value;
        
        // Update URL
        const newUrl = new URL(window.location);
        newUrl.searchParams.set('search', searchTerm);
        newUrl.searchParams.set('page', 1);
        window.history.pushState({}, '', newUrl);

        // Fetch real data
        fetch(`user_records.php?search=${encodeURIComponent(searchTerm)}`)
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                
                // Swap skeletons for real data
                document.getElementById('table-body').innerHTML = doc.getElementById('table-body').innerHTML;
                
                // Restore pagination
                const paginationWrap = document.getElementById('pagination-wrapper');
                paginationWrap.innerHTML = doc.getElementById('pagination-wrapper').innerHTML;
                paginationWrap.style.opacity = '1';
                paginationWrap.style.pointerEvents = 'auto';
            });
    }, 300);
});
</script>
</body>
</html>