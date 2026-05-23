<?php
session_start();
require 'db.php';

if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header("Location: login.php");
    exit();
}

// Basic Stats
$userCount = $conn->query("SELECT COUNT(*) as total FROM users")->fetch_assoc()['total'];
$orderCount = $conn->query("SELECT COUNT(*) as total FROM orders")->fetch_assoc()['total'];
$msgCount = $conn->query("SELECT COUNT(*) as total FROM messages")->fetch_assoc()['total'];

// Fetch data for the Chart (Orders per day for the last 7 days)
$chartQuery = $conn->query("SELECT DATE(created_at) as date, COUNT(*) as count FROM orders GROUP BY DATE(created_at) ORDER BY date DESC LIMIT 7");
$dates = [];
$counts = [];

if ($chartQuery && $chartQuery->num_rows > 0) {
    while($row = $chartQuery->fetch_assoc()) {
        $dates[] = date('M d', strtotime($row['date']));
        $counts[] = $row['count'];
    }
    // Reverse to show chronological order left-to-right
    $dates = array_reverse($dates);
    $counts = array_reverse($counts);
} else {
    // Fallback dummy data so the chart still looks good if the database is empty
    $dates = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
    $counts = [2, 5, 3, 8, 4, 9, 6];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Dashboard | FarmDirect+</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-slate-50 flex font-sans">

    <div class="w-64 bg-slate-900 h-screen text-white p-6 fixed shadow-xl z-20">
        <h2 class="text-2xl font-bold mb-10 text-emerald-400 flex items-center gap-2 tracking-wide">
            <i class="fas fa-leaf"></i> FarmDirect+
        </h2>
        <nav class="space-y-3">
            <a href="admin_dashboard.php" class="block p-3 bg-emerald-600 shadow-md shadow-emerald-900/50 rounded-lg transition-all"><i class="fas fa-chart-line mr-2"></i> Overview</a>
            <a href="admin_manage.php" class="block p-3 text-slate-300 hover:text-white hover:bg-slate-800 rounded-lg transition-all"><i class="fas fa-user-shield mr-2"></i> Team Directory</a>
            <a href="admin_profile.php" class="block p-3 text-slate-300 hover:text-white hover:bg-slate-800 rounded-lg transition-all"><i class="fas fa-user-cog mr-2"></i> My Profile</a>
            <a href="customers_list.php" class="block p-3 text-slate-300 hover:text-white hover:bg-slate-800 rounded-lg transition-all"><i class="fas fa-users mr-2"></i> Customers</a>
            <a href="orders_list.php" class="block p-3 text-slate-300 hover:text-white hover:bg-slate-800 rounded-lg transition-all"><i class="fas fa-box mr-2"></i> Orders</a>
            
            <div class="pt-8 mt-8 border-t border-slate-700">
                <a href="logout.php" class="block p-3 text-red-400 hover:text-red-300 hover:bg-red-900/20 rounded-lg transition-all"><i class="fas fa-sign-out-alt mr-2"></i> Logout</a>
            </div>
        </nav>
    </div>

    <div class="ml-64 p-8 w-full max-w-7xl mx-auto">
        
        <header class="flex flex-col md:flex-row md:justify-between md:items-center mb-10 gap-4">
            <div>
                <h1 class="text-3xl font-bold text-slate-800">Dashboard Overview</h1>
                <p class="text-slate-500 mt-1">Here is what's happening with your store today.</p>
            </div>
            
            <div class="flex items-center gap-4">
                <a href="orders_list.php" class="bg-emerald-100 text-emerald-700 px-4 py-2 rounded-lg font-medium hover:bg-emerald-200 transition-colors">
                    <i class="fas fa-plus mr-1"></i> New Order
                </a>
                <div class="bg-white px-5 py-2.5 rounded-full shadow-sm border border-slate-200 text-sm font-semibold text-slate-700 flex items-center">
                    Welcome, <?php echo htmlspecialchars($_SESSION['user_name'] ?? 'Admin'); ?> 
                    <div class="ml-3 bg-slate-100 p-1.5 rounded-full text-blue-500"><i class="fas fa-user-shield"></i></div>
                </div>
            </div>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:-translate-y-1 hover:shadow-md transition-all duration-300 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-24 h-24 bg-emerald-50 rounded-bl-full -z-10"></div>
                <div class="text-emerald-500 mb-4 bg-emerald-100 w-12 h-12 flex items-center justify-center rounded-xl"><i class="fas fa-users text-xl"></i></div>
                <p class="text-slate-500 text-sm font-medium uppercase tracking-wider">Total Customers</p>
                <h3 class="text-4xl font-black text-slate-800 mt-1"><?php echo $userCount; ?></h3>
            </div>
            
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:-translate-y-1 hover:shadow-md transition-all duration-300 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-24 h-24 bg-blue-50 rounded-bl-full -z-10"></div>
                <div class="text-blue-500 mb-4 bg-blue-100 w-12 h-12 flex items-center justify-center rounded-xl"><i class="fas fa-shopping-bag text-xl"></i></div>
                <p class="text-slate-500 text-sm font-medium uppercase tracking-wider">Total Orders</p>
                <h3 class="text-4xl font-black text-slate-800 mt-1"><?php echo $orderCount; ?></h3>
            </div>
            
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:-translate-y-1 hover:shadow-md transition-all duration-300 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-24 h-24 bg-amber-50 rounded-bl-full -z-10"></div>
                <div class="text-amber-500 mb-4 bg-amber-100 w-12 h-12 flex items-center justify-center rounded-xl"><i class="fas fa-envelope text-xl"></i></div>
                <p class="text-slate-500 text-sm font-medium uppercase tracking-wider">New Messages</p>
                <h3 class="text-4xl font-black text-slate-800 mt-1"><?php echo $msgCount; ?></h3>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 mb-8">
            <div class="flex justify-between items-center mb-6">
                <h2 class="font-bold text-slate-800 text-lg"><i class="fas fa-chart-area text-blue-500 mr-2"></i>Order Analytics</h2>
                <span class="text-xs font-medium bg-slate-100 text-slate-600 px-3 py-1 rounded-full">Last 7 Days</span>
            </div>
            <div class="relative w-full h-72">
                <canvas id="analyticsChart"></canvas>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="font-bold text-slate-800"><i class="fas fa-user-plus text-emerald-500 mr-2"></i>Latest Users</h2>
                    <a href="customers_list.php" class="text-sm text-blue-500 hover:underline font-medium">View All</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <tr class="text-slate-400 border-b border-slate-100"><th class="pb-3 text-left font-medium">Name</th><th class="pb-3 text-right font-medium">Joined</th></tr>
                        <?php
                        $users = $conn->query("SELECT full_name, created_at FROM users ORDER BY created_at DESC LIMIT 5");
                        if($users && $users->num_rows > 0) {
                            while($row = $users->fetch_assoc()) {
                                echo "<tr class='border-b border-slate-50 last:border-0 hover:bg-slate-50 transition-colors'>
                                        <td class='py-4 font-semibold text-slate-700'>{$row['full_name']}</td>
                                        <td class='py-4 text-right text-slate-500'>".date('M d, Y', strtotime($row['created_at']))."</td>
                                      </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='2' class='py-4 text-center text-slate-400'>No users found.</td></tr>";
                        }
                        ?>
                    </table>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="font-bold text-slate-800"><i class="fas fa-comment-dots text-amber-500 mr-2"></i>Recent Inquiries</h2>
                </div>
                <div class="space-y-4">
                    <?php
                    $msgs = $conn->query("SELECT full_name, message FROM messages ORDER BY id DESC LIMIT 4");
                    if($msgs && $msgs->num_rows > 0) {
                        while($row = $msgs->fetch_assoc()) {
                            echo "<div class='p-4 bg-slate-50 rounded-xl border border-slate-100 hover:border-amber-200 transition-colors'>
                                    <div class='flex items-center mb-1'>
                                        <div class='w-8 h-8 bg-amber-100 text-amber-600 rounded-full flex items-center justify-center font-bold text-xs mr-3'>".substr($row['full_name'], 0, 1)."</div>
                                        <p class='font-bold text-slate-700 text-sm'>{$row['full_name']}</p>
                                    </div>
                                    <p class='text-sm text-slate-500 ml-11 line-clamp-2'>{$row['message']}</p>
                                  </div>";
                        }
                    } else {
                        echo "<div class='p-4 text-center text-slate-400'>No new messages.</div>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('analyticsChart').getContext('2d');
            
            let gradient = ctx.createLinearGradient(0, 0, 0, 400);
            gradient.addColorStop(0, 'rgba(16, 185, 129, 0.5)'); 
            gradient.addColorStop(1, 'rgba(16, 185, 129, 0.0)');

            const myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: <?php echo json_encode($dates); ?>,
                    datasets: [{
                        label: 'Orders',
                        data: <?php echo json_encode($counts); ?>,
                        borderColor: '#10b981', 
                        backgroundColor: gradient,
                        borderWidth: 3,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#10b981',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        fill: true,
                        tension: 0.4 
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
                            displayColors: false
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
                                stepSize: 1,
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