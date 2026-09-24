<?php
// NO cookie check here! We want logged-out users to be able to access this page.
include 'initialize.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Lab 12</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@3.9.0/dist/full.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-base-200 min-h-screen flex items-center justify-center">

    <div class="card w-96 bg-base-100 shadow-xl">
        <div class="card-body">
            <h2 class="card-title justify-center text-2xl mb-4">Create Account</h2>

            <!-- Error Message Catcher -->
            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-error shadow-lg rounded-xl mb-4 text-white text-sm">
                    <span><?php echo htmlspecialchars($_GET['error']); ?></span>
                </div>
            <?php endif; ?>

            <form method="POST" action="register_data.php">
                <div class="form-control">
                    <label class="label"><span class="label-text">First Name</span></label>
                    <input type="text" name="firstname" class="input input-bordered w-full" required />
                </div>
                <div class="form-control mt-2">
                    <label class="label"><span class="label-text">Last Name</span></label>
                    <input type="text" name="lastname" class="input input-bordered w-full" required />
                </div>
                <div class="form-control mt-2">
                    <label class="label"><span class="label-text">Username</span></label>
                    <input type="text" name="username" class="input input-bordered w-full" required />
                </div>
                <div class="form-control mt-2">
                    <label class="label"><span class="label-text">Password</span></label>
                    <input type="password" name="password" class="input input-bordered w-full" required />
                </div>
                <div class="form-control mt-2">
                    <label class="label"><span class="label-text">Confirm Password</span></label>
                    <input type="password" name="confirm_password" class="input input-bordered w-full" required />
                </div>

                <div class="form-control mt-6">
                    <button type="submit" class="btn btn-primary w-full">Sign Up</button>
                </div>
            </form>

            <div class="divider">OR</div>
            <div class="text-center">
                <a href="login.php" class="link link-hover text-sm text-base-content/70">Back to Login</a>
            </div>
        </div>
    </div>

</body>
</html>