<?php
session_start();
require 'db.php';

if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header("Location: login.php");
    exit();
}

$query = "SELECT * FROM users ORDER BY created_at DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>All Customers | FarmDirect+</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-slate-100 min-h-screen p-8">
    
    
    <div class="max-w-6xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-slate-800"><i class="fas fa-users mr-2"></i>All Customers</h1>
            <a href="admin_dashboard.php" class="text-slate-600 hover:text-slate-900 font-medium">
                <i class="fas fa-arrow-left mr-2"></i>Back to Dashboard
            </a>
        </div>

        <?php if (isset($_GET['msg']) && $_GET['msg'] == 'deleted'): ?>
            <div class="bg-emerald-100 text-emerald-700 px-4 py-3 rounded-lg mb-6 shadow-sm border border-emerald-200">
                <i class="fas fa-check-circle mr-2"></i> User successfully removed.
            </div>
        <?php endif; ?>
        
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr class="text-slate-400">
                        <th class="p-4 text-left font-bold uppercase tracking-wider">ID</th>
                        <th class="p-4 text-left font-bold uppercase tracking-wider">Name</th>
                        <th class="p-4 text-left font-bold uppercase tracking-wider">Email</th>
                        <th class="p-4 text-left font-bold uppercase tracking-wider">Joined</th>
                        <th class="p-4 text-center font-bold uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php while($row = $result->fetch_assoc()): ?>
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="p-4 font-semibold text-slate-700">#<?php echo $row['id']; ?></td>
                        <td class="p-4 text-slate-700 font-medium"><?php echo htmlspecialchars($row['full_name']); ?></td>
                        <td class="p-4 text-slate-500"><?php echo htmlspecialchars($row['email']); ?></td>
                        <td class="p-4 text-slate-500"><?php echo date('M d, Y', strtotime($row['created_at'])); ?></td>
                        <td class="p-4 text-center">
                            <a href="delete_user.php?id=<?php echo $row['id']; ?>" 
                               onclick="return confirm('Are you sure you want to remove this user?');"
                               class="inline-block text-red-500 hover:text-white hover:bg-red-500 px-3 py-1.5 rounded-lg transition-all border border-red-200">
                                <i class="fas fa-trash-alt mr-1"></i> Remove
                            </a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>