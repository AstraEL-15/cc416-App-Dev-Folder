<?php
if (!isset($_COOKIE['lab12_user_id'])) {
    header('Location: login.php');
    exit;
}
include 'initialize.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab 12 - Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@3.9.0/dist/full.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-base-200 min-h-screen p-8">

    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-3xl font-bold">User Records</h2>
            <div class="flex gap-2 items-center">
                <span class="mr-4">Hello, <span class="font-bold text-primary"><?php echo htmlspecialchars($_COOKIE['lab12_username']); ?></span>!</span>
                <a href="logout.php" class="btn btn-outline btn-error btn-sm">Logout</a>
            </div>
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

        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <div class="flex justify-end mb-4">
                    <a href="user_add.php" class="btn btn-primary btn-sm">Add New User</a>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="table table-zebra w-full">
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = "SELECT * FROM users";
                            $result = mysqli_query($connection, $query);
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['firstname']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['lastname']) . "</td>";
                                echo "<td class='flex gap-2'>";
                                echo "<a href='user_edit.php?user-id=" . $row['id'] . "' class='btn btn-warning btn-xs'>Edit</a>";
                                echo "<a href='user_delete.php?user-id=" . $row['id'] . "' class='btn btn-error btn-xs' onclick=\"return confirm('Are you sure you want to delete this user?');\">Delete</a>";
                                echo "</td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</body>
</html>