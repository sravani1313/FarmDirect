<?php
session_start();
require 'db.php'; // Make sure this points to your database connection file

// Protect the page: kick them out if they aren't logged in OR aren't a farmer
if (!isset($_SESSION['user_id']) || $_SESSION['is_farmer'] != 1) {
    header("Location: login.php");
    exit();
}

$farmer_id = $_SESSION['user_id'];
$firstName = explode(' ', trim($_SESSION['user_name']))[0];

// ---------------------------------------------------------
// HANDLE FORM SUBMISSIONS (ADD PRODUCT, DELETE PRODUCT, UPDATE ORDER)
// ---------------------------------------------------------
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // 1. Add New Product
    if (isset($_POST['add_product'])) {
        $name = $conn->real_escape_string($_POST['product_name']);
        $price = floatval($_POST['product_price']);
        // Storing a default image for now. You can add file upload logic later!
        $image = 'default.jpg'; 
        
        $sql = "INSERT INTO products (name, price, image, farmer_id) VALUES ('$name', $price, '$image', $farmer_id)";
        $conn->query($sql);
        header("Location: farmer_dashboard.php");
        exit();
    }

    // 2. Delete Product
    if (isset($_POST['delete_product'])) {
        $prod_id = intval($_POST['product_id']);
        $sql = "DELETE FROM products WHERE id = $prod_id AND farmer_id = $farmer_id";
        $conn->query($sql);
        header("Location: farmer_dashboard.php");
        exit();
    }

    // 3. Update Order Status
    if (isset($_POST['update_order_status'])) {
        $order_id = intval($_POST['order_id']);
        $new_status = $conn->real_escape_string($_POST['status']);
        $sql = "UPDATE orders SET status = '$new_status' WHERE id = $order_id";
        $conn->query($sql);
        header("Location: farmer_dashboard.php");
        exit();
    }
}

// ---------------------------------------------------------
// FETCH DATA FOR DASHBOARD
// ---------------------------------------------------------
// Fetch Farmer's Products
$products_result = $conn->query("SELECT * FROM products WHERE farmer_id = $farmer_id ORDER BY id DESC");

// Fetch Recent Orders (Displaying all recent orders for the demo)
$orders_result = $conn->query("SELECT * FROM orders ORDER BY created_at DESC LIMIT 10");

// Calculate some mock stats for the dashboard
$total_products = $products_result->num_rows;
$total_orders = $orders_result->num_rows;
?>

<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Farmer Dashboard | FarmDirect+</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Literata:ital,wght@0,600;0,700;1,600&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <script id="tailwind-config">
        tailwind.config = {
          darkMode: "class",
          theme: {
            extend: {
              "colors": {
                      "on-background": "#1a1c1a",
                      "surface-container": "#efeeeb",
                      "secondary-fixed": "#aef67b",
                      "background": "#faf9f6",
                      "on-surface": "#1a1c1a",
                      "error": "#ba1a1a",
                      "surface-variant": "#e3e2e0",
                      "outline-variant": "#c2c9bb",
                      "on-primary": "#ffffff",
                      "surface": "#faf9f6",
                      "surface-container-low": "#f4f3f1",
                      "primary": "#154212",
                      "secondary": "#326b00"
              },
            },
          },
        }
    </script>
    <style>
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="bg-background text-on-surface font-sans selection:bg-secondary-fixed selection:text-black">
<div class="flex min-h-screen">
    
<aside class="hidden md:flex h-screen w-64 flex-col bg-surface-container-low border-r border-outline-variant/20 fixed left-0 top-0 z-40">
    <div class="flex flex-col p-4 gap-2 h-full">
        <div class="px-4 py-6 mb-4">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold text-xl">
                    <?php echo substr($firstName, 0, 1); ?>
                </div>
                <div>
                    <h2 class="text-lg text-primary font-bold"><?php echo htmlspecialchars($_SESSION['user_name']); ?></h2>
                    <p class="text-sm text-gray-500">Verified Steward</p>
                </div>
            </div>
        </div>
        
        <nav class="flex-1 space-y-1">
    <a class="flex items-center gap-3 px-4 py-3 bg-secondary/20 text-secondary rounded-xl font-bold" href="farmer_dashboard.php">
        <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">dashboard</span>
        <span>Dashboard</span>
    </a>
    <!-- Add this link -->
    <a class="flex items-center gap-3 px-4 py-3 text-gray-600 hover:bg-gray-200 rounded-xl transition" href="farmer_profile.php">
        <span class="material-symbols-outlined">person</span>
        <span>Profile</span>
    </a>
    <a class="flex items-center gap-3 px-4 py-3 text-gray-600 hover:bg-gray-200 rounded-xl transition" href="farmer_inventory.php">
        <span class="material-symbols-outlined">potted_plant</span>
        <span>Inventory</span>
    </a>
    <a class="flex items-center gap-3 px-4 py-3 text-gray-600 hover:bg-gray-200 rounded-xl transition" href="farmer_orders.php">
        <span class="material-symbols-outlined">shopping_cart</span>
        <span>Orders</span>
    </a>
</nav>
        
        <div class="mt-auto pt-6 border-t border-gray-300 space-y-1">
            <a class="flex items-center gap-3 px-4 py-3 text-red-600 hover:bg-red-50 rounded-xl transition font-bold" href="login.php">
                <span class="material-symbols-outlined">logout</span>
                <span>Logout</span>
            </a>
        </div>
    </div>
</aside>

<div class="flex-1 md:ml-64 flex flex-col min-h-screen">
    
    <header class="w-full sticky top-0 z-50 bg-white/80 backdrop-blur-md border-b border-gray-200 h-20">
        <div class="max-w-7xl mx-auto px-8 flex items-center justify-between h-full">
            <h1 class="text-2xl text-primary font-extrabold tracking-tight">FarmDirect+</h1>
            <div class="flex items-center gap-4">
                <button class="p-2 text-gray-600 hover:bg-gray-100 rounded-full transition-all">
                    <span class="material-symbols-outlined">notifications</span>
                </button>
            </div>
        </div>
    </header>

    <main class="flex-1 p-6 md:p-10 max-w-7xl mx-auto w-full">
        
        <div class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <p class="text-primary font-semibold mb-1 uppercase tracking-widest text-[11px]">Producer Portal</p>
                <h2 class="text-4xl font-bold text-gray-900">Welcome back, <?php echo htmlspecialchars($firstName); ?>.</h2>
                <p class="text-gray-500 mt-2 italic font-serif">"The quality of the harvest depends as much on the steward as it does on the soil."</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
            
            <div class="bg-white border border-gray-200 p-6 rounded-2xl shadow-sm hover:shadow-md transition">
                <div class="flex justify-between items-start mb-4">
                    <div class="w-12 h-12 rounded-xl bg-green-100 flex items-center justify-center text-primary">
                        <span class="material-symbols-outlined text-[28px]">inventory_2</span>
                    </div>
                </div>
                <p class="text-gray-500 uppercase tracking-wider text-[12px] mb-1">Total Products Listed</p>
                <h3 class="text-3xl font-bold"><?php echo $total_products; ?></h3>
            </div>

            <div class="bg-white border border-gray-200 p-6 rounded-2xl shadow-sm hover:shadow-md transition">
                <div class="flex justify-between items-start mb-4">
                    <div class="w-12 h-12 rounded-xl bg-orange-100 flex items-center justify-center text-orange-700">
                        <span class="material-symbols-outlined text-[28px]">pending_actions</span>
                    </div>
                </div>
                <p class="text-gray-500 uppercase tracking-wider text-[12px] mb-1">Total Orders</p>
                <h3 class="text-3xl font-bold"><?php echo $total_orders; ?></h3>
            </div>

            <div class="bg-white border border-gray-200 p-6 rounded-2xl shadow-sm hover:shadow-md transition md:col-span-1">
                <p class="text-gray-500 uppercase tracking-wider text-[12px] mb-2">Weekly Sales Trend</p>
                <div class="relative h-32 w-full">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>

        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
            
            <div class="xl:col-span-2 space-y-6">
                <div class="flex items-center justify-between">
                    <h3 class="text-2xl font-bold text-gray-900">Recent Orders</h3>
                </div>
                <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-sm">
                    <table class="w-full border-collapse">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-4 text-left text-gray-500 uppercase tracking-wider text-[11px]">Order ID</th>
                                <th class="px-6 py-4 text-left text-gray-500 uppercase tracking-wider text-[11px]">Date</th>
                                <th class="px-6 py-4 text-left text-gray-500 uppercase tracking-wider text-[11px]">Total</th>
                                <th class="px-6 py-4 text-left text-gray-500 uppercase tracking-wider text-[11px]">Action / Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            
                            <?php
                            if ($orders_result->num_rows > 0) {
                                while($order = $orders_result->fetch_assoc()) {
                                    $statusColor = 'bg-gray-100 text-gray-800';
                                    if($order['status'] == 'Pending') $statusColor = 'bg-orange-100 text-orange-800';
                                    if($order['status'] == 'Shipped') $statusColor = 'bg-green-100 text-green-800';

                                    echo '<tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4 font-bold text-primary">#FD-100'.$order['id'].'</td>
                                        <td class="px-6 py-4 text-gray-600">'.date('M d, Y', strtotime($order['created_at'])).'</td>
                                        <td class="px-6 py-4 font-semibold">$'.$order['total_price'].'</td>
                                        <td class="px-6 py-4">
                                            <form method="POST" class="flex items-center gap-2">
                                                <input type="hidden" name="order_id" value="'.$order['id'].'">
                                                <select name="status" class="text-sm border-gray-300 rounded-lg focus:ring-primary focus:border-primary py-1 px-2 '.$statusColor.'">
                                                    <option value="'.$order['status'].'" selected>'.$order['status'].'</option>
                                                    <option value="Pending">Pending</option>
                                                    <option value="Processing">Processing</option>
                                                    <option value="Shipped">Shipped</option>
                                                    <option value="Delivered">Delivered</option>
                                                </select>
                                                <button type="submit" name="update_order_status" class="text-xs bg-primary text-white px-3 py-1.5 rounded hover:bg-green-800 transition">Save</button>
                                            </form>
                                        </td>
                                    </tr>';
                                }
                            } else {
                                echo '<tr><td colspan="4" class="px-6 py-8 text-center text-gray-500">No orders yet.</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="space-y-6">
                <div class="flex items-center justify-between">
                    <h3 class="text-2xl font-bold text-gray-900">Live Stock</h3>
                </div>

                <div class="bg-green-50 border border-green-200 rounded-2xl p-5 mb-4 shadow-sm">
                    <h4 class="font-bold text-primary mb-3"><span class="material-symbols-outlined align-middle mr-1 text-[18px]">add_circle</span> Add New Harvest</h4>
                    <form method="POST" class="space-y-3">
                        <input type="text" name="product_name" placeholder="Product Name (e.g., Carrots)" required class="w-full text-sm rounded-lg border-gray-300 focus:ring-primary py-2 px-3">
                        <input type="number" step="0.01" name="product_price" placeholder="Price per unit ($)" required class="w-full text-sm rounded-lg border-gray-300 focus:ring-primary py-2 px-3">
                        <button type="submit" name="add_product" class="w-full bg-primary text-white font-bold rounded-lg py-2 hover:bg-green-800 transition shadow-md">Publish Product</button>
                    </form>
                </div>

                <div class="bg-white border border-gray-200 rounded-2xl p-4 space-y-4 shadow-sm h-96 overflow-y-auto">
                    
                    <?php
                    if ($products_result->num_rows > 0) {
                        while($prod = $products_result->fetch_assoc()) {
                            echo '
                            <div class="p-4 border border-gray-100 rounded-xl hover:border-primary/30 transition bg-gray-50 group">
                                <div class="flex justify-between items-start mb-2">
                                    <h4 class="font-bold text-gray-900 text-lg">'.$prod['name'].'</h4>
                                    <span class="text-primary font-bold bg-green-100 px-2 py-1 rounded text-sm">$'.$prod['price'].'</span>
                                </div>
                                <div class="flex justify-between items-center mt-4 border-t border-gray-200 pt-3">
                                    <span class="text-xs text-gray-500">ID: '.$prod['id'].'</span>
                                    
                                    <form method="POST" onsubmit="return confirm(\'Are you sure you want to delete this product?\');">
                                        <input type="hidden" name="product_id" value="'.$prod['id'].'">
                                        <button type="submit" name="delete_product" class="text-red-500 hover:text-white hover:bg-red-500 border border-red-500 text-xs px-3 py-1 rounded transition font-bold flex items-center gap-1">
                                            <span class="material-symbols-outlined text-[14px]">delete</span> Delete
                                        </button>
                                    </form>
                                </div>
                            </div>';
                        }
                    } else {
                        echo '<p class="text-center text-gray-500 py-10">You have no products listed.<br>Use the form above to add some!</p>';
                    }
                    ?>
                </div>
            </div>

        </div>
    </main>
</div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('salesChart').getContext('2d');
        
        // This is sample data. You can replace this array with PHP data later!
        const chartData = [120, 190, 150, 220, 180, 250, 310]; 

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                datasets: [{
                    label: 'Sales ($)',
                    data: chartData,
                    borderColor: '#154212', // Primary Green
                    backgroundColor: 'rgba(21, 66, 18, 0.1)',
                    borderWidth: 2,
                    pointBackgroundColor: '#aef67b',
                    pointBorderColor: '#154212',
                    fill: true,
                    tension: 0.4 // Makes the line curved
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    x: { display: false }, // Hide grid lines for cleaner look
                    y: { display: false }
                }
            }
        });
    });
</script>

</body>
</html>