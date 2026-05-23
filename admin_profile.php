<?php
session_start();
require 'db.php';

// 1. Safety Guard Check
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header("Location: login.php");
    exit();
}

// 2. Identify who is logged in (using session email or user_id)
// We use fallback to ensure we target the current logged-in user accurately
$currentAdminEmail = $_SESSION['email'] ?? ''; 
$currentAdminId = $_SESSION['user_id'] ?? null;

$message = '';
$msgType = '';

// 3. Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_profile'])) {
    $fullName = trim($_POST['full_name']);
    $bio = trim($_POST['bio']);
    $avatarColor = $_POST['avatar_color'];
    $newPassword = $_POST['new_password'];

    if (!empty($fullName)) {
        
        // Scenario A: Admin is changing their password too
        if (!empty($newPassword)) {
            $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
            
            if ($currentAdminId) {
                $stmt = $conn->prepare("UPDATE users SET full_name = ?, profile_bio = ?, avatar_color = ?, password = ? WHERE id = ?");
                $stmt->bind_param("ssssi", $fullName, $bio, $avatarColor, $hashedPassword, $currentAdminId);
            } else {
                $stmt = $conn->prepare("UPDATE users SET full_name = ?, profile_bio = ?, avatar_color = ?, password = ? WHERE email = ?");
                $stmt->bind_param("sssss", $fullName, $bio, $avatarColor, $hashedPassword, $currentAdminEmail);
            }
        } 
        // Scenario B: Admin is only changing text/color profile fields
        else {
            if ($currentAdminId) {
                $stmt = $conn->prepare("UPDATE users SET full_name = ?, profile_bio = ?, avatar_color = ? WHERE id = ?");
                $stmt->bind_param("sssi", $fullName, $bio, $avatarColor, $currentAdminId);
            } else {
                $stmt = $conn->prepare("UPDATE users SET full_name = ?, profile_bio = ?, avatar_color = ? WHERE email = ?");
                $stmt->bind_param("ssss", $fullName, $bio, $avatarColor, $currentAdminEmail);
            }
        }

        // Execute and visually show database failures if they happen
        if ($stmt->execute()) {
            $message = "Your profile changes have been successfully saved!";
            $msgType = "success";
        } else {
            // This exposes database structure errors directly to you for tracking
            $message = "Database Error: Code could not write data. Details: " . $conn->error;
            $msgType = "error";
        }
    } else {
        $message = "Full Name cannot be left blank.";
        $msgType = "error";
    }
}

// 4. Fetch updated information to print on the screen
if ($currentAdminId) {
    $profileStmt = $conn->prepare("SELECT full_name, email, profile_bio, avatar_color FROM users WHERE id = ?");
    $profileStmt->bind_param("i", $currentAdminId);
} else {
    $profileStmt = $conn->prepare("SELECT full_name, email, profile_bio, avatar_color FROM users WHERE email = ?");
    $profileStmt->bind_param("s", $currentAdminEmail);
}

$profileStmt->execute();
$adminData = $profileStmt->get_result()->fetch_assoc();

// Fallback initialization if database returns nothing (prevents empty layout crashes)
if (!$adminData) {
    $adminData = [
        'full_name' => 'System Administrator',
        'email' => 'admin@farmdirect.com',
        'profile_bio' => '',
        'avatar_color' => '#10b981'
    ];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Account Settings | FarmDirect+</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-slate-50 flex font-sans">

    <!-- Sidebar Menu navigation link stack -->
    <div class="w-64 bg-slate-900 h-screen text-white p-6 fixed shadow-xl z-20">
        <h2 class="text-2xl font-bold mb-10 text-emerald-400 flex items-center gap-2 tracking-wide">
            <i class="fas fa-leaf"></i> FarmDirect+
        </h2>
        <nav class="space-y-3">
            <a href="admin_dashboard.php" class="block p-3 text-slate-300 hover:text-white hover:bg-slate-800 rounded-lg transition-all"><i class="fas fa-chart-line mr-2"></i> Overview</a>
            <a href="admin_manage.php" class="block p-3 text-slate-300 hover:text-white hover:bg-slate-800 rounded-lg transition-all"><i class="fas fa-user-shield mr-2"></i> Team Directory</a>
            <a href="admin_profile.php" class="block p-3 bg-emerald-600 shadow-md shadow-emerald-900/50 rounded-lg transition-all"><i class="fas fa-user-cog mr-2"></i> My Profile</a>
            <a href="customers_list.php" class="block p-3 text-slate-300 hover:text-white hover:bg-slate-800 rounded-lg transition-all"><i class="fas fa-users mr-2"></i> Customers</a>
            
            <div class="pt-8 mt-8 border-t border-slate-700">
                <a href="logout.php" class="block p-3 text-red-400 hover:text-red-300 hover:bg-red-900/20 rounded-lg transition-all"><i class="fas fa-sign-out-alt mr-2"></i> Logout</a>
            </div>
        </nav>
    </div>

    <!-- Right Content Window Viewport -->
    <div class="ml-64 p-8 w-full max-w-5xl mx-auto">
        <header class="mb-10">
            <h1 class="text-3xl font-bold text-slate-800">Profile Settings</h1>
            <p class="text-slate-500 mt-1">Configure your display information and administrative account credentials.</p>
        </header>

        <!-- Notification Banner Window Frame component -->
        <?php if (!empty($message)): ?>
            <div class="p-4 mb-6 rounded-xl flex items-center gap-3 font-semibold text-sm border <?php echo $msgType === 'success' ? 'bg-emerald-50 text-emerald-800 border-emerald-200' : 'bg-red-50 text-red-800 border-red-200'; ?>">
                <i class="fas <?php echo $msgType === 'success' ? 'fa-check-circle' : 'fa-exclamation-triangle'; ?> text-lg"></i>
                <p><?php echo htmlspecialchars($message); ?></p>
            </div>
        <?php endif; ?>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <!-- Header Identity Banner element styling -->
            <div class="h-32 bg-gradient-to-r from-slate-800 to-slate-950 p-6 flex items-end relative">
                <div class="absolute -bottom-10 left-8 w-20 h-20 text-white rounded-2xl flex items-center justify-center text-2xl font-black shadow-lg border-4 border-white uppercase transition-all" style="background-color: <?php echo $adminData['avatar_color']; ?>;">
                    <?php echo substr($adminData['full_name'], 0, 2); ?>
                </div>
            </div>

            <!-- Profile Settings Entry Form Workspace wrapper -->
            <form action="admin_profile.php" method="POST" class="p-8 pt-16 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Display Name</label>
                        <input type="text" name="full_name" value="<?php echo htmlspecialchars($adminData['full_name']); ?>" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none font-medium text-slate-700">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Corporate Email Address <span class="text-slate-400 font-normal">(Cannot change)</span></label>
                        <input type="email" disabled value="<?php echo htmlspecialchars($adminData['email']); ?>" class="w-full bg-slate-100 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-400 cursor-not-allowed outline-none font-mono">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">New Password <span class="text-slate-400 font-normal">(Leave empty to keep current)</span></label>
                        <input type="password" name="new_password" placeholder="••••••••" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Profile Avatar Theme Color</label>
                        <div class="flex items-center gap-3 h-11 mt-1">
                            <input type="color" name="avatar_color" value="<?php echo $adminData['avatar_color']; ?>" class="w-12 h-10 border border-slate-200 rounded-lg cursor-pointer bg-white p-1">
                            <span class="text-xs font-mono font-bold text-slate-500 uppercase"><?php echo $adminData['avatar_color']; ?></span>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Internal Profile Biography / Notes</label>
                    <textarea name="bio" rows="4" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-4 text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none resize-none text-slate-600"><?php echo htmlspecialchars($adminData['profile_bio'] ?? ''); ?></textarea>
                </div>

                <div class="pt-4 border-t border-slate-100 flex justify-end">
                    <button type="submit" name="update_profile" class="bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-3 px-6 rounded-xl shadow-md transition-all">
                        Save Profile Settings
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>