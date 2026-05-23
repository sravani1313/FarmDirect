<?php
session_start();
require 'db.php'; 

// --- PROCESS ORDER ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Kick out unauthenticated users trying to post
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
    }

    $user_id = $_SESSION['user_id']; 
    $total = 0;
    $items_summary = "";

    if (!empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $item_id) {
            $clean_id = intval($item_id);
            $res = $conn->query("SELECT name, price FROM products WHERE id = $clean_id");
            if ($res && $row = $res->fetch_assoc()) {
                $total += $row['price'];
                $items_summary .= $row['name'] . ", ";
            }
        }
    }

    $shipping = 5.00;
    $tax = $total * 0.08;
    $grandTotal = $total + $shipping + $tax;

    // Save order
    $stmt = $conn->prepare("INSERT INTO orders (user_id, total_price, status, items_summary, created_at) VALUES (?, ?, 'Pending', ?, NOW())");
    $stmt->bind_param("ids", $user_id, $grandTotal, $items_summary);
    $stmt->execute();

    // Clear cart
    unset($_SESSION['cart']); 
    
    // --- DYNAMIC ROUTING LOGIC ---
    if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1) {
        echo "<script>alert('Order placed successfully!'); window.location.href='admin_dashboard.php';</script>";
    } elseif (isset($_SESSION['is_farmer']) && $_SESSION['is_farmer'] == 1) {
        echo "<script>alert('Order placed successfully!'); window.location.href='farmer_dashboard.php';</script>";
    } else {
        // Regular User Dashboard
        echo "<script>alert('Order placed successfully!'); window.location.href='account.php';</script>";
    }
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout | FarmDirect+</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root { --primary-green: #2e7d32; --light-green: #e8f5e9; --accent-orange: #f57c00; --text-dark: #333333; --text-light: #777777; --white: #ffffff; --bg-gray: #f4f7f6; }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { background-color: var(--bg-gray); color: var(--text-dark); line-height: 1.5; }
        
        header { background-color: var(--white); box-shadow: 0 2px 10px rgba(0,0,0,0.05); position: sticky; top: 0; z-index: 100; }
        .nav-container { max-width: 1200px; margin: 0 auto; padding: 15px 20px; display: flex; justify-content: space-between; align-items: center; }
        .logo { font-size: 24px; font-weight: 800; color: var(--primary-green); text-decoration: none; display: flex; align-items: center; gap: 8px; }
        .logo span { color: var(--accent-orange); }
        .btn-return { text-decoration: none; color: var(--primary-green); font-weight: bold; padding: 8px 16px; border: 2px solid var(--primary-green); border-radius: 6px; transition: all 0.3s; font-size: 0.9rem; }
        .btn-return:hover { background: var(--light-green); }
        
        .checkout-container { max-width: 1100px; margin: 40px auto; padding: 0 20px; display: grid; grid-template-columns: 1.8fr 1.2fr; gap: 30px; }
        
        .left-col { display: flex; flex-direction: column; gap: 25px; }
        .form-section { background: var(--white); padding: 25px 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); border: 1px solid #eaeaea; }
        .form-section h2 { margin-bottom: 20px; color: var(--primary-green); font-size: 1.3rem; display: flex; align-items: center; gap: 10px; border-bottom: 2px solid var(--light-green); padding-bottom: 10px; }
        
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px; }
        .form-group { display: flex; flex-direction: column; gap: 6px; }
        .form-group.full-width { grid-column: span 2; margin-bottom: 15px; }
        
        label { font-weight: 600; color: #444; font-size: 0.9rem; }
        input { padding: 12px 15px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 0.95rem; outline: none; transition: all 0.2s; }
        input:focus { border-color: var(--primary-green); box-shadow: 0 0 0 3px var(--light-green); }
        
        .payment-methods { display: flex; gap: 15px; margin-bottom: 20px; }
        .payment-card { flex: 1; border: 2px solid #e5e7eb; border-radius: 8px; padding: 15px; text-align: center; cursor: pointer; transition: all 0.2s; background: #fff; }
        .payment-card i { font-size: 1.8rem; color: #9ca3af; margin-bottom: 8px; display: block; }
        .payment-card p { font-weight: 600; font-size: 0.9rem; color: #4b5563; }
        .payment-card.active { border-color: var(--primary-green); background-color: #f0fdf4; }
        .payment-card.active i, .payment-card.active p { color: var(--primary-green); }

        .order-summary { background: var(--white); padding: 30px; border-radius: 12px; height: fit-content; position: sticky; top: 90px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); border: 1px solid #eaeaea; }
        .order-summary h3 { margin-bottom: 20px; color: var(--primary-green); font-size: 1.3rem; border-bottom: 2px solid var(--light-green); padding-bottom: 10px; }
        .summary-item { display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; padding-bottom: 12px; border-bottom: 1px solid #f3f4f6; }
        .summary-title { font-weight: 600; font-size: 0.9rem; color: #374151; }
        .summary-price { font-weight: bold; color: var(--primary-green); }
        
        .totals-row { display: flex; justify-content: space-between; margin-bottom: 12px; color: #6b7280; font-size: 0.95rem; }
        .totals-row.grand-total { margin-top: 15px; padding-top: 15px; border-top: 2px dashed #d1d5db; font-weight: 800; font-size: 1.4rem; color: var(--primary-green); }
        
        .place-order-btn { width: 100%; padding: 16px; background: var(--primary-green); color: white; border: none; border-radius: 8px; font-size: 1.1rem; font-weight: bold; margin-top: 25px; cursor: pointer; transition: all 0.2s; display: flex; justify-content: center; align-items: center; gap: 10px; }
        .place-order-btn:hover { background: #1b5e20; transform: translateY(-2px); box-shadow: 0 8px 15px rgba(46, 125, 50, 0.2); }
        
        .empty-cart-msg { padding: 20px; background: #fee2e2; color: #991b1b; border-radius: 8px; margin-bottom: 20px; text-align: center; font-weight: bold; border: 1px solid #f87171; }

        @media (max-width: 900px) { .checkout-container { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
    <header>
        <div class="nav-container">
            <a href="shop.php" class="logo"><i class="fas fa-leaf"></i> FarmDirect<span>+</span></a>
            <a href="cart.php" class="btn-return"><i class="fas fa-arrow-left"></i> Return to Cart</a>
        </div>
    </header>

    <form action="checkout.php" method="POST">
        <div class="checkout-container">
            
            <div class="left-col">
                <div class="form-section">
                    <h2><i class="fas fa-truck"></i> 1. Shipping Details</h2>
                    <div class="form-row">
                        <div class="form-group"><label>First Name</label><input type="text" name="first_name" placeholder="John" required></div>
                        <div class="form-group"><label>Last Name</label><input type="text" name="last_name" placeholder="Doe" required></div>
                    </div>
                    <div class="form-group full-width">
                        <label>Street Address</label>
                        <input type="text" name="address" placeholder="123 Farmville Lane" required>
                    </div>
                    <div class="form-row">
                        <div class="form-group"><label>City</label><input type="text" name="city" placeholder="Agritown" required></div>
                        <div class="form-group"><label>Zip Code</label><input type="text" name="zip" placeholder="12345" required></div>
                    </div>
                </div>

                <div class="form-section">
                    <h2><i class="fas fa-wallet"></i> 2. Payment Method</h2>
                    <div class="payment-methods">
                        <div class="payment-card active" onclick="selectPayment(this, 'credit')">
                            <i class="fas fa-credit-card"></i><p>Credit Card</p>
                            <input type="radio" name="payment_method" value="credit_card" checked style="display:none;">
                        </div>
                        <div class="payment-card" onclick="selectPayment(this, 'paypal')">
                            <i class="fab fa-cc-paypal"></i><p>PayPal</p>
                            <input type="radio" name="payment_method" value="paypal" style="display:none;">
                        </div>
                        <div class="payment-card" onclick="selectPayment(this, 'cod')">
                            <i class="fas fa-money-bill-wave"></i><p>COD</p>
                            <input type="radio" name="payment_method" value="cod" style="display:none;">
                        </div>
                    </div>
                    
                    <div id="credit-card-info">
                        <div class="form-group full-width">
                            <label>Card Number</label>
                            <input type="text" placeholder="0000 0000 0000 0000" maxlength="19">
                        </div>
                        <div class="form-row" style="margin-bottom:0;">
                            <div class="form-group"><label>Expiry Date</label><input type="text" placeholder="MM/YY"></div>
                            <div class="form-group"><label>CVC</label><input type="text" placeholder="123"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="order-summary">
                <h3>Your Order</h3>
                
                <?php
                $subtotal = 0;
                
                if (empty($_SESSION['cart'])) {
                    echo '<div class="empty-cart-msg"><i class="fas fa-exclamation-triangle"></i> Your cart is currently empty!</div>';
                } else {
                    foreach ($_SESSION['cart'] as $item_id) {
                        $clean_id = intval($item_id);
                        $result = $conn->query("SELECT * FROM products WHERE id = $clean_id");
                        
                        if ($result && $row = $result->fetch_assoc()) {
                            $subtotal += $row['price'];
                            echo '
                            <div class="summary-item">
                                <div class="summary-title">'.$row['name'].'</div>
                                <div class="summary-price">$'.number_format($row['price'], 2).'</div>
                            </div>';
                        }
                    }
                }
                
                $shipping = ($subtotal > 0) ? 5.00 : 0.00;
                $tax = $subtotal * 0.08;
                $grandTotal = $subtotal + $shipping + $tax;
                ?>

                <div class="totals-row" style="margin-top: 20px;">
                    <span>Subtotal</span>
                    <span style="font-weight: bold; color: var(--text-dark);">$<?php echo number_format($subtotal, 2); ?></span>
                </div>
                <div class="totals-row">
                    <span>Shipping</span>
                    <span style="font-weight: bold; color: var(--text-dark);">$<?php echo number_format($shipping, 2); ?></span>
                </div>
                <div class="totals-row">
                    <span>Tax (8%)</span>
                    <span style="font-weight: bold; color: var(--text-dark);">$<?php echo number_format($tax, 2); ?></span>
                </div>
                
                <div class="totals-row grand-total">
                    <span>Total</span>
                    <span>$<?php echo number_format($grandTotal, 2); ?></span>
                </div>
                
                <button type="submit" class="place-order-btn" <?php echo empty($_SESSION['cart']) ? 'disabled style="background:#ccc; cursor:not-allowed;"' : ''; ?>>
                    Place Order & Pay <i class="fas fa-lock"></i>
                </button>
            </div>
        </div>
    </form>

    <script>
        function selectPayment(cardElement, type) {
            document.querySelectorAll('.payment-card').forEach(card => card.classList.remove('active'));
            cardElement.classList.add('active');
            
            const radio = cardElement.querySelector('input[type="radio"]');
            if(radio) radio.checked = true;

            const ccInfo = document.getElementById('credit-card-info');
            if (type === 'credit') {
                ccInfo.style.display = 'block';
            } else {
                ccInfo.style.display = 'none';
            }
        }
    </script>
</body>
</html>