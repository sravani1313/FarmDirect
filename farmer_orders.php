<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['is_farmer'] != 1) {
    header("Location: login.php");
    exit();
}

// Handle Order Status Update
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_order_status'])) {
    $order_id = intval($_POST['order_id']);
    $new_status = $conn->real_escape_string($_POST['status']);
    $sql = "UPDATE orders SET status = '$new_status' WHERE id = $order_id";
    $conn->query($sql);
    header("Location: farmer_orders.php");
    exit();
}

// Fetch All Orders
$orders_result = $conn->query("SELECT * FROM orders ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8"/>
    <title>Orders | FarmDirect+</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Literata:ital,wght@0,600;0,700;1,600&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <style>.material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }</style>
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
                <a class="flex items-center gap-3 px-4 py-3 text-gray-600 hover:bg-gray-200 rounded-xl transition" href="farmer_profile.php">
        <span class="material-symbols-outlined">person</span>
        <span>Profile</span>
    </a>
                <a class="flex items-center gap-3 px-4 py-3 text-gray-600 hover:bg-gray-200 rounded-xl transition" href="farmer_inventory.php">
                    <span class="material-symbols-outlined">potted_plant</span><span>Inventory</span>
                </a>
                <a class="flex items-center gap-3 px-4 py-3 bg-[#aef67b]/20 text-[#326b00] rounded-xl font-bold" href="farmer_orders.php">
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

    <main class="flex-1 md:ml-64 p-6 md:p-10 max-w-7xl mx-auto w-full">
        <div class="mb-8">
            <a href="farmer_dashboard.php" class="inline-flex items-center gap-2 text-gray-500 hover:text-[#154212] font-semibold mb-4 transition-colors">
                <span class="material-symbols-outlined text-[20px]">arrow_back</span> Back to Dashboard
            </a>
            <h2 class="text-4xl font-bold text-gray-900">Order Management</h2>
        </div>

        <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-sm">
            <table class="w-full border-collapse">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-gray-500 uppercase tracking-wider text-xs">Order ID</th>
                        <th class="px-6 py-4 text-left text-gray-500 uppercase tracking-wider text-xs">Date</th>
                        <th class="px-6 py-4 text-left text-gray-500 uppercase tracking-wider text-xs">Total</th>
                        <th class="px-6 py-4 text-left text-gray-500 uppercase tracking-wider text-xs">Update Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php
                    if ($orders_result->num_rows > 0) {
                        while($order = $orders_result->fetch_assoc()) {
                            // Color coding based on status
                            $statusColor = 'bg-gray-100 text-gray-800';
                            if($order['status'] == 'Pending') $statusColor = 'bg-orange-100 text-orange-800';
                            if($order['status'] == 'Shipped' || $order['status'] == 'Delivered') $statusColor = 'bg-green-100 text-green-800';

                            echo '<tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-5 font-bold text-[#154212]">#FD-100'.$order['id'].'</td>
                                <td class="px-6 py-5 text-gray-600">'.date('M d, Y', strtotime($order['created_at'])).'</td>
                                <td class="px-6 py-5 font-semibold">$'.$order['total_price'].'</td>
                                <td class="px-6 py-5">
                                    <form method="POST" class="flex items-center gap-3">
                                        <input type="hidden" name="order_id" value="'.$order['id'].'">
                                        <select name="status" class="text-sm border-gray-300 rounded-lg focus:ring-[#154212] py-2 px-3 font-semibold '.$statusColor.'">
                                            <option value="'.$order['status'].'" selected>Current: '.$order['status'].'</option>
                                            <option value="Pending">Pending</option>
                                            <option value="Processing">Processing</option>
                                            <option value="Shipped">Shipped</option>
                                            <option value="Delivered">Delivered</option>
                                        </select>
                                        <button type="submit" name="update_order_status" class="bg-[#154212] text-white px-4 py-2 rounded-lg hover:bg-green-800 transition font-bold text-sm shadow-sm">Save</button>
                                    </form>
                                </td>
                            </tr>';
                        }
                    } else {
                        echo '<tr><td colspan="4" class="px-6 py-8 text-center text-gray-500">No orders found.</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </main>
</div>
</body>
</html>