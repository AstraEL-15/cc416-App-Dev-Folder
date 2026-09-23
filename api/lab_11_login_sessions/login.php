<?php include 'initialize.php'; ?>
<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.10.2/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-base-100 h-screen flex items-center justify-center font-sans">

    <div class="card w-96 bg-base-200 shadow-xl border border-base-300">
        <div class="card-body">
            <h3 class="text-2xl font-bold text-center text-primary mb-4">Welcome! Please Login.</h3>
            
            <!-- Session Alert Messages -->
            <?php if (isset($_GET['error'])): ?>
             <div class="alert alert-error shadow-lg rounded-xl mb-6 text-white font-medium flex items-center">
               <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
               <span><?php echo htmlspecialchars($_GET['error']); ?></span>
                </div>
            <?php endif; ?>

            <!-- Login Form -->
            <form method="POST" action="auth.php" class="space-y-4">
                <div class="form-control">
                    <label class="label"><span class="label-text font-semibold">Username</span></label>
                    <input type="text" name="username" class="input input-bordered bg-base-100 w-full" />
                </div>
                
                <div class="form-control">
                    <label class="label"><span class="label-text font-semibold">Password</span></label>
                    <input type="password" name="password" class="input input-bordered bg-base-100 w-full" />
                </div>
                
                <div class="form-control mt-6">
                    <button type="submit" name="login" class="btn btn-primary w-full">Login</button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>