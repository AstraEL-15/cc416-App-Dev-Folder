<?php
if (!isset($_COOKIE['lab12_user_id'])) {
    header('Location: login.php');
    exit;
}
include 'initialize.php';

$user_id = $_GET['user-id'] ?? '';
if (empty($user_id)) {
    header('Location: user_records.php?error=' . urlencode("No user selected to edit"));
    exit;
}

$query = "SELECT * FROM users WHERE id = '$user_id'";
$result = mysqli_query($connection, $query);
$row = mysqli_fetch_assoc($result);

if (!$row) {
    header('Location: user_records.php?error=' . urlencode("User not found!"));
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit User</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@3.9.0/dist/full.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-base-200 min-h-screen flex items-center justify-center p-4">
    <div class="card w-full max-w-md bg-base-100 shadow-xl">
        <div class="card-body">
            <h2 class="card-title justify-center text-2xl mb-4">Update User</h2>

            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-error shadow-lg rounded-xl mb-4 text-white text-sm">
                    <span><?php echo htmlspecialchars($_GET['error']); ?></span>
                </div>
            <?php endif; ?>

            <form method="POST" action="user_edit_data.php?user-id=<?php echo $user_id; ?>">
                <div class="grid grid-cols-2 gap-4">
                    <div class="form-control">
                        <label class="label"><span class="label-text">First Name</span></label>
                        <input type="text" name="firstname" value="<?php echo htmlspecialchars($row['firstname']); ?>" class="input input-bordered w-full" />
                    </div>
                    <div class="form-control">
                        <label class="label"><span class="label-text">Last Name</span></label>
                        <input type="text" name="lastname" value="<?php echo htmlspecialchars($row['lastname']); ?>" class="input input-bordered w-full" />
                    </div>
                </div>
                <div class="form-control mt-4">
                    <label class="label"><span class="label-text">Username</span></label>
                    <input type="text" name="username" value="<?php echo htmlspecialchars($row['username']); ?>" class="input input-bordered w-full" />
                </div>
                <div class="form-control mt-4">
                    <label class="label"><span class="label-text">Password</span></label>
                    <input type="text" name="password" value="<?php echo htmlspecialchars($row['password']); ?>" class="input input-bordered w-full" />
                </div>
                <div class="form-control mt-4">
                    <label class="label"><span class="label-text">Confirm Password</span></label>
                    <input type="text" name="confirm_password" value="<?php echo htmlspecialchars($row['password']); ?>" class="input input-bordered w-full" />
                </div>
                <div class="form-control mt-6 flex-row gap-2">
                    <a href="user_records.php" class="btn btn-ghost flex-1">Cancel</a>
                    <button type="submit" class="btn btn-warning flex-1">Update User</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>