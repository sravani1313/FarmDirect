<?php
session_start();
require 'db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Basket | FarmDirect+</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root { --primary-green: #2e7d32; --light-green: #e8f5e9; --accent-orange: #f57c00; --text-dark: #333333; --text-light: #777777; --white: #ffffff; --bg-gray: #f4f7f6; }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { background-color: var(--bg-gray); color: var(--text-dark); }
        
        /* Navigation */
        header { background-color: var(--white); box-shadow: 0 2px 10px rgba(0,0,0,0.05); position: sticky; top: 0; z-index: 100; }
        .nav-container { max-width: 1200px; margin: 0 auto; padding: 15px 20px; display: flex; justify-content: space-between; align-items: center; }
        .logo { font-size: 24px; font-weight: 800; color: var(--primary-green); text-decoration: none; display: flex; align-items: center; gap: 8px; }
        .logo span { color: var(--accent-orange); }
        .nav-links { display: flex; gap: 30px; list-style: none; }
        .nav-links a { text-decoration: none; color: var(--text-dark); font-weight: 600; transition: color 0.3s; }
        .nav-links a:hover { color: var(--primary-green); }
        .nav-icons { display: flex; gap: 20px; font-size: 20px; align-items: center; }
        .nav-icons a { color: var(--text-dark); text-decoration: none; transition: color 0.3s; }
        .nav-icons a:hover { color: var(--primary-green); }
        .cart-icon { position: relative; color: var(--primary-green); cursor: pointer; }
        .cart-count { position: absolute; top: -8px; right: -10px; background-color: var(--accent-orange); color: white; font-size: 11px; padding: 2px 6px; border-radius: 50%; font-weight: bold; }
        
        /* Page Header */
        .page-header { background: linear-gradient(rgba(46, 125, 50, 0.9), rgba(27, 94, 32, 0.9)), url('https://images.unsplash.com/photo-1500937386664-56d1dfef3854?auto=format&fit=crop&w=2000&q=80') center/cover; padding: 60px 20px; text-align: center; color: white; }
        .page-header h1 { font-size: 2.5rem; text-shadow: 0 2px 4px rgba(0,0,0,0.3); }

        /* Cart Layout */
        .cart-container { max-width: 1100px; margin: 40px auto; padding: 0 20px; display: grid; grid-template-columns: 2fr 1fr; gap: 30px; }
        .cart-items-section { background: var(--white); padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); border: 1px solid #eaeaea; }
        .cart-item { display: flex; align-items: center; border-bottom: 1px solid #f3f4f6; padding: 20px 0; }
        .cart-item:last-child { border-bottom: none; }
        
        /* Removed image classes and adjusted layout */
        .item-details { flex-grow: 1; }
        .item-title { font-weight: bold; font-size: 1.1rem; color: var(--text-dark); margin-bottom: 5px; }
        .item-price { color: var(--text-light); font-weight: 600; font-size: 0.95rem; }
        .item-total { font-weight: 800; font-size: 1.2rem; color: var(--primary-green); }
        
        /* Summary Box */
        .summary-box { background: var(--white); padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); border: 1px solid #eaeaea; height: fit-content; position: sticky; top: 100px; }
        .summary-box h3 { margin-bottom: 20px; border-bottom: 2px solid var(--light-green); padding-bottom: 10px; color: var(--primary-green); font-size: 1.3rem; }
        .summary-row { display: flex; justify-content: space-between; margin-bottom: 15px; font-size: 1.1rem; font-weight: bold; color: var(--text-dark); }
        
        /* Buttons */
        .checkout-btn { display: flex; justify-content: center; align-items: center; gap: 10px; width: 100%; background: var(--primary-green); color: white; text-decoration: none; padding: 15px; border-radius: 8px; font-size: 1.1rem; font-weight: bold; margin-top: 20px; transition: all 0.2s; }
        .checkout-btn:hover { background: #1b5e20; transform: translateY(-2px); box-shadow: 0 4px 10px rgba(46, 125, 50, 0.2); }
        .continue-btn { display: flex; justify-content: center; align-items: center; gap: 10px; width: 100%; background: var(--light-green); color: var(--primary-green); text-decoration: none; padding: 15px; border-radius: 8px; font-size: 1rem; font-weight: bold; margin-top: 15px; transition: all 0.2s; }
        .continue-btn:hover { background: #c8e6c9; }
        
        .empty-cart { text-align: center; padding: 50px 20px; }
        .empty-cart h2 { color: var(--text-dark); margin-bottom: 10px; }
        .empty-cart p { color: var(--text-light); }

        @media (max-width: 800px) { .cart-container { grid-template-columns: 1fr; } }
    </style>
</head>
<body>

    <header>
        <div class="nav-container">
            <a href="shop.php" class="logo"><i class="fas fa-leaf"></i> FarmDirect<span>+</span></a>
            
            <div class="nav-icons">
                <a href="account.php" title="Login / Register"><i class="fas fa-user"></i></a>
                <div class="cart-icon">
                    <i class="fas fa-shopping-basket"></i>
                    <span class="cart-count"><?php echo isset($_SESSION['cart']) ? count($_SESSION['cart']) : '0'; ?></span>
                </div>
            </div>
        </div>
    </header>

    <div class="page-header">
        <h1>Your Fresh Basket</h1>
    </div>

    <div class="cart-container">
        <div class="cart-items-section">
            <?php
            $cart_total = 0; 

            if (empty($_SESSION['cart'])) {
                echo "
                <div class='empty-cart'>
                    <i class='fas fa-shopping-basket' style='font-size: 4rem; color: #d1d5db; margin-bottom: 20px;'></i>
                    <h2>Your cart is currently empty.</h2>
                    <p>Looks like you haven't added any farm-fresh goodness yet!</p>
                </div>";
            } else {
                foreach ($_SESSION['cart'] as $item_id) {
                    $clean_id = intval($item_id);
                    $result = $conn->query("SELECT * FROM products WHERE id = $clean_id");
                    
                    if ($result && $row = $result->fetch_assoc()) {
                        $cart_total += $row['price']; 

                        echo '
                        <div class="cart-item">
                            <div class="item-details">
                                <div class="item-title">'.$row['name'].'</div>
                                <div class="item-price">$'.number_format($row['price'], 2).'</div>
                            </div>
                            <div class="item-total">$'.number_format($row['price'], 2).'</div>
                        </div>';
                    }
                } 
            } 
            ?>
        </div>

        <div class="summary-box">
            <h3>Cart Summary</h3>
            <div class="summary-row">
                <span>Subtotal:</span>
                <span>$<?php echo number_format($cart_total, 2); ?></span>
            </div>
            <p style="color: var(--text-light); font-size: 0.9rem; margin-bottom: 20px;">Shipping and taxes will be calculated at checkout.</p>
            
            <?php if (!empty($_SESSION['cart'])): ?>
                <a href="checkout.php" class="checkout-btn">Proceed to Checkout <i class="fas fa-arrow-right"></i></a>
            <?php else: ?>
                <button class="checkout-btn" style="background:#cbd5e1; color:#94a3b8; cursor:not-allowed;" disabled>Proceed to Checkout</button>
            <?php endif; ?>
            
            <a href="shop.php" class="continue-btn"><i class="fas fa-undo-alt"></i> Continue Shopping</a>
        </div>
    </div> 
</body>
</html>