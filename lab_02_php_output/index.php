<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab 02 Challenge - Bootstrap 5.3 Redesign</title>
    <!-- Task 7: Bootstrap 5.3 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light py-5">

    <div class="container">
        <h2 class="mb-4 text-center">Lab 02 Challenge: PHP Output & Bootstrap 5.3</h2>

        <?php
        // Task 1: Student Variables
        $name = "Ernest Lenard Villanueva";
        $course = "BS Information Systems";
        $yearLevel = "4th Year";
        $section = "Block 2";

        // Task 8: Output Comparison (PHP Comment)
        /*
         * Difference between echo and print:
         * 'echo' can output multiple parameters separated by commas and does not return a value, making it marginally faster.
         * 'print' can only accept a single argument and always returns 1, allowing it to be used inside expressions.
         */
        ?>

        <!-- Task 6: Sentence Output using Echo and an Alert component -->
        <div class="alert alert-primary shadow-sm mb-4" role="alert">
            <h4 class="alert-heading">Student Profile Summary</h4>
            <hr>
            <p class="mb-0">
                <?php 
                echo "Hello! My name is <strong>$name</strong>, and I am currently a <strong>$yearLevel</strong> student in the <strong>$course</strong> program, belonging to section <strong>$section</strong>."; 
                ?>
            </p>
        </div>

        <div class="row g-4 mb-4">
            <!-- Task 2: Echo Output Card -->
            <div class="col-md-6">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Echo Output</h5>
                        <span class="badge bg-success">Task 2</span>
                    </div>
                    <div class="card-body fs-5">
                        <?php
                        // Tasks 4 & 5: Labels and Line Break Formatting using echo
                        echo "<span class='text-muted fs-6'>Name:</span><br/><strong>" . $name . "</strong><br/><br/>";
                        echo "<span class='text-muted fs-6'>Course:</span><br/><strong>" . $course . "</strong><br/><br/>";
                        echo "<span class='text-muted fs-6'>Year Level:</span><br/><strong>" . $yearLevel . "</strong><br/><br/>";
                        echo "<span class='text-muted fs-6'>Section:</span><br/><strong>" . $section . "</strong><br/>";
                        ?>
                    </div>
                </div>
            </div>

            <!-- Task 3: Print Output Card -->
            <div class="col-md-6">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Print Output</h5>
                        <span class="badge bg-info">Task 3</span>
                    </div>
                    <div class="card-body fs-5">
                        <?php
                        // Tasks 4 & 5: Labels and Line Break Formatting using print
                        print "<span class='text-muted fs-6'>Name:</span><br/><strong>" . $name . "</strong><br/><br/>";
                        print "<span class='text-muted fs-6'>Course:</span><br/><strong>" . $course . "</strong><br/><br/>";
                        print "<span class='text-muted fs-6'>Year Level:</span><br/><strong>" . $yearLevel . "</strong><br/><br/>";
                        print "<span class='text-muted fs-6'>Section:</span><br/><strong>" . $section . "</strong><br/>";
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Task 7: Bootstrap Table Redesign -->
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Structured Data View</h5>
                <span class="badge bg-warning text-dark">Task 7</span>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover table-striped mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Label</th>
                            <th>Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="ps-4"><span class="badge bg-secondary">Name</span></td>
                            <td><?php echo $name; ?></td>
                        </tr>
                        <tr>
                            <td class="ps-4"><span class="badge bg-secondary">Course</span></td>
                            <td><?php echo $course; ?></td>
                        </tr>
                        <tr>
                            <td class="ps-4"><span class="badge bg-secondary">Year Level</span></td>
                            <td><?php echo $yearLevel; ?></td>
                        </tr>
                        <tr>
                            <td class="ps-4"><span class="badge bg-secondary">Section</span></td>
                            <td><?php echo $section; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>