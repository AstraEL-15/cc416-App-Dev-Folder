<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab 12 - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@3.9.0/dist/full.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-base-200 min-h-screen flex items-center justify-center">

    <div class="card w-96 bg-base-100 shadow-xl">
        <div class="card-body">
            <h2 class="card-title justify-center text-2xl mb-4">Welcome Back!</h2>

            <!-- Auto-Dismissing Toast Notification -->
            <?php if (isset($_GET['msg']) || isset($_GET['error'])): ?>
                <div id="login-toast" class="toast toast-bottom toast-end z-50 transition-opacity duration-500 ease-in-out">
                    <?php if (isset($_GET['msg'])): ?>
                        <div class="alert alert-success text-white shadow-xl rounded-xl border border-white/20">
                            <span><?php echo htmlspecialchars($_GET['msg']); ?></span>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($_GET['error'])): ?>
                        <div class="alert alert-error text-white shadow-xl rounded-xl border border-white/20">
                            <span><?php echo htmlspecialchars($_GET['error']); ?></span>
                        </div>
                    <?php endif; ?>
                </div>

                <script>
                    setTimeout(() => {
                        const toast = document.getElementById('login-toast');
                        if (toast) {
                            toast.style.opacity = '0';
                            setTimeout(() => toast.remove(), 500);
                        }
                    }, 3000);
                </script>
            <?php endif; ?>

            <form method="POST" action="auth.php">
                <div class="form-control">
                    <label class="label"><span class="label-text">Username</span></label>
                    <input type="text" name="username" class="input input-bordered w-full" placeholder="Enter username" />
                </div>

                <div class="form-control mt-4">
                    <label class="label"><span class="label-text">Password</span></label>
                    <input type="password" name="password" class="input input-bordered w-full" placeholder="Enter password" />
                </div>

                <div class="form-control mt-6">
                    <button type="submit" name="login" class="btn btn-primary w-full">Login</button>
                </div>
            </form>

            <div class="divider">OR</div>
            <div class="text-center">
                <a href="user_add.php" class="link link-hover text-sm text-primary">Create New User</a>
            </div>
        </div>
    </div>

</body>

</html>