<?php
$a = isset($_POST['a']) ? floatval($_POST['a']) : 75;
$b = isset($_POST['b']) ? floatval($_POST['b']) : 14;

$safeB = ($b == 0) ? 1 : $b;
$largerMessage = ($a > $b) ? "$a is larger than $b" : (($a < $b) ? "$b is larger than $a" : "Both numbers are equal");
$evenOdd = (intval($a) % 2 == 0) ? "Even" : "Odd";
?>
<!DOCTYPE html>
<html lang="en" data-theme="winter">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interactive PHP Calculator</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.10.2/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.0/dist/cdn.min.js"></script>
</head>
<body class="bg-base-200/50 min-h-screen p-6 md:p-10 font-sans text-base-content">

    <!-- Refined Header -->
    <div class="max-w-4xl mx-auto text-center space-y-3 mb-10">
        <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight text-primary">PHP Smart Calculator</h1>
        <p class="text-lg text-base-content/60 font-medium">Enter two numbers below to instantly calculate operations and comparisons.</p>
    </div>

    <!-- Elegant Input Form -->
    <div class="max-w-4xl mx-auto card bg-base-100 shadow-xl shadow-base-300/50 border border-base-200 mb-8">
        <div class="card-body p-8">
            <form method="POST" class="flex flex-col md:flex-row gap-6 items-end justify-center">
                <div class="form-control w-full md:w-2/5">
                    <label class="label pb-1"><span class="label-text font-bold text-gray-600 text-sm uppercase tracking-wider">First Number</span></label>
                    <input type="number" step="any" name="a" value="<?php echo htmlspecialchars($a); ?>" class="input input-bordered input-primary w-full bg-base-50 focus:ring-2 focus:ring-primary/20 transition-all" required />
                </div>
                <div class="form-control w-full md:w-2/5">
                    <label class="label pb-1"><span class="label-text font-bold text-gray-600 text-sm uppercase tracking-wider">Second Number</span></label>
                    <input type="number" step="any" name="b" value="<?php echo htmlspecialchars($b); ?>" class="input input-bordered input-primary w-full bg-base-50 focus:ring-2 focus:ring-primary/20 transition-all" required />
                </div>
                <div class="form-control w-full md:w-auto">
                    <button type="submit" class="btn btn-primary px-10 shadow-lg shadow-primary/30">Calculate</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Alpine.js Interactive Section -->
    <div x-data="{ view: 'arithmetic' }" class="max-w-4xl mx-auto space-y-8">
        
        <!-- Refined Alerts -->
        <div class="grid md:grid-cols-2 gap-6">
            <div class="alert bg-info/10 border-info/20 text-info-content shadow-sm rounded-2xl">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-info shrink-0 w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span><strong>Comparison:</strong> <?php echo $largerMessage; ?></span>
            </div>
            <div class="alert bg-success/10 border-success/20 text-success-content shadow-sm rounded-2xl">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-success shrink-0 w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span><strong>Modulus:</strong> The first number is <?php echo $evenOdd; ?>.</span>
            </div>
        </div>

        <!-- Sleek Toggle Button -->
        <div class="flex justify-center my-4">
            <button 
                @click="view = (view === 'arithmetic' ? 'comparison' : 'arithmetic')" 
                class="btn btn-outline btn-secondary rounded-full px-8 shadow-sm hover:shadow-md transition-all">
                <span x-text="view === 'arithmetic' ? 'View Comparison Table' : 'View Arithmetic Results'"></span>
            </button>
        </div>

        <!-- Arithmetic Stats -->
        <div x-show="view === 'arithmetic'" x-transition class="card bg-base-100 shadow-xl shadow-base-300/50 border border-base-200">
            <div class="card-body p-0">
                <div class="stats stats-vertical md:stats-horizontal w-full bg-transparent">
                    <div class="stat text-center">
                        <div class="stat-title font-semibold">Addition (+)</div>
                        <div class="stat-value text-primary text-4xl"><?php echo $a + $b; ?></div>
                    </div>
                    <div class="stat text-center border-t md:border-t-0 md:border-l border-base-200">
                        <div class="stat-title font-semibold">Subtraction (-)</div>
                        <div class="stat-value text-secondary text-4xl"><?php echo $a - $b; ?></div>
                    </div>
                    <div class="stat text-center border-t md:border-t-0 md:border-l border-base-200">
                        <div class="stat-title font-semibold">Multiplication (*)</div>
                        <div class="stat-value text-accent text-4xl"><?php echo $a * $b; ?></div>
                    </div>
                    <div class="stat text-center border-t md:border-t-0 md:border-l border-base-200">
                        <div class="stat-title font-semibold">Division (/)</div>
                        <div class="stat-value text-info text-4xl"><?php echo ($b != 0) ? round($a / $safeB, 2) : 'Err'; ?></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Comparison Table -->
        <div x-show="view === 'comparison'" x-transition style="display: none;" class="card bg-base-100 shadow-xl shadow-base-300/50 border border-base-200">
            <div class="card-body p-2">
                <div class="overflow-x-auto">
                    <table class="table table-lg w-full text-base">
                        <thead class="bg-base-200/50 text-gray-500 rounded-t-xl">
                            <tr>
                                <th>Comparison Type</th>
                                <th>Expression</th>
                                <th class="text-right">Result</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="hover:bg-base-200/30 transition-colors">
                                <td class="font-medium">Equal To</td>
                                <td class="font-mono text-gray-500"><?php echo "$a == $b"; ?></td>
                                <td class="text-right"><span class="badge <?php echo ($a == $b) ? 'badge-success text-white' : 'badge-ghost'; ?> badge-lg"><?php echo var_export($a == $b, true); ?></span></td>
                            </tr>
                            <tr class="hover:bg-base-200/30 transition-colors">
                                <td class="font-medium">Not Equal To</td>
                                <td class="font-mono text-gray-500"><?php echo "$a != $b"; ?></td>
                                <td class="text-right"><span class="badge <?php echo ($a != $b) ? 'badge-success text-white' : 'badge-ghost'; ?> badge-lg"><?php echo var_export($a != $b, true); ?></span></td>
                            </tr>
                            <tr class="hover:bg-base-200/30 transition-colors">
                                <td class="font-medium">Greater Than</td>
                                <td class="font-mono text-gray-500"><?php echo "$a > $b"; ?></td>
                                <td class="text-right"><span class="badge <?php echo ($a > $b) ? 'badge-success text-white' : 'badge-ghost'; ?> badge-lg"><?php echo var_export($a > $b, true); ?></span></td>
                            </tr>
                            <tr class="hover:bg-base-200/30 transition-colors">
                                <td class="font-medium">Less Than</td>
                                <td class="font-mono text-gray-500"><?php echo "$a < $b"; ?></td>
                                <td class="text-right"><span class="badge <?php echo ($a < $b) ? 'badge-success text-white' : 'badge-ghost'; ?> badge-lg"><?php echo var_export($a < $b, true); ?></span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>