<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once 'initialize.php';

$id = 0;
$username = '';
$firstname = '';
$lastname = '';

// 1. Fetch the user's current data when the page loads
if (isset($_GET['user-id'])) {
    $id = intval($_GET['user-id']);
    $result = mysqli_query($connection, "SELECT * FROM users WHERE id = $id");
    
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $username = $row['username'];
        $firstname = $row['firstname'];
        $lastname = $row['lastname'];
    } else {
        die("User not found in the database!");
    }
}

// 2. Handle the form submission when the user clicks "Update User"
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = intval($_POST['id']);
    $username = mysqli_real_escape_string($connection, $_POST['username']);
    $firstname = mysqli_real_escape_string($connection, $_POST['firstname']);
    $lastname = mysqli_real_escape_string($connection, $_POST['lastname']);
    
    $update_sql = "UPDATE users SET username='$username', firstname='$firstname', lastname='$lastname' WHERE id=$id";
    
    if (mysqli_query($connection, $update_sql)) {
        $_SESSION['alert_message'] = "User updated successfully!";
        echo "<script>
                window.location.href = '../lab_08_read_user_records/user_records.php';
              </script>";
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($connection);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-10 font-sans text-gray-800">
    <div class="max-w-xl mx-auto bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden p-6">
        <h2 class="text-2xl font-bold text-gray-900 tracking-tight mb-6">Edit User</h2>
        
        <form action="user_edit.php" method="POST" class="space-y-4">
            <!-- Hidden input to keep track of the ID we are updating -->
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
            
            <div>
                <label class="block text-gray-700 font-medium mb-2">Username</label>
                <input type="text" name="username" value="<?php echo htmlspecialchars($username); ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" required>
            </div>
            
            <div>
                <label class="block text-gray-700 font-medium mb-2">First Name</label>
                <input type="text" name="firstname" value="<?php echo htmlspecialchars($firstname); ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" required>
            </div>
            
            <div>
                <label class="block text-gray-700 font-medium mb-2">Last Name</label>
                <input type="text" name="lastname" value="<?php echo htmlspecialchars($lastname); ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" required>
            </div>
            
            <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-100">
                <a href="../lab_08_read_user_records/user_records.php" class="px-5 py-2.5 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors font-semibold">Cancel</a>
                <button type="submit" class="px-5 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-semibold shadow-md">Update User</button>
            </div>
        </form>
    </div>
</body>
</html>