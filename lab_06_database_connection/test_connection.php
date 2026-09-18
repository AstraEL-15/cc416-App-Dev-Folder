<?php 
// Include the database connection file. 
// If db.php fails, the script will die before rendering the HTML below.
include 'db.php'; 
?>

<!DOCTYPE html>
<html lang="en" data-theme="winter">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab 06 - Database Connection</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.10.2/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-base-200/50 min-h-screen flex items-center justify-center p-6 font-sans">
    
    <div class="max-w-md w-full card bg-base-100 shadow-xl border border-base-200">
        <div class="card-body text-center">
            <h2 class="text-2xl font-extrabold text-primary mb-4">Database Status</h2>
            
            <!-- Expected Output Message -->
            <div class="alert alert-success shadow-sm rounded-xl text-white font-medium flex justify-center mt-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                <span>Connected successfully.</span>
            </div>
            
            <div class="divider"></div>
            
            <p class="text-sm text-gray-500 mt-2">
                <strong>Student Activity:</strong> Open <code>db.php</code> and intentionally misspell the database name to trigger and observe the connection error.
            </p>
        </div>
    </div>

</body>
</html>