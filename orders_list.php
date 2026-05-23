<?php
session_start();
require 'db.php';

// Ensure the user is an admin
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header("Location: login.php");
    exit();
}

// Fetch orders and join with users to get the customer name
$query = "
    SELECT orders.*, users.full_name as customer_name 
    FROM orders 
    LEFT JOIN users ON orders.user_id = users.id 
    ORDER BY orders.created_at DESC
"; 
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>All Orders | FarmDirect+</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-slate-100 min-h-screen p-8">
    
    <div class="max-w-6xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-slate-800">
                <i class="fas fa-box text-blue-500 mr-3"></i>All Orders
            </h1>
            <a href="admin_dashboard.php" class="text-slate-600 hover:text-slate-900 font-medium transition-colors bg-white px-4 py-2 rounded-lg shadow-sm border border-slate-200">
                <i class="fas fa-arrow-left mr-2"></i>Back to Dashboard
            </a>
        </div>

        <?php if (isset($_GET['msg']) && $_GET['msg'] == 'updated'): ?>
            <div class="bg-emerald-100 text-emerald-700 px-4 py-3 rounded-lg mb-6 shadow-sm border border-emerald-200">
                <i class="fas fa-check-circle mr-2"></i> Order successfully marked as completed.
            </div>
        <?php endif; ?>
        
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr class="text-slate-400">
                        <th class="p-4 text-left font-bold uppercase tracking-wider">Order ID</th>
                        <th class="p-4 text-left font-bold uppercase tracking-wider">Customer Name</th>
                        <th class="p-4 text-left font-bold uppercase tracking-wider">Total Amount</th>
                        <th class="p-4 text-left font-bold uppercase tracking-wider">Status</th>
                        <th class="p-4 text-center font-bold uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php while($row = $result->fetch_assoc()): ?>
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="p-4 font-semibold text-slate-700">#<?php echo $row['id']; ?></td>
                        
                        <td class="p-4 text-slate-700 font-medium">
                            <?php echo isset($row['customer_name']) ? htmlspecialchars($row['customer_name']) : '<span class="text-slate-400 italic">Guest</span>'; ?>
                        </td>
                        
                        <td class="p-4 text-slate-700 font-bold">
                            $<?php echo isset($row['total_price']) ? number_format($row['total_price'], 2) : '0.00'; ?>
                        </td>
                        
                        <td class="p-4">
                            <?php 
                                // Create attractive dynamic status badges
                                $status = isset($row['status']) ? $row['status'] : 'Pending';
                                if (strtolower($status) == 'completed') {
                                    echo "<span class='bg-emerald-100 text-emerald-700 px-3 py-1 rounded-full text-xs font-bold'><i class='fas fa-check mr-1'></i> $status</span>";
                                } else {
                                    echo "<span class='bg-amber-100 text-amber-700 px-3 py-1 rounded-full text-xs font-bold'><i class='fas fa-clock mr-1'></i> $status</span>";
                                }
                            ?>
                        </td>

                        <td class="p-4 text-center">
                            <?php if (strtolower($status) != 'completed'): ?>
                                <a href="update_order.php?id=<?php echo $row['id']; ?>" 
                                   onclick="return confirm('Mark this order as completed?');"
                                   class="inline-block text-emerald-600 hover:text-white hover:bg-emerald-500 px-3 py-1.5 rounded-lg transition-all border border-emerald-200">
                                    <i class="fas fa-check-double mr-1"></i> Complete
                                </a>
                            <?php else: ?>
                                <span class="text-slate-400 text-sm font-medium"><i class="fas fa-check-circle"></i> Done</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>