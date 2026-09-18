<?php
// Capture data safely
$username = $_POST['username'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';

$errorMessage = "";

// --- PHP FORM VALIDATION LOGIC ---

// 1. Check for empty fields
if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
    $errorMessage = "All fields are required. Please fill out the entire form.";
} 
// 2. Check if passwords match
elseif ($password !== $confirm_password) {
    $errorMessage = "Your passwords do not match. Please try again.";
} 
// 3. STUDENT ACTIVITY: Check minimum password length (e.g., 8 characters)
elseif (strlen($password) < 8) {
    $errorMessage = "Security check failed: Your password must be at least 8 characters long.";
}
?>

<!DOCTYPE html>
<html lang="en" data-theme="winter">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab 05 - Validation Result</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.10.2/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-base-200/50 min-h-screen flex items-center justify-center p-6 font-sans">
    
    <div class="max-w-md w-full card bg-base-100 shadow-xl border border-base-200">
        <div class="card-body">
            
            <?php if (!empty($errorMessage)): ?>
                <!-- Validation Failed View -->
                <h2 class="text-2xl font-extrabold text-error mb-4 text-center">Registration Failed</h2>
                
                <div class="alert alert-error shadow-sm rounded-xl mb-6 text-white font-medium">
                    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <span><?php echo $errorMessage; ?></span>
                </div>

                <div class="text-center">
                    <!-- Javascript history back is perfect here so they don't lose the data they typed -->
                    <button onclick="history.back()" class="btn btn-outline btn-error w-full">&larr; Go Back and Fix</button>
                </div>

            <?php else: ?>
                <!-- Validation Passed View -->
                <h2 class="text-2xl font-extrabold text-success mb-4 text-center">Registration Successful!</h2>
                
                <div class="bg-success/10 border border-success/20 p-4 rounded-xl space-y-3 mb-6">
                    <p><strong>Username:</strong> <span class="text-success-content font-medium"><?php echo htmlspecialchars($username); ?></span></p>
                    <p><strong>Email:</strong> <span class="text-success-content font-medium"><?php echo htmlspecialchars($email); ?></span></p>
                    <p class="text-sm text-gray-500 italic mt-2">Passwords matched and passed length requirements.</p>
                </div>

                <div class="text-center">
                    <a href="index.php" class="btn btn-primary w-full">Register Another User</a>
                </div>
            <?php endif; ?>

        </div>
    </div>

</body>
</html>