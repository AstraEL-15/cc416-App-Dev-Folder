<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'initialize.php';

// Fetch all users from Aiven DB
$result = mysqli_query($conn, "SELECT * FROM users ORDER BY id DESC");
$users = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $users[] = $row;
    }
}

// Check if directed back to add_user tab on error
$defaultTab = isset($_GET['tab']) ? $_GET['tab'] : 'users';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Professional User Dashboard</title>
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Custom Tailwind Configuration for your specific color palette -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        panelDarkest: '#27374D',
                        panelDark: '#526D82',
                        panelLight: '#9DB2BF',
                        panelLightest: '#DDE6ED'
                    }
                }
            }
        }
    </script>
    <style>
        /* Custom scrollbar for a polished look */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #27374D; }
        ::-webkit-scrollbar-thumb { background: #526D82; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #9DB2BF; }
    </style>
</head>
<body class="bg-panelDarkest text-panelLightest min-h-screen font-sans selection:bg-panelLight selection:text-panelDarkest" x-data="{ currentTab: '<?php echo $defaultTab; ?>' }">

    <div class="flex min-h-screen">
        
        <!-- SIDEBAR -->
        <aside class="w-64 bg-panelDark flex flex-col justify-between shadow-xl z-10">
            <div class="space-y-6 p-4">
                <!-- App Brand / Logo -->
                <div class="flex items-center gap-3 px-2 py-3 border-b border-panelLight/30">
                    <div class="w-10 h-10 rounded-lg bg-panelLightest text-panelDarkest flex items-center justify-center font-black text-xl shadow-md">
                        U
                    </div>
                    <div>
                        <h1 class="font-extrabold text-lg text-panelLightest leading-tight tracking-wide">AdminPortal</h1>
                        <p class="text-xs text-panelLight font-medium">Management Hub</p>
                    </div>
                </div>

                <!-- Navigation Links -->
                <nav class="space-y-2 mt-6">
                    <button 
                        @click="currentTab = 'users'" 
                        :class="currentTab === 'users' ? 'bg-panelDarkest text-panelLightest shadow-inner' : 'text-panelLightest/70 hover:bg-panelDarkest/50 hover:text-panelLightest'" 
                        class="w-full flex items-center gap-3 px-4 py-3 rounded-lg font-semibold text-sm transition-all duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                        User Directory
                    </button>

                    <button 
                        @click="currentTab = 'add_user'" 
                        :class="currentTab === 'add_user' ? 'bg-panelDarkest text-panelLightest shadow-inner' : 'text-panelLightest/70 hover:bg-panelDarkest/50 hover:text-panelLightest'" 
                        class="w-full flex items-center gap-3 px-4 py-3 rounded-lg font-semibold text-sm transition-all duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" /></svg>
                        Add New User
                    </button>
                </nav>
            </div>

            <!-- Footer Badge -->
            <div class="p-4 border-t border-panelLight/20">
                <div class="bg-panelDarkest/50 rounded-lg p-3 text-xs text-panelLight flex items-center justify-between shadow-inner">
                    <span>DB Status</span>
                    <span class="flex items-center gap-1 font-semibold text-green-400">
                        <span class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></span>
                        Active
                    </span>
                </div>
            </div>
        </aside>

        <!-- MAIN CONTENT AREA -->
        <main class="flex-1 p-10 overflow-y-auto space-y-8 bg-panelDarkest">

            <!-- Global Alert Banner -->
            <?php if (isset($_SESSION['alert_message'])): ?>
                <div class="bg-panelLight/20 border-l-4 border-panelLight text-panelLightest p-4 rounded-r-lg shadow-md flex justify-between items-center">
                    <span class="font-medium"><?php echo $_SESSION['alert_message']; ?></span>
                    <button onclick="this.parentElement.remove()" class="text-panelLight hover:text-panelLightest transition-colors font-bold">✕</button>
                </div>
                <?php unset($_SESSION['alert_message']); ?>
            <?php endif; ?>

            <!-- VIEW 1: USER DIRECTORY TABLE -->
            <div x-show="currentTab === 'users'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0" class="space-y-6">
                <!-- Header -->
                <div>
                    <h2 class="text-3xl font-black text-panelLightest tracking-tight">User Directory</h2>
                    <p class="text-sm text-panelLight mt-1">View and manage registered system accounts</p>
                </div>

                <!-- Stats Summary Row -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-panelDark p-6 rounded-xl shadow-lg border border-panelLight/10">
                        <div class="text-xs font-bold uppercase tracking-wider text-panelLight">Total Registered</div>
                        <div class="text-4xl font-black text-panelLightest mt-2"><?php echo count($users); ?></div>
                        <div class="text-xs text-panelLight/70 mt-2">Synced with Aiven MySQL</div>
                    </div>
                </div>

                <!-- Table Container -->
                <div class="bg-panelDark rounded-xl shadow-lg border border-panelLight/10 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-panelDarkest/40 text-panelLight text-sm uppercase tracking-wider border-b border-panelLight/20">
                                    <th class="py-4 px-6 font-semibold">ID</th>
                                    <th class="py-4 px-6 font-semibold">Full Name</th>
                                    <th class="py-4 px-6 font-semibold">Username</th>
                                    <th class="py-4 px-6 font-semibold">Email</th>
                                    <th class="py-4 px-6 font-semibold text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-panelLight/10">
                                <?php if (!empty($users)): ?>
                                    <?php foreach ($users as $user): ?>
                                        <tr class="hover:bg-panelLight/10 transition-colors">
                                            <td class="py-4 px-6 font-mono text-xs text-panelLight">#<?php echo htmlspecialchars($user['id']); ?></td>
                                            <td class="py-4 px-6 font-bold text-panelLightest">
                                                <?php echo htmlspecialchars($user['firstname'] . ' ' . $user['lastname']); ?>
                                            </td>
                                            <td class="py-4 px-6">
                                                <span class="bg-panelDarkest/50 text-panelLight px-2 py-1 rounded font-mono text-xs border border-panelLight/20">
                                                    @<?php echo htmlspecialchars($user['username'] ?? 'N/A'); ?>
                                                </span>
                                            </td>
                                            <td class="py-4 px-6 text-panelLight">
                                                <?php echo htmlspecialchars($user['email'] ?? 'N/A'); ?>
                                            </td>
                                            <td class="py-4 px-6 text-right">
                                                <a href="view.php?id=<?php echo $user['id']; ?>" class="text-panelLightest bg-panelLight/20 hover:bg-panelLight/40 px-3 py-1.5 rounded text-sm font-semibold transition-colors">View</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" class="py-8 px-6 text-center text-panelLight">No users found in database.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- VIEW 2: ADD USER FORM -->
            <div x-show="currentTab === 'add_user'" style="display: none;" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0" class="max-w-2xl mx-auto space-y-6">
                <div>
                    <h2 class="text-3xl font-black text-panelLightest tracking-tight">Add New User</h2>
                    <p class="text-sm text-panelLight mt-1">Create a new account record in the secure database</p>
                </div>

                <div class="bg-panelDark rounded-xl shadow-lg border border-panelLight/10">
                    <div class="p-8">
                        <form method="POST" action="user_add_data.php" class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label class="text-sm font-bold text-panelLight tracking-wide">First Name</label>
                                    <input type="text" name="firstname" class="w-full bg-panelDarkest border border-panelLight/30 rounded-lg px-4 py-2.5 text-panelLightest placeholder-panelLight/40 focus:outline-none focus:border-panelLightest focus:ring-1 focus:ring-panelLightest transition-all" placeholder="John" required />
                                </div>
                                <div class="space-y-2">
                                    <label class="text-sm font-bold text-panelLight tracking-wide">Last Name</label>
                                    <input type="text" name="lastname" class="w-full bg-panelDarkest border border-panelLight/30 rounded-lg px-4 py-2.5 text-panelLightest placeholder-panelLight/40 focus:outline-none focus:border-panelLightest focus:ring-1 focus:ring-panelLightest transition-all" placeholder="Doe" required />
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label class="text-sm font-bold text-panelLight tracking-wide">Username</label>
                                <input type="text" name="username" class="w-full bg-panelDarkest border border-panelLight/30 rounded-lg px-4 py-2.5 text-panelLightest placeholder-panelLight/40 focus:outline-none focus:border-panelLightest focus:ring-1 focus:ring-panelLightest transition-all" placeholder="johndoe88" required />
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label class="text-sm font-bold text-panelLight tracking-wide">Password</label>
                                    <input type="password" name="password" class="w-full bg-panelDarkest border border-panelLight/30 rounded-lg px-4 py-2.5 text-panelLightest placeholder-panelLight/40 focus:outline-none focus:border-panelLightest focus:ring-1 focus:ring-panelLightest transition-all" placeholder="••••••••" required />
                                </div>
                                <div class="space-y-2">
                                    <label class="text-sm font-bold text-panelLight tracking-wide">Confirm Password</label>
                                    <input type="password" name="confirm_password" class="w-full bg-panelDarkest border border-panelLight/30 rounded-lg px-4 py-2.5 text-panelLightest placeholder-panelLight/40 focus:outline-none focus:border-panelLightest focus:ring-1 focus:ring-panelLightest transition-all" placeholder="••••••••" required />
                                </div>
                            </div>

                            <div class="pt-6 flex items-center justify-end gap-4 border-t border-panelLight/20">
                                <button type="button" @click="currentTab = 'users'" class="px-6 py-2.5 rounded-lg text-panelLightest font-semibold hover:bg-panelLight/10 transition-colors">Cancel</button>
                                <button type="submit" class="bg-panelLightest text-panelDarkest px-8 py-2.5 rounded-lg font-bold shadow hover:bg-white transition-all transform hover:-translate-y-0.5">Save User</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </main>
    </div>

</body>
</html>