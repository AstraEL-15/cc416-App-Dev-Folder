<?php include 'initialize.php'; ?>
<!DOCTYPE html>
<html lang="en" data-theme="winter">
<head>
    <meta charset="UTF-8">
    <title>Create New User</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.10.2/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-base-200/50 min-h-screen flex items-center justify-center p-6 font-sans">
    <div class="max-w-md w-full card bg-base-100 shadow-xl border border-base-200">
        <div class="card-body">
            <h2 class="text-2xl font-extrabold text-primary mb-4 text-center">Create New User</h2>
            
            <?php
            if (isset($_SESSION['alert_message'])) {
                echo '<div class="alert alert-error shadow-sm rounded-xl mb-4 text-white font-medium"><span>' . $_SESSION['alert_message'] . '</span></div>';
                unset($_SESSION['alert_message']);
            }
            ?>

            <form method="POST" action="user_add_data.php" class="space-y-4">
                <div class="form-control">
                    <label class="label"><span class="label-text font-semibold">Firstname</span></label>
                    <input type="text" name="firstname" class="input input-bordered w-full" />
                </div>
                <div class="form-control">
                    <label class="label"><span class="label-text font-semibold">Lastname</span></label>
                    <input type="text" name="lastname" class="input input-bordered w-full" />
                </div>
                <div class="form-control">
                    <label class="label"><span class="label-text font-semibold">Username</span></label>
                    <input type="text" name="username" class="input input-bordered w-full" />
                </div>
                <div class="form-control">
                    <label class="label"><span class="label-text font-semibold">Password</span></label>
                    <input type="password" name="password" class="input input-bordered w-full" />
                </div>
                <div class="form-control">
                    <label class="label"><span class="label-text font-semibold">Confirm Password</span></label>
                    <input type="password" name="confirm_password" class="input input-bordered w-full" />
                </div>
                <div class="form-control mt-6">
                    <button type="submit" class="btn btn-primary w-full">Add User</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>