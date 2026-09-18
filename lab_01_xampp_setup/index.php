<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab 01 Challenge - Tailwind Redesign</title>
    <!-- Task 7: Tailwind CSS CDN for styling -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<!-- Task 7: Background color, spacing, and centered layout -->
<body class="bg-slate-100 text-slate-800 flex items-center justify-center min-h-screen p-6 font-sans">

<!--
    echo "PHP is running using XAMPP."; -->
<!-- Task 7: Styled page container -->
    <div class="max-w-xl w-full bg-white p-8 rounded-xl shadow-lg border-t-4 border-blue-500">
        
        <!-- Task 7: Styled heading -->
        <h1 class="text-2xl font-black text-slate-900 mb-6 border-b pb-3">
            Lab 01 Challenge: XAMPP & Tailwind Output
        </h1>

        <div class="text-lg leading-relaxed bg-slate-50 p-5 rounded-lg border border-slate-200">
            <?php
            // Task 1 & 3: Variables for details
            $fullName = "Ernest Lenard Villanueva";
            $section = "Block 2???";
            $courseCode = "BS Information System";
            $subjectTitle = "App Development";

            // Task 5 & 6: Multiple separate echo statements with <br/> tags
            
            // Task 1: Custom Welcome Message
            echo "Welcome! My name is <span class='font-bold text-blue-600'>" . $fullName . "</span> and my section is <span class='font-bold text-blue-600'>" . $section . "</span>.<br/>";
            
            // Task 2: Localhost Proof
            echo "<span class='italic text-slate-500'>This page is running from localhost.</span><br/>";
            
            // Task 3: Course Identification
            echo "Course: <span class='font-semibold text-slate-900'>" . $courseCode . " - " . $subjectTitle . "</span>.<br/>";
            
            // Task 4: Date Display using date() function
            echo "Current Date: <span class='bg-blue-100 text-blue-800 px-2 py-0.5 rounded text-sm font-bold'>" . date('F j, Y') . "</span><br/>";
            ?>
        </div>
        
    </div>

</body>
</html>