<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['is_farmer'] != 1) {
    header("Location: login.php");
    exit();
}

$farmer_id = $_SESSION['user_id'];

// Handle Adding a Product
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_product'])) {
    $name = $conn->real_escape_string($_POST['product_name']);
    $price = floatval($_POST['product_price']);
    $image = 'default.jpg'; 
    $sql = "INSERT INTO products (name, price, image, farmer_id) VALUES ('$name', $price, '$image', $farmer_id)";
    $conn->query($sql);
    header("Location: farmer_inventory.php");
    exit();
}

// Handle Deleting a Product
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_product'])) {
    $prod_id = intval($_POST['product_id']);
    $sql = "DELETE FROM products WHERE id = $prod_id AND farmer_id = $farmer_id";
    $conn->query($sql);
    header("Location: farmer_inventory.php");
    exit();
}

// Fetch Inventory
$products_result = $conn->query("SELECT * FROM products WHERE farmer_id = $farmer_id ORDER BY id DESC");
?>

<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8"/>
    <title>Inventory | FarmDirect+</title>
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
                <a class="flex items-center gap-3 px-4 py-3 bg-[#aef67b]/20 text-[#326b00] rounded-xl font-bold" href="farmer_inventory.php">
                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">potted_plant</span><span>Inventory</span>
                </a>
                <a class="flex items-center gap-3 px-4 py-3 text-gray-600 hover:bg-gray-200 rounded-xl transition" href="farmer_orders.php">
                    <span class="material-symbols-outlined">shopping_cart</span><span>Orders</span>
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
            <h2 class="text-4xl font-bold text-gray-900">Manage Inventory</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="md:col-span-1">
                <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm sticky top-10">
                    <h3 class="text-xl font-bold text-[#154212] mb-4">Add New Product</h3>
                    <form method="POST" class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Product Name</label>
                            <input type="text" name="product_name" required class="w-full rounded-lg border-gray-300 focus:ring-[#154212] py-2 px-3 bg-gray-50">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Price ($)</label>
                            <input type="number" step="0.01" name="product_price" required class="w-full rounded-lg border-gray-300 focus:ring-[#154212] py-2 px-3 bg-gray-50">
                        </div>
                        <button type="submit" name="add_product" class="w-full bg-[#154212] text-white font-bold rounded-lg py-3 hover:bg-green-800 transition">Publish to Store</button>
                    </form>
                </div>
            </div>

            <div class="md:col-span-2">
                <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-sm">
                    <table class="w-full border-collapse">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-4 text-left text-gray-500 uppercase tracking-wider text-xs">ID</th>
                                <th class="px-6 py-4 text-left text-gray-500 uppercase tracking-wider text-xs">Product</th>
                                <th class="px-6 py-4 text-left text-gray-500 uppercase tracking-wider text-xs">Price</th>
                                <th class="px-6 py-4 text-right text-gray-500 uppercase tracking-wider text-xs">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <?php
                            if ($products_result->num_rows > 0) {
                                while($prod = $products_result->fetch_assoc()) {
                                    echo '<tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 text-sm text-gray-500">#'.$prod['id'].'</td>
                                        <td class="px-6 py-4 font-bold text-gray-900">'.$prod['name'].'</td>
                                        <td class="px-6 py-4 font-semibold text-[#154212]">$'.$prod['price'].'</td>
                                        <td class="px-6 py-4 text-right">
                                            <form method="POST" onsubmit="return confirm(\'Delete this product?\');">
                                                <input type="hidden" name="product_id" value="'.$prod['id'].'">
                                                <button type="submit" name="delete_product" class="text-red-500 hover:text-white hover:bg-red-500 border border-red-500 text-xs px-3 py-1.5 rounded transition font-bold">Delete</button>
                                            </form>
                                        </td>
                                    </tr>';
                                }
                            } else {
                                echo '<tr><td colspan="4" class="px-6 py-8 text-center text-gray-500">No products found.</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</div>
</body>
</html>