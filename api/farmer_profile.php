<?php
session_start();
require 'db.php';

// Route Protection
if (!isset($_SESSION['user_id']) || $_SESSION['is_farmer'] != 1) {
    header("Location: login.php");
    exit();
}

$farmer_id = $_SESSION['user_id'];
$firstName = explode(' ', trim($_SESSION['user_name']))[0];
$message = '';

// Handle Profile Update
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_profile'])) {
    $full_name = $conn->real_escape_string($_POST['full_name']);
    $email     = $conn->real_escape_string($_POST['email']);
    $phone     = $conn->real_escape_string($_POST['phone']);
    $address   = $conn->real_escape_string($_POST['address']);
    $bio       = $conn->real_escape_string($_POST['profile_bio']);
    $food      = $conn->real_escape_string($_POST['favorite_food']);
    $color     = $conn->real_escape_string($_POST['avatar_color']);

    $sql = "UPDATE users SET full_name=?, email=?, phone=?, address=?, profile_bio=?, favorite_food=?, avatar_color=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssi", $full_name, $email, $phone, $address, $bio, $food, $color, $farmer_id);
    
    if ($stmt->execute()) {
        $message = "Profile updated successfully!";
    }
}

// Fetch Fresh Data
$user = $conn->query("SELECT * FROM users WHERE id=$farmer_id")->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Farmer Profile | FarmDirect+</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
    <style>
        .modern-input { width: 100%; background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 0.75rem; padding: 0.75rem 1rem; outline: none; }
        .modern-input:focus { border-color: #10b981; box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1); }
        .modern-label { font-size: 0.75rem; font-weight: 700; color: #64748b; text-transform: uppercase; margin-bottom: 0.5rem; display: block; }
    </style>
</head>
<body class="bg-[#faf9f6] text-[#1a1c1a] font-sans">
<div class="flex min-h-screen">

     <aside class="hidden md:flex h-screen w-64 flex-col bg-[#f4f3f1] border-r border-gray-200 fixed left-0 top-0 z-40">
        <div class="flex flex-col p-4 gap-2 h-full">
            <div class="px-4 py-6 mb-4">
                <h2 class="text-lg text-[#154212] font-bold"><?php echo htmlspecialchars($_SESSION['user_name']); ?></h2>
                <p class="text-sm text-gray-500">Verified Steward</p>
            </div>
            <nav class="flex-1 space-y-1">
                <a class="flex items-center gap-3 px-4 py-3 text-gray-600 hover:bg-gray-200 rounded-xl transition" href="farmer_dashboard.php">
                    <span class="material-symbols-outlined">dashboard</span><span>Dashboard</span>
                </a>
                <a class="flex items-center gap-3 px-4 py-3 bg-[#aef67b]/20 text-[#326b00] rounded-xl font-bold" href="farmer_profile.php">
        <span class="material-symbols-outlined">person</span>
        <span>Profile</span>
    </a>
                <a class="flex items-center gap-3 px-4 py-3 text-gray-600 hover:bg-gray-200 rounded-xl transition" href="farmer_inventory.php">
                    <span class="material-symbols-outlined">potted_plant</span><span>Inventory</span>
                </a>
                <a class="flex items-center gap-3 px-4 py-3 text-gray-600 hover:bg-gray-200 rounded-xl transition " href="farmer_orders.php">
                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">shopping_cart</span><span>Orders</span>
                </a>
            </nav>
            <div class="mt-auto pt-6 border-t border-gray-300 space-y-1">
                <a class="flex items-center gap-3 px-4 py-3 text-red-600 hover:bg-red-50 rounded-xl transition font-bold" href="login.php">
                    <span class="material-symbols-outlined">logout</span><span>Logout</span>
                </a>
            </div>
        </div>
    </aside>

    <main class="ml-64 p-8 w-full max-w-5xl">
        
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="bg-slate-900 p-8 text-white">
                <h1 class="text-2xl font-black flex items-center gap-3">
                    <i class="fas fa-user-shield text-emerald-400"></i> Account Configuration Suite
                </h1>
                <p class="text-slate-400 mt-2">Manage your identity, farm details, and security.</p>
            </div>

            <div class="p-8">
                <?php if($message): ?>
                    <div class="bg-emerald-50 text-emerald-800 p-4 rounded-xl mb-6 border border-emerald-200 font-bold">
                        <i class="fas fa-check-circle mr-2"></i> <?php echo $message; ?>
                    </div>
                <?php endif; ?>

                <form method="POST" class="space-y-8">
                    <div>
                        <h3 class="text-lg font-bold text-slate-800 mb-5 border-b pb-2"><i class="fas fa-id-badge text-emerald-500 mr-2"></i> Basic Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="modern-label">Full Legal Name</label>
                                <input type="text" name="full_name" value="<?php echo htmlspecialchars($user['full_name'] ?? ''); ?>" class="modern-input" required>
                            </div>
                            <div>
                                <label class="modern-label">Favorite Food</label>
                                <input type="text" name="favorite_food" value="<?php echo htmlspecialchars($user['favorite_food'] ?? ''); ?>" class="modern-input">
                            </div>
                            <div>
                                <label class="modern-label">Profile Theme Color</label>
                                <input type="color" name="avatar_color" value="<?php echo $user['avatar_color'] ?? '#10b981'; ?>" class="w-full h-12 p-1 rounded-lg cursor-pointer">
                            </div>
                        </div>
                        <div class="mt-6">
                            <label class="modern-label">Personal Bio</label>
                            <textarea name="profile_bio" rows="3" class="modern-input"><?php echo htmlspecialchars($user['profile_bio'] ?? ''); ?></textarea>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-lg font-bold text-slate-800 mb-5 border-b pb-2"><i class="fas fa-map-marked-alt text-blue-500 mr-2"></i> Contact Details</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="modern-label">Email Address</label>
                                <input type="email" name="email" value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>" class="modern-input" required>
                            </div>
                            <div>
                                <label class="modern-label">Phone Number</label>
                                <input type="text" name="phone" value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>" class="modern-input">
                            </div>
                            <div class="md:col-span-2">
                                <label class="modern-label">Farm Address</label>
                                <textarea name="address" rows="2" class="modern-input"><?php echo htmlspecialchars($user['address'] ?? ''); ?></textarea>
                            </div>
                        </div>
                    </div>

                    <button type="submit" name="update_profile" class="bg-slate-900 hover:bg-slate-800 text-white font-bold py-3 px-8 rounded-xl shadow-lg transition-all">
                        Commit Changes
                    </button>
                </form>
            </div>
        </div>
    </main>
</body>
</html>