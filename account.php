<?php
session_start();
require 'db.php';
echo "Session User ID: " . $_SESSION['user_id'];


// Route Protection Guard
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$message = '';
$msgType = '';

// Handle Comprehensive Profile Update Data Mutations
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_profile'])) {
    $new_name = trim($_POST['full_name']);
    $new_email = trim($_POST['email']);
    $new_bio = trim($_POST['bio']);
    $new_food = trim($_POST['favorite_food']); // NEW FIELD
    $new_color = $_POST['avatar_color'];
    
    // New Extended Fields
    $new_phone = trim($_POST['phone'] ?? '');
    $new_address = trim($_POST['address'] ?? '');
    $new_city = trim($_POST['city'] ?? '');
    $new_zip = trim($_POST['zip'] ?? '');
    $new_password = $_POST['new_password'] ?? '';

    if (!empty($new_name) && !empty($new_email)) {
        
        // Check if the user is also trying to change their password
        if (!empty($new_password)) {
            $hashedPassword = password_hash($new_password, PASSWORD_BCRYPT);
            $stmt = $conn->prepare("UPDATE users SET full_name = ?, email = ?, profile_bio = ?, favorite_food = ?, avatar_color = ?, phone = ?, address = ?, city = ?, zip = ?, password = ? WHERE id = ?");
            $stmt->bind_param("ssssssssssi", $new_name, $new_email, $new_bio, $new_food, $new_color, $new_phone, $new_address, $new_city, $new_zip, $hashedPassword, $user_id);
        } else {
            // Update everything except the password
            $stmt = $conn->prepare("UPDATE users SET full_name = ?, email = ?, profile_bio = ?, favorite_food = ?, avatar_color = ?, phone = ?, address = ?, city = ?, zip = ? WHERE id = ?");
            $stmt->bind_param("sssssssssi", $new_name, $new_email, $new_bio, $new_food, $new_color, $new_phone, $new_address, $new_city, $new_zip, $user_id);
        }
        
        if ($stmt->execute()) {
            $message = "Your personal ecosystem matrix has been successfully updated!";
            $msgType = "success";
            $_SESSION['user_name'] = $new_name; // Sync current active session string
        } else {
            $message = "Database write error: " . $conn->error;
            $msgType = "error";
        }
    } else {
        $message = "Core identity fields (Name and Email) cannot be left empty.";
        $msgType = "error";
    }
}

// Fetch Fresh Contextual User Workspace Record Data Set
$user = $conn->prepare("SELECT full_name, email, profile_bio, favorite_food, avatar_color, phone, address, city, zip FROM users WHERE id = ?");
$user->bind_param("i", $user_id);
$user->execute();
$userData = $user->get_result()->fetch_assoc();

// Aggregation Statistics Queries
$stats_orders = $conn->prepare("SELECT COUNT(*) as total, SUM(total_price) as spent FROM orders WHERE user_id = ?");
$stats_orders->bind_param("i", $user_id);
$stats_orders->execute();
$statsData = $stats_orders->get_result()->fetch_assoc();
$totalSpent = $statsData['spent'] ?? 0;
$totalOrders = $statsData['total'] ?? 0;

// FETCH GRAPH DATA: Last 7 Days of Spending
$chartQuery = $conn->prepare("SELECT DATE(created_at) as date, SUM(total_price) as daily_spent FROM orders WHERE user_id = ? GROUP BY DATE(created_at) ORDER BY date DESC LIMIT 7");
$chartQuery->bind_param("i", $user_id);
$chartQuery->execute();
$chartResult = $chartQuery->get_result();
$dates = [];
$spent = [];

if ($chartResult && $chartResult->num_rows > 0) {
    while($row = $chartResult->fetch_assoc()) {
        $dates[] = date('M d', strtotime($row['date']));
        $spent[] = $row['daily_spent'];
    }
    // Reverse to show chronological order left-to-right
    $dates = array_reverse($dates);
    $spent = array_reverse($spent);
} else {
    // Fallback empty data if no orders yet
    $dates = [date('M d', strtotime('-6 days')), date('M d', strtotime('-5 days')), date('M d', strtotime('-4 days')), date('M d', strtotime('-3 days')), date('M d', strtotime('-2 days')), date('M d', strtotime('-1 days')), date('M d')];
    $spent = [0, 0, 0, 0, 0, 0, 0];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard | FarmDirect+</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        html { scroll-behavior: smooth; }
        @keyframes slideIn {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-slide { animation: slideIn 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
        
        .modern-input {
            width: 100%;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 0.75rem;
            padding: 0.75rem 1rem;
            font-size: 0.875rem;
            font-weight: 500;
            color: #334155;
            transition: all 0.2s ease;
            outline: none;
        }
        .modern-input:focus {
            background-color: #ffffff;
            border-color: #10b981;
            box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
        }
        .modern-label {
            display: block;
            font-size: 0.75rem;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 0.5rem;
        }
    </style>
</head>
<body class="bg-slate-50 flex font-sans antialiased min-h-screen">

    <div class="w-64 bg-slate-900 h-screen text-white p-6 fixed shadow-xl z-20 flex flex-col justify-between">
        <div>
            <h2 class="text-2xl font-bold mb-10 text-emerald-400 flex items-center gap-2 tracking-wide">
                <i class="fas fa-leaf animate-pulse"></i> FarmDirect+
            </h2>
            <nav class="space-y-2">
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-3 mt-6">Main Menu</p>
                <a href="#" class="block p-3 bg-emerald-600 shadow-md shadow-emerald-900/50 rounded-lg transition-all font-semibold"><i class="fas fa-columns mr-2 w-5"></i> Dashboard</a>
                <a href="shop.php" class="block p-3 text-slate-300 hover:text-white hover:bg-slate-800 rounded-lg transition-all font-semibold"><i class="fas fa-store mr-2 w-5"></i> Marketplace</a>
                
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-3 mt-8">My Account</p>
                <a href="#orders-section" class="block p-3 text-slate-300 hover:text-white hover:bg-slate-800 rounded-lg transition-all font-semibold"><i class="fas fa-receipt mr-2 w-5"></i> Order History</a>
                <a href="#settings-section" class="block p-3 text-slate-300 hover:text-white hover:bg-slate-800 rounded-lg transition-all font-semibold"><i class="fas fa-user-cog mr-2 w-5"></i> Profile Settings</a>
            </nav>
        </div>
        
        <div class="border-t border-slate-800 pt-6">
            <a href="logout.php" class="block p-3 text-red-400 hover:text-red-300 hover:bg-red-900/20 rounded-lg transition-all font-bold"><i class="fas fa-sign-out-alt mr-2"></i> Logout Portal</a>
        </div>
    </div>

    <div class="ml-64 p-8 w-full max-w-6xl mx-auto flex flex-col justify-between min-h-screen animate-slide">
        
        <div>
            <header class="flex flex-col md:flex-row md:justify-between md:items-center mb-10 gap-4">
                <div>
                    <h1 class="text-3xl font-black text-slate-800 tracking-tight">Customer Hub</h1>
                    <p class="text-slate-500 mt-1">Manage your supply chain ecosystem and account details.</p>
                </div>
                
                <!-- Interactive Profile Header -->
<div class="fixed top-6 right-8 z-30">
    <a href="#settings-section" class="bg-white px-5 py-3 rounded-2xl shadow-lg border border-slate-100 flex items-center gap-4 hover:shadow-emerald-100 hover:border-emerald-200 transition-all duration-300 group">
        <div class="text-right hidden sm:block">
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">My Profile</p>
            <p class="font-bold text-slate-800 group-hover:text-emerald-600 transition-colors">
                <?php echo htmlspecialchars($_SESSION['user_name'] ?? 'User'); ?>
            </p>
        </div>
        <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-white shadow-md transition-transform group-hover:scale-105" 
             style="background-color: <?php echo !empty($userData['avatar_color']) ? $userData['avatar_color'] : '#10b981'; ?>;">
            <?php echo strtoupper(substr($userData['full_name'] ?? 'U', 0, 1)); ?>
        </div>
    </a>
</div>
            </header>

            
            <?php if (!empty($message)): ?>
                <div class="p-4 mb-6 rounded-2xl flex items-center gap-3 font-semibold text-sm border transition-all <?php echo $msgType === 'success' ? 'bg-emerald-50 text-emerald-800 border-emerald-200' : 'bg-red-50 text-red-800 border-red-200'; ?>">
                    <i class="fas <?php echo $msgType === 'success' ? 'fa-check-circle' : 'fa-exclamation-triangle'; ?> text-lg"></i>
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 relative overflow-hidden group">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-emerald-50 rounded-bl-full -z-10 transition-transform group-hover:scale-110"></div>
                    <div class="text-emerald-500 mb-4 bg-emerald-100 w-12 h-12 flex items-center justify-center rounded-xl"><i class="fas fa-shopping-bag text-xl"></i></div>
                    <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Total Purchases</p>
                    <h3 class="text-4xl font-black text-slate-800 mt-1"><?php echo $totalOrders; ?> <span class="text-xs font-medium text-slate-400">orders</span></h3>
                </div>
                
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 relative overflow-hidden group">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-blue-50 rounded-bl-full -z-10 transition-transform group-hover:scale-110"></div>
                    <div class="text-blue-500 mb-4 bg-blue-100 w-12 h-12 flex items-center justify-center rounded-xl"><i class="fas fa-wallet text-xl"></i></div>
                    <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Total Invested</p>
                    <h3 class="text-4xl font-black text-slate-800 mt-1">$<?php echo number_format((float)$totalSpent, 2); ?></h3>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-5">
                    <div class="w-20 h-20 text-white rounded-2xl flex items-center justify-center font-black text-3xl uppercase shadow-inner" style="background-color: <?php echo !empty($userData['avatar_color']) ? $userData['avatar_color'] : '#10b981'; ?>;">
                        <?php echo substr($userData['full_name'] ?? 'U', 0, 2); ?>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-slate-800"><?php echo htmlspecialchars($userData['full_name']); ?></h3>
                        <p class="text-slate-500 text-sm font-medium mt-0.5"><?php echo htmlspecialchars($userData['email']); ?></p>
                        <?php if (!empty($userData['favorite_food'])): ?>
                            <p class="text-xs text-amber-600 font-bold mt-1"><i class="fas fa-utensils"></i> Loves: <?php echo htmlspecialchars($userData['favorite_food']); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 mb-12">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="font-bold text-slate-800 text-lg"><i class="fas fa-chart-line text-blue-500 mr-2"></i>Spending Analytics</h2>
                    <span class="text-xs font-medium bg-slate-100 text-slate-600 px-3 py-1 rounded-full">Last 7 Days</span>
                </div>
                <div class="relative w-full h-72">
                    <canvas id="userAnalyticsChart"></canvas>
                </div>
            </div>

            <div id="orders-section" class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8 mb-12 scroll-mt-8">
                <div class="flex justify-between items-end mb-8">
                    <div>
                        <h2 class="text-2xl font-black text-slate-800 flex items-center gap-2"><i class="fas fa-history text-blue-500"></i> Procurement Invoices</h2>
                        <p class="text-slate-500 text-sm mt-1">Review your past market orders and current delivery statuses.</p>
                    </div>
                </div>
                
                <div class="space-y-4">
                    <?php
                    $orders = $conn->prepare("SELECT id, total_price, status, created_at FROM orders WHERE user_id = ? ORDER BY created_at DESC LIMIT 5");
                    $orders->bind_param("i", $user_id);
                    $orders->execute();
                    $result = $orders->get_result();
                    
                    if ($result && $result->num_rows > 0):
                        while ($row = $result->fetch_assoc()):
                            $status = strtolower($row['status']);
                            $badgeClass = 'bg-slate-100 text-slate-600';
                            if (strpos($status, 'deliv') !== false || strpos($status, 'comp') !== false || strpos($status, 'paid') !== false) {
                                $badgeClass = 'bg-emerald-50 text-emerald-700 border border-emerald-100';
                            } elseif (strpos($status, 'pend') !== false || strpos($status, 'proc') !== false) {
                                $badgeClass = 'bg-amber-50 text-amber-700 border border-amber-100';
                            }
                    ?>
                        <div class="p-5 bg-slate-50/50 hover:bg-slate-50 border border-slate-100 rounded-xl flex flex-col md:flex-row md:justify-between md:items-center transition-all duration-200 group gap-4">
                            <div class="flex items-center gap-5">
                                <div class="w-12 h-12 bg-white text-slate-600 border border-slate-200 rounded-xl flex items-center justify-center font-bold text-sm shadow-sm">
                                    #<?php echo $row['id']; ?>
                                </div>
                                <div>
                                    <p class="font-bold text-slate-700 text-lg group-hover:text-emerald-600 transition-colors">Standard Market Package</p>
                                    <p class="text-sm text-slate-500 mt-0.5"><i class="far fa-calendar-alt mr-1"></i> <?php echo date('F j, Y \a\t g:i A', strtotime($row['created_at'])); ?></p>
                                </div>
                            </div>
                            <div class="text-left md:text-right flex md:block items-center justify-between">
                                <p class="font-black text-slate-800 text-xl">$<?php echo number_format($row['total_price'], 2); ?></p>
                                <span class="text-xs font-bold uppercase tracking-wider px-3 py-1 rounded-lg inline-block md:mt-1 <?php echo $badgeClass; ?>"><?php echo htmlspecialchars($row['status']); ?></span>
                            </div>
                        </div>
                    <?php 
                        endwhile;
                    else: 
                    ?>
                        <div class="py-16 text-center border-2 border-dashed border-slate-200 rounded-2xl bg-slate-50">
                            <div class="text-slate-300 text-5xl mb-4"><i class="fas fa-box-open"></i></div>
                            <p class="text-lg font-bold text-slate-600">No purchase records found.</p>
                            <p class="text-slate-400 text-sm mt-1">When you place an order in the marketplace, it will appear here.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div id="settings-section" class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden scroll-mt-8">
                
                <div class="bg-slate-900 p-8 text-white relative overflow-hidden">
                    <div class="absolute right-0 top-0 opacity-10 text-9xl -mt-4 -mr-4"><i class="fas fa-cog"></i></div>
                    <h2 class="text-2xl font-black relative z-10 flex items-center gap-3">
                        <i class="fas fa-user-shield text-emerald-400"></i> Account Configuration Suite
                    </h2>
                    <p class="text-slate-400 mt-2 relative z-10">Manage your identity, delivery routing, and security protocols.</p>
                </div>

                <form method="POST" class="p-8">
                    
                    <div class="mb-10">
                        <h3 class="text-lg font-bold text-slate-800 mb-5 border-b border-slate-100 pb-2"><i class="fas fa-id-badge text-emerald-500 mr-2"></i> Basic Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="modern-label">Full Legal Name</label>
                                <input type="text" name="full_name" value="<?php echo htmlspecialchars($userData['full_name']); ?>" required class="modern-input">
                            </div>
                            <div>
                                <label class="modern-label">Favorite Food</label>
                                <input type="text" name="favorite_food" value="<?php echo htmlspecialchars($userData['favorite_food'] ?? ''); ?>" placeholder="e.g., KFC, Crispy Fried Snacks" class="modern-input">
                            </div>
                            <div>
                                <label class="modern-label">Profile Theme Color</label>
                                <div class="flex items-center gap-3">
                                    <input type="color" name="avatar_color" value="<?php echo !empty($userData['avatar_color']) ? $userData['avatar_color'] : '#10b981'; ?>" class="w-14 h-12 border border-slate-200 rounded-xl cursor-pointer bg-white p-1">
                                    <span class="text-sm font-mono font-bold text-slate-500 uppercase bg-slate-50 px-3 py-2 rounded-lg border border-slate-100"><?php echo !empty($userData['avatar_color']) ? $userData['avatar_color'] : '#10b981'; ?></span>
                                </div>
                            </div>
                            <div class="md:col-span-2">
                                <label class="modern-label">Personal Bio / Delivery Notes <span class="text-slate-400 font-normal lowercase">(Optional)</span></label>
                                <textarea name="bio" rows="2" class="modern-input resize-none"><?php echo htmlspecialchars($userData['profile_bio'] ?? ''); ?></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="mb-10">
                        <h3 class="text-lg font-bold text-slate-800 mb-5 border-b border-slate-100 pb-2"><i class="fas fa-map-marked-alt text-blue-500 mr-2"></i> Contact & Delivery Routing</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="modern-label">Email Address</label>
                                <input type="email" name="email" value="<?php echo htmlspecialchars($userData['email']); ?>" required class="modern-input">
                            </div>
                            <div>
                                <label class="modern-label">Phone Number</label>
                                <input type="text" name="phone" value="<?php echo htmlspecialchars($userData['phone'] ?? ''); ?>" placeholder="(555) 123-4567" class="modern-input">
                            </div>
                            <div class="md:col-span-2">
                                <label class="modern-label">Street Address</label>
                                <input type="text" name="address" value="<?php echo htmlspecialchars($userData['address'] ?? ''); ?>" placeholder="123 Farmville Lane, Apt 4B" class="modern-input">
                            </div>
                            <div>
                                <label class="modern-label">City</label>
                                <input type="text" name="city" value="<?php echo htmlspecialchars($userData['city'] ?? ''); ?>" placeholder="Agritown" class="modern-input">
                            </div>
                            <div>
                                <label class="modern-label">ZIP / Postal Code</label>
                                <input type="text" name="zip" value="<?php echo htmlspecialchars($userData['zip'] ?? ''); ?>" placeholder="12345" class="modern-input">
                            </div>
                        </div>
                    </div>

                    <div class="mb-10">
                        <h3 class="text-lg font-bold text-slate-800 mb-5 border-b border-slate-100 pb-2"><i class="fas fa-lock text-amber-500 mr-2"></i> Security Verification</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="modern-label">Change Password <span class="text-slate-400 font-normal lowercase">(Leave blank to keep current)</span></label>
                                <input type="password" name="new_password" placeholder="••••••••" class="modern-input">
                            </div>
                        </div>
                    </div>

                    <div class="pt-6 border-t border-slate-100 flex justify-end">
                        <button type="submit" name="update_profile" class="bg-slate-900 hover:bg-slate-800 text-white font-bold py-3 px-8 rounded-xl shadow-lg transition-all flex items-center gap-2">
                            <i class="fas fa-save"></i> Commit Changes
                        </button>
                    </div>
                </form>
            </div>

        </div>

        <footer class="pt-12 mt-12 border-t border-slate-200 w-full flex flex-col md:flex-row justify-between items-center text-slate-500 text-sm font-medium gap-2">
            <p>&copy; <?php echo date('Y'); ?> FarmDirect+ Ecosystem Inc. All rights reserved.</p>
            <p class="font-mono text-slate-400">SECURE SHELL USER NODE CONNECTED</p>
        </footer>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('userAnalyticsChart').getContext('2d');
            
            // Cool custom gradient for the user chart
            let gradient = ctx.createLinearGradient(0, 0, 0, 400);
            gradient.addColorStop(0, 'rgba(59, 130, 246, 0.5)'); // Blue fading out
            gradient.addColorStop(1, 'rgba(59, 130, 246, 0.0)');

            const myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: <?php echo json_encode($dates); ?>,
                    datasets: [{
                        label: 'Amount Spent ($)',
                        data: <?php echo json_encode($spent); ?>,
                        borderColor: '#3b82f6', // Tailwind Blue-500
                        backgroundColor: gradient,
                        borderWidth: 3,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#3b82f6',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        fill: true,
                        tension: 0.4 // This makes the line beautifully curved
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#1e293b',
                            padding: 12,
                            titleFont: { size: 13 },
                            bodyFont: { size: 14, weight: 'bold' },
                            displayColors: false,
                            callbacks: {
                                label: function(context) {
                                    return '$' + context.parsed.y.toFixed(2);
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: '#f1f5f9',
                                drawBorder: false
                            },
                            ticks: {
                                callback: function(value) {
                                    return '$' + value;
                                },
                                color: '#94a3b8'
                            }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { color: '#94a3b8' }
                        }
                    },
                    animation: {
                        duration: 2000,
                        easing: 'easeOutQuart'
                    }
                }
            });
        });
    </script>
</body>
</html>
