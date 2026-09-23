<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add User</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@3.9.0/dist/full.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-base-200 min-h-screen flex items-center justify-center p-4">
    <div class="card w-full max-w-md bg-base-100 shadow-xl">
        <div class="card-body">
            <h2 class="card-title justify-center text-2xl mb-4">Create New User</h2>
            
            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-error shadow-lg rounded-xl mb-4 text-white text-sm">
                    <span><?php echo htmlspecialchars($_GET['error']); ?></span>
                </div>
            <?php endif; ?>

            <form method="POST" action="user_add_data.php">
                <div class="grid grid-cols-2 gap-4">
                    <div class="form-control">
                        <label class="label"><span class="label-text">First Name</span></label>
                        <input type="text" name="firstname" class="input input-bordered w-full" />
                    </div>
                    <div class="form-control">
                        <label class="label"><span class="label-text">Last Name</span></label>
                        <input type="text" name="lastname" class="input input-bordered w-full" />
                    </div>
                </div>
                <div class="form-control mt-4">
                    <label class="label"><span class="label-text">Username</span></label>
                    <input type="text" name="username" class="input input-bordered w-full" />
                </div>
                <div class="form-control mt-4">
                    <label class="label"><span class="label-text">Password</span></label>
                    <input type="password" name="password" class="input input-bordered w-full" />
                </div>
                <div class="form-control mt-4">
                    <label class="label"><span class="label-text">Confirm Password</span></label>
                    <input type="password" name="confirm_password" class="input input-bordered w-full" />
                </div>
                <div class="form-control mt-6 flex-row gap-2">
                    <a href="login.php" class="btn btn-ghost flex-1">Back</a>
                    <button type="submit" class="btn btn-primary flex-1">Add User</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>