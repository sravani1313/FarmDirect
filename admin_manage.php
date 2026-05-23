<?php
session_start();
require 'db.php';

// Route protection
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header("Location: login.php");
    exit();
}

$message = '';
$msgType = '';

// Handle Adding a New Admin
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_admin'])) {
    $fullName = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $bio = trim($_POST['bio']);
    
    // Pick a random vibrant hex color for their UI avatar container
    $colors = ['#10b981', '#3b82f6', '#f59e0b', '#ef4444', '#8b5cf6', '#ec4899'];
    $randomColor = $colors[array_rand($colors)];

    if (!empty($fullName) && !empty($email) && !empty($password)) {
        // Check if user already exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $message = "A user with that email already exists!";
            $msgType = "error";
        } else {
            // Hash password securely
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $isAdmin = 1;

            $insertStmt = $conn->prepare("INSERT INTO users (full_name, email, password, profile_bio, avatar_color, is_admin) VALUES (?, ?, ?, ?, ?, ?)");
            $insertStmt->bind_param("sssssi", $fullName, $email, $hashedPassword, $bio, $randomColor, $isAdmin);
            
            if ($insertStmt->execute()) {
                $message = "New administrator registered successfully!";
                $msgType = "success";
            } else {
                $message = "Database error. Failed to add admin.";
                $msgType = "error";
            }
        }
    } else {
        $message = "Please fill out all required fields.";
        $msgType = "error";
    }
}

// Fetch all active system administrators
$adminsResult = $conn->query("SELECT id, full_name, email, avatar_color, created_at FROM users WHERE is_admin = 1 ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Administrators | FarmDirect+</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-slate-50 flex font-sans">

    <div class="w-64 bg-slate-900 h-screen text-white p-6 fixed shadow-xl z-20">
        <h2 class="text-2xl font-bold mb-10 text-emerald-400 flex items-center gap-2 tracking-wide">
            <i class="fas fa-leaf"></i> FarmDirect+
        </h2>
        <nav class="space-y-3">
            <a href="admin_dashboard.php" class="block p-3 text-slate-300 hover:text-white hover:bg-slate-800 rounded-lg transition-all"><i class="fas fa-chart-line mr-2"></i> Overview</a>
            <a href="admin_manage.php" class="block p-3 bg-emerald-600 shadow-md shadow-emerald-900/50 rounded-lg transition-all"><i class="fas fa-user-shield mr-2"></i> Team Directory</a>
            <a href="admin_profile.php" class="block p-3 text-slate-300 hover:text-white hover:bg-slate-800 rounded-lg transition-all"><i class="fas fa-user-cog mr-2"></i> My Profile</a>
            <a href="customers_list.php" class="block p-3 text-slate-300 hover:text-white hover:bg-slate-800 rounded-lg transition-all"><i class="fas fa-users mr-2"></i> Customers</a>
            
            <div class="pt-8 mt-8 border-t border-slate-700">
                <a href="logout.php" class="block p-3 text-red-400 hover:text-red-300 hover:bg-red-900/20 rounded-lg transition-all"><i class="fas fa-sign-out-alt mr-2"></i> Logout</a>
            </div>
        </nav>
    </div>

    <div class="ml-64 p-8 w-full max-w-7xl mx-auto">
        <header class="mb-10">
            <h1 class="text-3xl font-bold text-slate-800">Administrative Operations</h1>
            <p class="text-slate-500 mt-1">Provision global system authorizations and onboard secondary root credentials.</p>
        </header>

        <?php if (!empty($message)): ?>
            <div class="p-4 mb-6 rounded-xl flex items-center gap-3 font-semibold text-sm border <?php echo $msgType === 'success' ? 'bg-emerald-50 text-emerald-800 border-emerald-200' : 'bg-red-50 text-red-800 border-red-200'; ?>">
                <i class="fas <?php echo $msgType === 'success' ? 'fa-check-circle' : 'fa-exclamation-triangle'; ?> text-lg"></i>
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 h-fit">
                <h2 class="text-xl font-bold text-slate-800 mb-6 flex items-center gap-2">
                    <i class="fas fa-plus-circle text-emerald-500"></i> Provision Admin
                </h2>
                <form action="admin_manage.php" method="POST" class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Legal Name</label>
                        <input type="text" name="full_name" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Corporate Email</label>
                        <input type="email" name="email" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Root Password</label>
                        <input type="password" name="password" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Internal Admin Bio <span class="text-slate-400 font-normal">(Optional)</span></label>
                        <textarea name="bio" rows="3" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-4 text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none resize-none"></textarea>
                    </div>
                    <button type="submit" name="add_admin" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-3 px-4 rounded-xl shadow-md shadow-emerald-700/20 hover:shadow-lg transition-all mt-2">
                        Create Root Account
                    </button>
                </form>
            </div>

            <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <h2 class="text-xl font-bold text-slate-800 mb-6"><i class="fas fa-shield-alt text-blue-500 mr-2"></i>Active Operations Directory</h2>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead>
                            <tr class="text-slate-400 border-b border-slate-100">
                                <th class="pb-3 font-medium">Administrator Profile</th>
                                <th class="pb-3 font-medium">Credentials Path</th>
                                <th class="pb-3 text-right font-medium">Authorization Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            <?php while($row = $adminsResult->fetch_assoc()): ?>
                                <tr class="hover:bg-slate-50 transition-colors group">
                                    <td class="py-4 flex items-center">
                                        <div class="w-9 h-9 text-white rounded-full flex items-center justify-center font-bold text-xs mr-3 shadow-sm uppercase" style="background-color: <?php echo $row['avatar_color']; ?>;">
                                            <?php echo substr($row['full_name'], 0, 2); ?>
                                        </div>
                                        <span class="font-semibold text-slate-700"><?php echo htmlspecialchars($row['full_name']); ?></span>
                                    </td>
                                    <td class="py-4 text-slate-500 font-mono text-xs"><?php echo htmlspecialchars($row['email']); ?></td>
                                    <td class="py-4 text-right text-slate-400 text-xs"><?php echo date('M d, Y', strtotime($row['created_at'])); ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>