<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop | FarmDirect+</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-green: #2e7d32;
            --primary-hover: #1b5e20;
            --light-green: #e8f5e9;
            --accent-orange: #f57c00;
            --text-dark: #2c3e50;
            --text-light: #7f8c8d;
            --white: #ffffff;
            --bg-gray: #f8f9fa;
            --border-color: #eaecef;
        }
        
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        html { scroll-behavior: smooth; }
        body { background-color: var(--bg-gray); color: var(--text-dark); line-height: 1.6; overflow-x: hidden; }
        
        /* Animation Classes */
        .hidden-element { opacity: 0; transform: translateY(30px); transition: all 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94); }
        .show-element { opacity: 1; transform: translateY(0); }
        .delay-1 { transition-delay: 0.1s; } 
        .delay-2 { transition-delay: 0.2s; } 
        .delay-3 { transition-delay: 0.3s; }
        .delay-4 { transition-delay: 0.4s; }
        .delay-5 { transition-delay: 0.5s; }
        
        /* Navigation */
        header { background-color: var(--white); box-shadow: 0 4px 20px rgba(0,0,0,0.05); position: sticky; top: 0; z-index: 100; transition: padding 0.3s ease; }
        .nav-container { max-width: 1200px; margin: 0 auto; padding: 15px 20px; display: flex; justify-content: space-between; align-items: center; }
        .logo { font-size: 26px; font-weight: 800; color: var(--primary-green); text-decoration: none; display: flex; align-items: center; gap: 10px; transition: transform 0.3s ease; }
        .logo:hover { transform: scale(1.02); }
        .logo span { color: var(--accent-orange); }
        .nav-links { display: flex; gap: 30px; list-style: none; }
        .nav-links a { text-decoration: none; color: var(--text-dark); font-weight: 600; position: relative; padding-bottom: 5px; transition: color 0.3s; }
        .nav-links a::after { content: ''; position: absolute; width: 0; height: 2px; display: block; margin-top: 5px; right: 0; background: var(--primary-green); transition: width 0.3s ease; }
        .nav-links a:hover::after { width: 100%; left: 0; background: var(--primary-green); }
        .nav-links a:hover { color: var(--primary-green); }
        .nav-icons { display: flex; gap: 25px; font-size: 20px; color: var(--text-dark); cursor: pointer; }
        .nav-icons i { transition: transform 0.3s ease, color 0.3s ease; }
        .nav-icons i:hover { color: var(--primary-green); transform: translateY(-2px); }
        
        /* Page Header */
        .page-header { 
            background: linear-gradient(rgba(46, 125, 50, 0.8), rgba(27, 94, 32, 0.8)), url('https://images.unsplash.com/photo-1500937386664-56d1dfef3854?auto=format&fit=crop&w=2000&q=80') center/cover; 
            height: 30vh; display: flex; align-items: center; justify-content: center; color: white; text-align: center; 
        }
        .page-header h1 { font-size: 3rem; font-weight: 800; letter-spacing: 1px; animation: fadeDown 0.8s ease-out; }
        @keyframes fadeDown { from { opacity: 0; transform: translateY(-20px); } to { opacity: 1; transform: translateY(0); } }
        
        /* Shop Layout */
        .shop-container { max-width: 1200px; margin: 50px auto; padding: 0 20px; display: flex; gap: 40px; }
        
        /* Sidebar */
        .sidebar { width: 280px; flex-shrink: 0; }
        .filter-group { margin-bottom: 30px; background: var(--white); padding: 25px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); border: 1px solid var(--border-color); }
        .filter-group h3 { margin-bottom: 20px; color: var(--text-dark); font-size: 1.1rem; font-weight: 700; display: flex; align-items: center; gap: 10px; }
        .filter-group label { display: flex; align-items: center; margin-bottom: 15px; cursor: pointer; color: var(--text-light); transition: color 0.2s; font-weight: 500; }
        .filter-group label:hover { color: var(--primary-green); }
        .filter-group input[type="checkbox"] { margin-right: 12px; width: 18px; height: 18px; accent-color: var(--primary-green); cursor: pointer; }
        
        /* Product Grid */
        .product-grid { flex-grow: 1; display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 30px; }
        
        /* Product Cards */
        .product-card { 
            background: var(--white); border-radius: 12px; overflow: hidden; position: relative;
            border: 1px solid var(--border-color); transition: all 0.3s ease; display: flex; flex-direction: column;
        }
        .product-card:hover { box-shadow: 0 12px 30px rgba(0,0,0,0.08); transform: translateY(-5px); border-color: var(--light-green); }
        
        /* Badges */
        .badge { position: absolute; top: 15px; left: 15px; padding: 5px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; z-index: 10; letter-spacing: 0.5px; }
        .badge.organic { background-color: var(--primary-green); color: white; }
        .badge.bestseller { background-color: var(--accent-orange); color: white; }
        .badge.sale { background-color: #e74c3c; color: white; }
        
        .product-img-container { overflow: hidden; width: 100%; height: 220px; position: relative; background: #f4f4f4; }
        .product-img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease; }
        .product-card:hover .product-img { transform: scale(1.08); }
        
        .product-info { padding: 20px; display: flex; flex-direction: column; flex-grow: 1; }
        .product-category { font-size: 0.8rem; color: var(--text-light); text-transform: uppercase; font-weight: 600; margin-bottom: 5px; }
        .product-title { font-size: 1.1rem; font-weight: 700; margin-bottom: 8px; color: var(--text-dark); line-height: 1.3; }
        
        /* Ratings */
        .product-rating { color: #f1c40f; font-size: 0.85rem; margin-bottom: 12px; }
        .product-rating span { color: var(--text-light); font-size: 0.8rem; margin-left: 5px; }
        
        .product-bottom { display: flex; justify-content: space-between; align-items: center; margin-top: auto; padding-top: 15px; }
        .product-price { font-weight: 800; color: var(--primary-green); font-size: 1.25rem; }
        
        /* Button */
        .add-to-cart { 
            width: 40px; height: 40px; border-radius: 50%; border: none; background: var(--light-green); 
            color: var(--primary-green); font-size: 1.1rem; cursor: pointer; transition: all 0.3s ease; 
            display: flex; justify-content: center; align-items: center;
        }
        .add-to-cart:hover { background: var(--primary-green); color: var(--white); transform: scale(1.1); }
        
        /* Footer */
        footer { background-color: #1a1a1a; color: #ddd; padding: 60px 20px 20px; margin-top: 80px; }
        .footer-content { max-width: 1200px; margin: 0 auto; display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 40px; }
        .footer-section h3 { color: var(--white); margin-bottom: 20px; font-size: 1.2rem; }
        .footer-section ul { list-style: none; }
        .footer-section ul li { margin-bottom: 12px; transition: transform 0.2s ease; }
        .footer-section ul li:hover { transform: translateX(5px); }
        .footer-section a { color: #aaa; text-decoration: none; transition: color 0.2s ease; }
        .footer-section a:hover { color: var(--primary-green); }
        .footer-bottom { text-align: center; padding-top: 20px; margin-top: 40px; border-top: 1px solid #333; color: #777; font-size: 0.9rem; }
        
        @media (max-width: 850px) { .shop-container { flex-direction: column; } .sidebar { width: 100%; } }
    </style>
</head>
<body>
    <header>
        <div class="nav-container">
            <a href="home.html" class="logo">
                <i class="fas fa-leaf"></i> FarmDirect<span>+</span>
            </a>
            
            <div class="nav-icons">
                <a href="account.php" style="color: inherit;"><i class="fas fa-user" title="Login"></i></a>
                <a href="cart.php" style="color: inherit;"><i class="fas fa-shopping-basket" title="Cart"></i></a>
            </div>
        </div>
    </header>

    <div class="page-header">
        <h1>Our Fresh Market</h1>
    </div>

    <div class="shop-container">
        <aside class="sidebar hidden-element">
            <div class="filter-group">
                <h3><i class="fas fa-list-ul"></i> Categories</h3>
                <label><input type="checkbox" checked> All Products</label>
                <label><input type="checkbox"> Fresh Vegetables</label>
                <label><input type="checkbox"> Organic Fruits</label>
                <label><input type="checkbox"> Dairy & Eggs</label>
                <label><input type="checkbox"> Pantry Staples</label>
            </div>
            <div class="filter-group">
                <h3><i class="fas fa-wallet"></i> Price Range</h3>
                <input type="range" min="0" max="50" style="width: 100%; accent-color: var(--primary-green);">
                <div style="display: flex; justify-content: space-between; margin-top: 12px; font-size: 0.9rem; font-weight: 600; color: var(--text-light);">
                    <span>$0</span><span>$50+</span>
                </div>
            </div>
        </aside>
        
        <main class="product-grid">
            
            <div class="product-card hidden-element delay-1">
                <span class="badge organic">Organic</span>
                <div class="product-img-container">
                    <img src="https://images.unsplash.com/photo-1592924357228-91a4daadcfea?w=500" class="product-img" alt="Tomatoes">
                </div>
                <div class="product-info">
                    <p class="product-category">Vegetables</p>
                    <h3 class="product-title">Organic Vine Tomatoes</h3>
                    <div class="product-rating">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i> <span>(24)</span>
                    </div>
                    <div class="product-bottom">
                        <p class="product-price">$4.99 <span style="font-size: 0.8rem; font-weight: normal; color: var(--text-light);">/ lb</span></p>
                        <form action="add_to_cart.php" method="POST">
                            <input type="hidden" name="product_id" value="1"> 
                            <button type="submit" class="add-to-cart" title="Add to Basket"><i class="fas fa-plus"></i></button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="product-card hidden-element delay-2">
                <span class="badge bestseller">Bestseller</span>
                <div class="product-img-container">
                    <img src="https://images.unsplash.com/photo-1587486913049-53fc88980cb6?w=500" class="product-img" alt="Farm Eggs">
                </div>
                <div class="product-info">
                    <p class="product-category">Dairy & Eggs</p>
                    <h3 class="product-title">Pasture-Raised Brown Eggs</h3>
                    <div class="product-rating">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i> <span>(128)</span>
                    </div>
                    <div class="product-bottom">
                        <p class="product-price">$6.50 <span style="font-size: 0.8rem; font-weight: normal; color: var(--text-light);">/ dz</span></p>
                        <form action="add_to_cart.php" method="POST">
                            <input type="hidden" name="product_id" value="2"> 
                            <button type="submit" class="add-to-cart" title="Add to Basket"><i class="fas fa-plus"></i></button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="product-card hidden-element delay-3">
                <div class="product-img-container">
                    <img src="https://images.unsplash.com/photo-1598170845058-32b9d6a5da37?w=500" class="product-img" alt="Carrots">
                </div>
                <div class="product-info">
                    <p class="product-category">Vegetables</p>
                    <h3 class="product-title">Fresh Heirloom Carrots</h3>
                    <div class="product-rating">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i> <span>(12)</span>
                    </div>
                    <div class="product-bottom">
                        <p class="product-price">$3.25 <span style="font-size: 0.8rem; font-weight: normal; color: var(--text-light);">/ bunch</span></p>
                        <form action="add_to_cart.php" method="POST">
                            <input type="hidden" name="product_id" value="3"> 
                            <button type="submit" class="add-to-cart" title="Add to Basket"><i class="fas fa-plus"></i></button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="product-card hidden-element delay-4">
                <span class="badge sale">15% OFF</span>
                <div class="product-img-container">
                    <img src="https://images.unsplash.com/photo-1587049352847-81a56d773c1c?w=500" class="product-img" alt="Raw Honey">
                </div>
                <div class="product-info">
                    <p class="product-category">Pantry Staples</p>
                    <h3 class="product-title">Raw Wildflower Honey</h3>
                    <div class="product-rating">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i> <span>(89)</span>
                    </div>
                    <div class="product-bottom">
                        <p class="product-price">$12.99 <span style="font-size: 0.8rem; font-weight: normal; color: var(--text-light); text-decoration: line-through;">$15.50</span></p>
                        <form action="add_to_cart.php" method="POST">
                            <input type="hidden" name="product_id" value="4"> 
                            <button type="submit" class="add-to-cart" title="Add to Basket"><i class="fas fa-plus"></i></button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="product-card hidden-element delay-5">
                <span class="badge organic">Organic</span>
                <div class="product-img-container">
                    <img src="https://images.unsplash.com/photo-1560806887-1e4cd0b6faa6?w=500" class="product-img" alt="Apples">
                </div>
                <div class="product-info">
                    <p class="product-category">Fruits</p>
                    <h3 class="product-title">Crisp Honeycrisp Apples</h3>
                    <div class="product-rating">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i> <span>(45)</span>
                    </div>
                    <div class="product-bottom">
                        <p class="product-price">$5.50 <span style="font-size: 0.8rem; font-weight: normal; color: var(--text-light);">/ lb</span></p>
                        <form action="add_to_cart.php" method="POST">
                            <input type="hidden" name="product_id" value="5"> 
                            <button type="submit" class="add-to-cart" title="Add to Basket"><i class="fas fa-plus"></i></button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="product-card hidden-element delay-1">
                <span class="badge organic">Organic</span>
                <div class="product-img-container">
                    <img src="https://images.unsplash.com/photo-1464965911861-746a04b4bca6?w=500" class="product-img" alt="Strawberries">
                </div>
                <div class="product-info">
                    <p class="product-category">Fruits</p>
                    <h3 class="product-title">Fresh Field Strawberries</h3>
                    <div class="product-rating">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i> <span>(112)</span>
                    </div>
                    <div class="product-bottom">
                        <p class="product-price">$6.99 <span style="font-size: 0.8rem; font-weight: normal; color: var(--text-light);">/ box</span></p>
                        <form action="add_to_cart.php" method="POST">
                            <input type="hidden" name="product_id" value="6"> 
                            <button type="submit" class="add-to-cart" title="Add to Basket"><i class="fas fa-plus"></i></button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="product-card hidden-element delay-2">
                <div class="product-img-container">
                    <img src="https://images.unsplash.com/photo-1576045057995-568f588f82fb?w=500" class="product-img" alt="Spinach">
                </div>
                <div class="product-info">
                    <p class="product-category">Vegetables</p>
                    <h3 class="product-title">Crisp Baby Spinach</h3>
                    <div class="product-rating">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i> <span>(34)</span>
                    </div>
                    <div class="product-bottom">
                        <p class="product-price">$3.50 <span style="font-size: 0.8rem; font-weight: normal; color: var(--text-light);">/ bag</span></p>
                        <form action="add_to_cart.php" method="POST">
                            <input type="hidden" name="product_id" value="7"> 
                            <button type="submit" class="add-to-cart" title="Add to Basket"><i class="fas fa-plus"></i></button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="product-card hidden-element delay-3">
                <span class="badge bestseller">Bestseller</span>
                <div class="product-img-container">
                    <img src="https://images.unsplash.com/photo-1589367920969-ab8e050bf0ef?w=500" class="product-img" alt="Sourdough Bread">
                </div>
                <div class="product-info">
                    <p class="product-category">Pantry Staples</p>
                    <h3 class="product-title">Artisan Sourdough Bread</h3>
                    <div class="product-rating">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i> <span>(210)</span>
                    </div>
                    <div class="product-bottom">
                        <p class="product-price">$7.00 <span style="font-size: 0.8rem; font-weight: normal; color: var(--text-light);">/ loaf</span></p>
                        <form action="add_to_cart.php" method="POST">
                            <input type="hidden" name="product_id" value="8"> 
                            <button type="submit" class="add-to-cart" title="Add to Basket"><i class="fas fa-plus"></i></button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="product-card hidden-element delay-4">
                <div class="product-img-container">
                    <img src="https://images.unsplash.com/photo-1550583724-b2692b85b150?w=500" class="product-img" alt="Milk">
                </div>
                <div class="product-info">
                    <p class="product-category">Dairy & Eggs</p>
                    <h3 class="product-title">Grass-Fed Whole Milk</h3>
                    <div class="product-rating">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i> <span>(95)</span>
                    </div>
                    <div class="product-bottom">
                        <p class="product-price">$4.50 <span style="font-size: 0.8rem; font-weight: normal; color: var(--text-light);">/ gallon</span></p>
                        <form action="add_to_cart.php" method="POST">
                            <input type="hidden" name="product_id" value="9"> 
                            <button type="submit" class="add-to-cart" title="Add to Basket"><i class="fas fa-plus"></i></button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="product-card hidden-element delay-5">
                <span class="badge sale">20% OFF</span>
                <div class="product-img-container">
                    <img src="https://images.unsplash.com/photo-1596040033229-a9821ebd058d?w=500" class="product-img" alt="Sweet Potatoes">
                </div>
                <div class="product-info">
                    <p class="product-category">Vegetables</p>
                    <h3 class="product-title">Organic Sweet Potatoes</h3>
                    <div class="product-rating">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i> <span>(67)</span>
                    </div>
                    <div class="product-bottom">
                        <p class="product-price">$2.40 <span style="font-size: 0.8rem; font-weight: normal; color: var(--text-light); text-decoration: line-through;">$3.00</span></p>
                        <form action="add_to_cart.php" method="POST">
                            <input type="hidden" name="product_id" value="10"> 
                            <button type="submit" class="add-to-cart" title="Add to Basket"><i class="fas fa-plus"></i></button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="product-card hidden-element delay-1">
                <span class="badge organic">Organic</span>
                <div class="product-img-container">
                    <img src="https://images.unsplash.com/photo-1498557850523-fd3d118b962e?w=500" class="product-img" alt="Blueberries">
                </div>
                <div class="product-info">
                    <p class="product-category">Fruits</p>
                    <h3 class="product-title">Wild Blueberries</h3>
                    <div class="product-rating">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i> <span>(143)</span>
                    </div>
                    <div class="product-bottom">
                        <p class="product-price">$5.99 <span style="font-size: 0.8rem; font-weight: normal; color: var(--text-light);">/ pint</span></p>
                        <form action="add_to_cart.php" method="POST">
                            <input type="hidden" name="product_id" value="11"> 
                            <button type="submit" class="add-to-cart" title="Add to Basket"><i class="fas fa-plus"></i></button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="product-card hidden-element delay-2">
                <div class="product-img-container">
                    <img src="https://images.unsplash.com/photo-1563565375-f3fdfdbefa8a?w=500" class="product-img" alt="Bell Peppers">
                </div>
                <div class="product-info">
                    <p class="product-category">Vegetables</p>
                    <h3 class="product-title">Mixed Bell Peppers</h3>
                    <div class="product-rating">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i> <span>(41)</span>
                    </div>
                    <div class="product-bottom">
                        <p class="product-price">$3.99 <span style="font-size: 0.8rem; font-weight: normal; color: var(--text-light);">/ 3-pack</span></p>
                        <form action="add_to_cart.php" method="POST">
                            <input type="hidden" name="product_id" value="12"> 
                            <button type="submit" class="add-to-cart" title="Add to Basket"><i class="fas fa-plus"></i></button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="product-card hidden-element delay-3">
                <span class="badge bestseller">Bestseller</span>
                <div class="product-img-container">
                    <img src="https://images.unsplash.com/photo-1486297678162-eb2a19b0a32d?w=500" class="product-img" alt="Cheese">
                </div>
                <div class="product-info">
                    <p class="product-category">Dairy & Eggs</p>
                    <h3 class="product-title">Aged Farmhouse Cheddar</h3>
                    <div class="product-rating">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i> <span>(185)</span>
                    </div>
                    <div class="product-bottom">
                        <p class="product-price">$8.50 <span style="font-size: 0.8rem; font-weight: normal; color: var(--text-light);">/ block</span></p>
                        <form action="add_to_cart.php" method="POST">
                            <input type="hidden" name="product_id" value="13"> 
                            <button type="submit" class="add-to-cart" title="Add to Basket"><i class="fas fa-plus"></i></button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="product-card hidden-element delay-4">
                <span class="badge organic">Organic</span>
                <div class="product-img-container">
                    <img src="https://images.unsplash.com/photo-1615486171448-4af40212f434?w=500" class="product-img" alt="Fresh Basil">
                </div>
                <div class="product-info">
                    <p class="product-category">Vegetables</p>
                    <h3 class="product-title">Fresh Basil Bunch</h3>
                    <div class="product-rating">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i> <span>(55)</span>
                    </div>
                    <div class="product-bottom">
                        <p class="product-price">$2.99 <span style="font-size: 0.8rem; font-weight: normal; color: var(--text-light);">/ bunch</span></p>
                        <form action="add_to_cart.php" method="POST">
                            <input type="hidden" name="product_id" value="14"> 
                            <button type="submit" class="add-to-cart" title="Add to Basket"><i class="fas fa-plus"></i></button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="product-card hidden-element delay-5">
                <div class="product-img-container">
                    <img src="https://images.unsplash.com/photo-1474979266404-7eaacbcd87c5?w=500" class="product-img" alt="Olive Oil">
                </div>
                <div class="product-info">
                    <p class="product-category">Pantry Staples</p>
                    <h3 class="product-title">Extra Virgin Olive Oil</h3>
                    <div class="product-rating">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i> <span>(92)</span>
                    </div>
                    <div class="product-bottom">
                        <p class="product-price">$14.99 <span style="font-size: 0.8rem; font-weight: normal; color: var(--text-light);">/ bottle</span></p>
                        <form action="add_to_cart.php" method="POST">
                            <input type="hidden" name="product_id" value="15"> 
                            <button type="submit" class="add-to-cart" title="Add to Basket"><i class="fas fa-plus"></i></button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="product-card hidden-element delay-1">
                <span class="badge organic">Organic</span>
                <div class="product-img-container">
                    <img src="https://images.unsplash.com/photo-1590502593747-42a996133562?w=500" class="product-img" alt="Lemons">
                </div>
                <div class="product-info">
                    <p class="product-category">Fruits</p>
                    <h3 class="product-title">Meyer Lemons</h3>
                    <div class="product-rating">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i> <span>(38)</span>
                    </div>
                    <div class="product-bottom">
                        <p class="product-price">$4.25 <span style="font-size: 0.8rem; font-weight: normal; color: var(--text-light);">/ bag</span></p>
                        <form action="add_to_cart.php" method="POST">
                            <input type="hidden" name="product_id" value="16"> 
                            <button type="submit" class="add-to-cart" title="Add to Basket"><i class="fas fa-plus"></i></button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="product-card hidden-element delay-2">
                <div class="product-img-container">
                    <img src="https://images.unsplash.com/photo-1618512496248-a07fe83aa8cb?w=500" class="product-img" alt="Red Onions">
                </div>
                <div class="product-info">
                    <p class="product-category">Vegetables</p>
                    <h3 class="product-title">Fresh Red Onions</h3>
                    <div class="product-rating">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i> <span>(47)</span>
                    </div>
                    <div class="product-bottom">
                        <p class="product-price">$2.50 <span style="font-size: 0.8rem; font-weight: normal; color: var(--text-light);">/ lb</span></p>
                        <form action="add_to_cart.php" method="POST">
                            <input type="hidden" name="product_id" value="17"> 
                            <button type="submit" class="add-to-cart" title="Add to Basket"><i class="fas fa-plus"></i></button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="product-card hidden-element delay-3">
                <span class="badge bestseller">Bestseller</span>
                <div class="product-img-container">
                    <img src="https://images.unsplash.com/photo-1580915411954-282cb1b0d780?w=500" class="product-img" alt="Maple Syrup">
                </div>
                <div class="product-info">
                    <p class="product-category">Pantry Staples</p>
                    <h3 class="product-title">Pure Maple Syrup</h3>
                    <div class="product-rating">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i> <span>(312)</span>
                    </div>
                    <div class="product-bottom">
                        <p class="product-price">$18.99 <span style="font-size: 0.8rem; font-weight: normal; color: var(--text-light);">/ bottle</span></p>
                        <form action="add_to_cart.php" method="POST">
                            <input type="hidden" name="product_id" value="18"> 
                            <button type="submit" class="add-to-cart" title="Add to Basket"><i class="fas fa-plus"></i></button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="product-card hidden-element delay-4">
                <div class="product-img-container">
                    <img src="https://images.unsplash.com/photo-1540148426947-1fceb20dd676?w=500" class="product-img" alt="Garlic">
                </div>
                <div class="product-info">
                    <p class="product-category">Vegetables</p>
                    <h3 class="product-title">Organic Garlic Bulbs</h3>
                    <div class="product-rating">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i> <span>(62)</span>
                    </div>
                    <div class="product-bottom">
                        <p class="product-price">$3.20 <span style="font-size: 0.8rem; font-weight: normal; color: var(--text-light);">/ 3-pack</span></p>
                        <form action="add_to_cart.php" method="POST">
                            <input type="hidden" name="product_id" value="19"> 
                            <button type="submit" class="add-to-cart" title="Add to Basket"><i class="fas fa-plus"></i></button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="product-card hidden-element delay-5">
                <span class="badge organic">Organic</span>
                <div class="product-img-container">
                    <img src="https://images.unsplash.com/photo-1523049673857-eb18f1d7b578?w=500" class="product-img" alt="Avocados">
                </div>
                <div class="product-info">
                    <p class="product-category">Fruits</p>
                    <h3 class="product-title">Hass Avocados</h3>
                    <div class="product-rating">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i> <span>(145)</span>
                    </div>
                    <div class="product-bottom">
                        <p class="product-price">$5.00 <span style="font-size: 0.8rem; font-weight: normal; color: var(--text-light);">/ 2-pack</span></p>
                        <form action="add_to_cart.php" method="POST">
                            <input type="hidden" name="product_id" value="20"> 
                            <button type="submit" class="add-to-cart" title="Add to Basket"><i class="fas fa-plus"></i></button>
                        </form>
                    </div>
                </div>
            </div>

        </main>
    </div>

    <footer>
        <div class="footer-content">
            <div class="footer-section">
                <h3><i class="fas fa-leaf"></i> FarmDirect+</h3>
                <p>Connecting conscious consumers with local farmers. Eat fresh, live healthy, support local agriculture.</p>
            </div>
            <div class="footer-section">
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Delivery Information</a></li>
                    <li><a href="#">Return Policy</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Contact Us</h3>
                <ul>
                    <li><i class="fas fa-map-marker-alt"></i> 123 Farm Road, Agriville, ST 12345</li>
                    <li><i class="fas fa-phone"></i> +1 (555) 123-4567</li>
                    <li><i class="fas fa-envelope"></i> hello@farmdirectplus.com</li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2026 FarmDirect+. All rights reserved.</p>
        </div>
    </footer>

    <script>
        // Intersection Observer for scroll animations
        const observerOptions = { threshold: 0.1, rootMargin: "0px 0px -50px 0px" };
        const observer = new IntersectionObserver((entries, obs) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('show-element');
                    obs.unobserve(entry.target);
                }
            });
        }, observerOptions);
        
        document.querySelectorAll('.hidden-element').forEach(el => observer.observe(el));
    </script>
</body>
</html>