<?php include 'initialize.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User's Record List</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-10 font-sans text-gray-800">

    <div class="max-w-5xl mx-auto">
        
        <!-- Alerts -->
        <?php if (isset($_SESSION['alert_message'])): ?>
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm">
                <?php echo $_SESSION['alert_message']; ?>
            </div>
            <?php unset($_SESSION['alert_message']); ?>
        <?php endif; ?>

        <!-- Main Card -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
            
            <!-- Header Section -->
            <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                <h2 class="text-2xl font-bold text-gray-900 tracking-tight">User's Record List</h2>
                <span class="text-gray-500 font-medium bg-gray-200/50 px-4 py-1.5 rounded-full text-sm">Hello, John (Juan)</span>
            </div>

            <!-- Toolbar Section -->
            <div class="p-6 pb-0 flex justify-between items-center">
                <!-- Ensure this link points to your modern form file -->
                <a href="../lab_07_create_user/user_add.php" class="bg-blue-600 text-white px-5 py-2.5 rounded-lg hover:bg-blue-700 font-semibold shadow-md transition-colors flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" /></svg>
                    Add User
                </a>
            </div>

            <!-- Table Section -->
            <div class="p-6 overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 text-gray-500 text-sm uppercase tracking-wider border-y border-gray-200">
                            <th class="py-4 px-6 font-semibold">Username</th>
                            <th class="py-4 px-6 font-semibold">Firstname</th>
                            <th class="py-4 px-6 font-semibold">Lastname</th>
                            <th class="py-4 px-6 font-semibold text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php
                        $query = "SELECT * FROM users";
                        $result = mysqli_query($connection, $query);
                        if ($result && mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="py-4 px-6 font-medium text-gray-900"><?php echo htmlspecialchars($row['username']); ?></td>
                                <td class="py-4 px-6 text-gray-600"><?php echo htmlspecialchars($row['firstname']); ?></td>
                                <td class="py-4 px-6 text-gray-600"><?php echo htmlspecialchars($row['lastname']); ?></td>
                                <td class="py-4 px-6 text-right space-x-3">
                                    <a href="user_edit.php?user-id=<?php echo $row['id']; ?>" class="text-blue-600 hover:text-blue-800 font-semibold text-sm transition-colors">Edit</a>
                                    <span class="text-gray-300">|</span>
                                    <button onclick="deleteRecord(<?php echo $row['id']; ?>)" class="text-red-500 hover:text-red-700 font-semibold text-sm transition-colors">Delete</button>
                                </td>
                            </tr>
                        <?php 
                            }
                        } else {
                        ?>
                            <tr>
                                <td colspan="4" class="py-8 text-center text-gray-500">No users found.</td>
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
            window.location.href = "user_delete.php?user-id=" + id;
        }
    }
</script>
</body>
</html>