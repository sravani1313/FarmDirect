<?php
session_start();
require 'db.php';
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit(); }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>My Account | FarmDirect+</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .active-link { background: #e8f5e9; color: #2e7d32; border-left: 4px solid #2e7d32; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="max-w-6xl mx-auto py-10 px-4 grid grid-cols-1 md:grid-cols-4 gap-8">
        <aside class="col-span-1 bg-white p-6 rounded-2xl shadow-sm h-fit">
            <nav class="space-y-2">
                <a href="account.php" class="block py-3 px-4 rounded-lg hover:bg-gray-50 <?php echo (basename($_SERVER['PHP_SELF']) == 'account.php') ? 'active-link' : ''; ?>"><i class="fas fa-box mr-3"></i> Order History</a>
                <a href="addresses.php" class="block py-3 px-4 rounded-lg hover:bg-gray-50 <?php echo (basename($_SERVER['PHP_SELF']) == 'addresses.php') ? 'active-link' : ''; ?>"><i class="fas fa-map-marker-alt mr-3"></i> Addresses</a>
                <a href="payments.php" class="block py-3 px-4 rounded-lg hover:bg-gray-50 <?php echo (basename($_SERVER['PHP_SELF']) == 'payments.php') ? 'active-link' : ''; ?>"><i class="fas fa-credit-card mr-3"></i> Payments</a>
                <a href="settings.php" class="block py-3 px-4 rounded-lg hover:bg-gray-50 <?php echo (basename($_SERVER['PHP_SELF']) == 'settings.php') ? 'active-link' : ''; ?>"><i class="fas fa-cog mr-3"></i> Settings</a>
            </nav>
        </aside>

        <main class="col-span-3 bg-white p-8 rounded-2xl shadow-sm">
            <?php echo $content; ?>
        </main>
    </div>
</body>
</html>