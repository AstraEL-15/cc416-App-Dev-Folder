<!DOCTYPE html>
<html lang="en" data-theme="winter">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab 04 - Registration Result</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.10.2/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-base-200/50 min-h-screen flex items-center justify-center p-6 font-sans">
    
    <div class="max-w-md w-full card bg-base-100 shadow-xl border border-base-200">
        <div class="card-body">
            <h2 class="text-2xl font-extrabold text-success mb-4 text-center">Registration Successful</h2>
            
            <!-- Receiving and displaying POST data securely -->
            <div class="bg-base-200 p-4 rounded-xl space-y-3 mb-6">
                <p><strong>Username:</strong> <span class="text-primary font-medium"><?php echo htmlspecialchars($_POST['username'] ?? 'N/A'); ?></span></p>
                <!-- Displaying the student activity email field -->
                <p><strong>Email:</strong> <span class="text-primary font-medium"><?php echo htmlspecialchars($_POST['email'] ?? 'N/A'); ?></span></p>
                <p><strong>Password:</strong> <span class="text-gray-400 italic">******** (Received via POST)</span></p>
            </div>

            <div class="text-center">
                <a href="index.php" class="btn btn-outline btn-primary w-full">&larr; Back to Form</a>
            </div>
        </div>
    </div>

</body>
</html>