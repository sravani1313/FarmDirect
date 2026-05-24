<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FarmDirect: Buy from Farmers</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <style>
        /* Reset and Global Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            scroll-behavior: smooth;
        }

        body {
            color: #004445;
            line-height: 1.6;
            background-color: #fdfbf7;
            overflow-x: hidden;
        }

        /* Top Bar Banner */
        .top-banner {
            background-color: #ffcc00;
            text-align: center;
            padding: 10px;
            font-weight: 600;
            font-size: 14px;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 15px;
        }

        .top-banner a {
            background: white;
            padding: 4px 12px;
            border-radius: 20px;
            text-decoration: none;
            color: #004445;
            font-size: 12px;
            transition: opacity 0.2s;
        }

        .top-banner a:hover {
            opacity: 0.9;
        }

        /* Main Header/Navbar */
        header {
            background-color: #fff;
            padding: 15px 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #004445;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .nav-links {
            display: flex;
            list-style: none;
            gap: 25px;
        }

        .nav-links a {
            text-decoration: none;
            color: #004445;
            font-weight: 600;
            position: relative;
            padding-bottom: 4px;
        }

        .nav-links a::after {
            content: '';
            position: absolute;
            width: 100%;
            transform: scaleX(0);
            height: 2px;
            bottom: 0;
            left: 0;
            background-color: #ffcc00;
            transform-origin: bottom right;
            transition: transform 0.25s ease-out;
        }

        .nav-links a:hover::after {
            transform: scaleX(1);
            transform-origin: bottom left;
        }

        /* Hero Layout */
        .hero {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            padding: 80px 5%;
            background-color: #fffbf2;
        }

        .hero-content {
            flex: 1;
            min-width: 300px;
            padding-right: 40px;
        }

        .hero-content h1 {
            font-size: 48px;
            margin-bottom: 20px;
            line-height: 1.2;
        }

        .hero-content p {
            font-size: 18px;
            margin-bottom: 30px;
            color: #4a5568;
        }

        .btn {
            display: inline-block;
            background-color: #004445;
            color: white;
            padding: 14px 32px;
            text-decoration: none;
            border-radius: 30px;
            font-weight: bold;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 12px rgba(0,0,0,0.15);
            background-color: #1a5e60;
        }

        .hero-image {
            flex: 1;
            min-width: 300px;
            text-align: center;
        }

        .hero-image img {
            max-width: 100%;
            height: auto;
            border-radius: 15px;
        }

        /* Section Settings */
        section {
            padding: 80px 5%;
        }

        .section-title {
            text-align: center;
            font-size: 36px;
            margin-bottom: 40px;
        }

        /* Grid Frameworks */
        .grid-4, .grid-3 {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
        }

        .card {
            background: white;
            padding: 35px 25px;
            border-radius: 16px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.02);
            text-align: center;
            transition: all 0.3s ease;
            border: 1px solid #f1ebd9;
        }

        .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 24px rgba(0,0,0,0.08);
            border-color: #ffcc00;
        }

        /* App Walkthrough Component */
        .app-dive {
            background-color: #fffbf2;
            text-align: center;
        }

        .app-carousel {
            max-width: 700px;
            margin: 40px auto 0;
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.03);
        }

        .steps-nav {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-bottom: 30px;
        }

        .step-dot {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #f0f0f0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s;
        }

        .step-dot.active {
            background: #004445;
            color: white;
            transform: scale(1.1);
        }

        .step-content {
            display: none;
            animation: fadeIn 0.5s ease;
        }

        .step-content.active {
            display: block;
        }

        /* Sustainability Lists */
        .features-list {
            max-width: 800px;
            margin: 0 auto;
        }

        .feature-item {
            margin-bottom: 20px;
            background: #fff;
            padding: 20px;
            border-left: 5px solid #004445;
            border-radius: 0 12px 12px 0;
            transition: transform 0.2s ease;
        }

        .feature-item:hover {
            transform: translateX(6px);
        }

        /* Farmers Deck */
        .farmer-card {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid #eef2f5;
            transition: transform 0.3s;
        }

        .farmer-card:hover {
            transform: translateY(-5px);
        }

        .farmer-info {
            padding: 30px;
        }

        .farmer-link {
            display: inline-block;
            margin-top: 15px;
            color: #1a5e60;
            text-decoration: none;
            font-weight: bold;
        }

        /* Review Blocks */
        .reviews {
            background-color: #f2f7f5;
        }

        .review-card {
            background: white;
            padding: 30px;
            border-radius: 16px;
            margin-bottom: 20px;
            border-left: 4px solid #ffcc00;
        }

        /* Interactive FAQ Accordion */
        .faq-item {
            background: white;
            margin-bottom: 15px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.02);
            overflow: hidden;
        }

        .faq-header {
            padding: 22px 24px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #fff;
            transition: background 0.3s;
        }

        .faq-header:hover {
            background: #fffdfa;
        }

        .faq-icon {
            transition: transform 0.3s ease;
        }

        .faq-body {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out, padding 0.3s ease;
            padding: 0 24px;
            color: #4a5568;
            background: #fff;
        }

        .faq-item.open .faq-body {
            padding-bottom: 22px;
        }

        .faq-item.open .faq-icon {
            transform: rotate(180deg);
        }

        /* Form Configuration */
        .partner-section {
            background-color: #fffbf2;
        }

        .partner-form {
            max-width: 650px;
            margin: 0 auto;
            background: white;
            padding: 45px;
            border-radius: 16px;
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        .form-group input, .form-group textarea {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            font-size: 16px;
            background-color: #f8fafc;
            transition: all 0.3s;
        }

        .form-group input:focus, .form-group textarea:focus {
            outline: none;
            border-color: #004445;
            background-color: white;
            box-shadow: 0 0 0 3px rgba(0, 68, 69, 0.1);
        }

        .form-submit {
            width: 100%;
            background: #004445;
            color: white;
            border: none;
            padding: 14px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
        }

        /* Footer Structural Set */
        footer {
            background: #004445;
            color: white;
            padding: 60px 5% 40px;
            text-align: center;
        }

        .footer-links a {
            color: #ffcc00;
            text-decoration: none;
            margin: 0 12px;
        }

        /* Scroll Engine Activation Styling */
        .reveal {
            opacity: 0;
            transform: translateY(40px);
            transition: all 0.8s cubic-bezier(0.215, 0.610, 0.355, 1);
        }

        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }

        @media (max-width: 768px) {
            .hero-content h1 { font-size: 34px; }
            header { flex-direction: column; gap: 15px; }
        }
    </style>
</head>
<body>

    <div class="top-banner animate__animated animate__fadeIn">
        Want to try fresh, local food? Just one click away!
        <div>
            <a href="#">See online</a>
            <a href="#">Download the app</a>
        </div>
    </div>

<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FarmDirect+ | Buy Fresh Organic Produce & Dairy Direct From Local Farms</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        heading: ['Playfair Display', 'serif'],
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    },
                    colors: {
                        primary: '#16a34a',
                        primaryDark: '#15803d',
                        secondary: '#f97316',
                        surface: '#f8fafc',
                        surfaceDark: '#0f172a',
                    },
                    boxShadow: {
                        'soft': '0 20px 40px -15px rgba(0,0,0,0.05)',
                        'floating': '0 30px 60px -10px rgba(22, 163, 74, 0.15)',
                    }
                }
            }
        }
    </script>

    <style>
        body {
            background-color: #fafcfb;
            color: #1e293b;
            overflow-x: hidden;
        }

        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

        .glass-panel {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        @keyframes ticker {
            0% { transform: translate3d(0, 0, 0); }
            100% { transform: translate3d(-50%, 0, 0); }
        }
        .ticker-wrap { display: flex; width: max-content; animation: ticker 30s linear infinite; }
        .ticker-wrap:hover { animation-play-state: paused; }

        /* Step selector interactions */
        .step-node.active-step {
            border-color: #16a34a;
            background-color: rgba(22, 163, 74, 0.05);
        }
        .step-node.active-step .step-badge {
            background-color: #16a34a;
            color: white;
        }
    </style>
</head>
<body class="font-sans antialiased selection:bg-primary selection:text-white">

    <div class="w-full bg-surfaceDark text-white py-2 text-xs font-semibold overflow-hidden border-b border-white/5 relative z-50">
        <div class="ticker-wrap space-x-12 items-center flex">
            <span class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span> HASS AVOCADOS: <span class="text-primary">In Stock (450kg Freshly Picked)</span></span>
            <span class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span> VINE-RIPENED TOMATOES: <span class="text-primary">85 Low-Carbon Batches Left</span></span>
            <span class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-secondary animate-pulse"></span> ORGANIC CAVENDISH BANANAS: <span class="text-secondary">Low Stock (Running Out Fast)</span></span>
            <span class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-red-500 animate-pulse"></span> HEIRLOOM SWEET POTATOES: <span class="text-red-400">Sold Out (Next Harvest Sunday)</span></span>
            <span class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span> REGENERATIVE PASTURE EGGS: <span class="text-primary">Just Restocked From Earth Roots Farm</span></span>
            <span class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span> HASS AVOCADOS: <span class="text-primary">In Stock (450kg Freshly Picked)</span></span>
            <span class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span> VINE-RIPENED TOMATOES: <span class="text-primary">85 Low-Carbon Batches Left</span></span>
            <span class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-secondary animate-pulse"></span> ORGANIC CAVENDISH BANANAS: <span class="text-secondary">Low Stock (Running Out Fast)</span></span>
        </div>
    </div>

    <nav class="sticky top-0 w-full z-40 glass-panel border-b border-gray-100 transition-all duration-300" id="navbar">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            
            <a href="#" class="flex items-center gap-2 group">
                <div class="w-10 h-10 rounded-full bg-primary flex items-center justify-center text-white group-hover:rotate-12 transition-transform">
                    <i class="fas fa-leaf"></i>
                </div>
                <span class="font-heading font-bold text-2xl tracking-tight text-surfaceDark">Farm<span class="text-primary">Direct+</span></span>
            </a>

            <div class="hidden md:flex items-center gap-8 font-medium text-gray-600">
                <a href="index.php" class="hover:text-primary transition-colors py-1">Home</a>
                <a href="about.html" class="hover:text-primary transition-colors py-1">About Us</a>
                <a href="products.html" class="hover:text-green-600">Products</a>
                <a href="farmers.html" class="hover:text-primary transition-colors py-1">Farmers</a>
                <a href="subscription.html" class="hover:text-primary transition-colors py-1">Subscriptions</a>
                <a href="contact.php" class="hover:text-primary transition-colors py-1">Contact Us</a>
            </div>
            
            <div class="flex items-center gap-6">
                <div class="flex items-center gap-4 text-gray-600">
                    
                    <a href="login.php" class="hover:text-primary transition-colors" title="Account Login"><i class="far fa-user text-lg"></i></a>
                    <a href="cart.php" class="relative hover:text-primary transition-colors" title="View Shopping Cart">
                        <i class="fas fa-shopping-basket text-xl"></i>
                        
                    </a>
                </div>
                <a href="shop.php" class="hidden sm:inline-block bg-primary hover:bg-primaryDark text-white px-5 py-2.5 rounded-full text-sm font-semibold transition-all shadow-md">
                    Visit Market
                </a>
            </div>
        </div>
    </nav>


    <section class="hero">
        <div class="hero-content animate__animated animate__fadeInLeft">
            <h1>From Local Farms to Your Table</h1>
            <p>FarmDirect delivers fresh, natural products straight from local farms. Enjoy high-quality ingredients and sustainable essentials with fast, direct delivery to your door. Support local agriculture with every order.</p>
            <a href="#" class="btn">Download the App</a>
        </div>
        <div class="hero-image animate__animated animate__fadeInRight">
            <img src="https://images.pexels.com/photos/12765459/pexels-photo-12765459.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2" alt="Farm to home hero image">
        </div>
    </section>

    <section id="about" class="reveal">
        <h2 class="section-title">Meet FarmDirect</h2>
        <div style="max-width: 800px; margin: 0 auto; text-align: center; font-size: 18px; color: #4a5568;">
            <p>At FarmDirect, we connect people with the freshest products, bringing the taste of local farms directly to your table. Our mission blends modern technology with nature’s simplicity, delivering high-quality ingredients and recipes to support conscious, enjoyable eating—bringing families and communities together through food.</p>
        </div>
    </section>

    <section style="background-color: #f9f9f9;" class="reveal">
        <h2 class="section-title">What’s Next</h2>
        <div style="max-width: 800px; margin: 0 auto; text-align: center; color: #4a5568;">
            <p>We now deliver nationwide across the Netherlands — 3 days a week! Looking ahead, we’re preparing to expand into Belgium and Luxembourg, while continuing to improve our app and delivery experience. Stay tuned for more updates as we grow together!</p>
        </div>
    </section>

    <section class="reveal">
        <h2 class="section-title">Why Choose FarmDirect?</h2>
        <div class="grid-4">
            <div class="card">
                <div style="font-size: 40px; margin-bottom: 15px;">🍏</div>
                <h3>Quality Assurance</h3>
                <p>Each product is carefully inspected for quality and taste before reaching the app.</p>
            </div>
            <div class="card">
                <div style="font-size: 40px; margin-bottom: 15px;">📦</div>
                <h3>Personalized Service</h3>
                <p>Enjoy a customized experience with fresh products delivered directly to your doorstep.</p>
            </div>
            <div class="card">
                <div style="font-size: 40px; margin-bottom: 15px;">✨</div>
                <h3>Curated Selection</h3>
                <p>A diverse range of farm-fresh basics, seasonal delights, and exclusive collaborations.</p>
            </div>
            <div class="card">
                <div style="font-size: 40px; margin-bottom: 15px;">🧑‍🌾</div>
                <h3>Support Local</h3>
                <p>We partner with local producers, strengthening community farming.</p>
            </div>
        </div>
        <div style="text-align: center; margin-top: 50px;">
            <a href="shop.php" class="btn">Start Farm Shopping</a>
        </div>
    </section>

    <section id="how-it-works" class="reveal">
        <h2 class="section-title">How does it work?</h2>
        <div class="grid-3">
            <div class="card">
                <div style="font-size: 40px; margin-bottom: 15px;">🧺</div>
                <h3>Custom Orders or Ready Boxes</h3>
                <p>Choose from our curated farm boxes or build your own order with fresh products.</p>
            </div>
            <div class="card">
                <div style="font-size: 40px; margin-bottom: 15px;">🚚</div>
                <h3>Tailored Deliveries</h3>
                <p>We offer personalized deliveries based on your preferences, without a subscription commitment.</p>
            </div>
            <div class="card">
                <div style="font-size: 40px; margin-bottom: 15px;">📅</div>
                <h3>Delivery Schedule</h3>
                <p>Farm-fresh produce delivered Mondays, Wednesdays, and Fridays — with smart tracking so you know exactly when we’ll arrive.</p>
            </div>
        </div>
    </section>

    <section class="reveal">
        <h2 class="section-title">Eating with Purpose: Fresh, Local, and Sustainable</h2>
        <div class="features-list">
            <div class="feature-item">
                <strong>♻️ Bio-Packaging:</strong> All products come in compostable or biodegradable packaging, minimizing plastic usage.
            </div>
            <div class="feature-item">
                <strong>🌍 Local Sourcing:</strong> By partnering with local farmers, we reduce carbon emissions from transport.
            </div>
            <div class="feature-item">
                <strong>📉 Food Waste Minimization:</strong> Our smart delivery model ensures only fresh, necessary amounts are ordered, reducing food waste.
            </div>
        </div>
    </section>

    <section class="app-dive reveal">
        <h2 class="section-title">Let’s dive into the app</h2>
        <p style="color: #4a5568;">Click the numbers below to see how our app connects you directly to the field.</p>
        <div class="app-carousel">
            <div class="steps-nav">
                <div class="step-dot active" onclick="switchStep(1)">1</div>
                <div class="step-dot" onclick="switchStep(2)">2</div>
                <div class="step-dot" onclick="switchStep(3)">3</div>
                <div class="step-dot" onclick="switchStep(4)">4</div>
                <div class="step-dot" onclick="switchStep(5)">5</div>
                <div class="step-dot" onclick="switchStep(6)">6</div>
            </div>
            <div id="step1" class="step-content active"><h3>Have a wide range of fresh farm products</h3></div>
            <div id="step2" class="step-content"><h3>Easily pick the groceries or ready-made boxes</h3></div>
            <div id="step3" class="step-content"><h3>Read the stories of the farmers</h3></div>
            <div id="step4" class="step-content"><h3>Discover Meals section with boxes, recipes and meals</h3></div>
            <div id="step5" class="step-content"><h3>Pay by card or pay when delivered</h3></div>
            <div id="step6" class="step-content"><h3>Enjoy your natural trackable delivery</h3></div>
        </div>
        <div style="margin-top: 40px; font-style: italic; color: #4a5568;">
            "Our goal is to make fresh, local, and healthy food an everyday norm, not an exception" <br><strong>- Maksym D., Co-Founder</strong>
        </div>
    </section>

    <section id="farmers" class="reveal">
        <h2 class="section-title">Meet our farmers</h2>
        <div class="grid-3">
            <div class="farmer-card">
                <img src="https://images.unsplash.com/photo-1595974482597-4b8da8879bc5?auto=format&fit=crop&q=80&w=400" style="width:100%; height:200px; object-fit:cover;" alt="Firma Ruizendaal">
                <div class="farmer-info">
                    <h3>Firma Ruizendaal</h3>
                    <p>Ruizendaal Farm, located in the fertile soils of Waverveen, is a family-run farm specializing in apples, pears, plums, and cherries. With 7,000 trees, they minimize pesticide use, letting nature shape the taste of their carefully tended fruit.</p>
                    
                </div>
            </div>
            <div class="farmer-card">
                <img src="https://images.pexels.com/photos/4975353/pexels-photo-4975353.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2" style="width:100%; height:200px; object-fit:cover;" alt="Groenharting">
                <div class="farmer-info">
                    <h3>Groenharting</h3>
                    <p>At Groenhartig, they grow salads, vegetables, herbs, and flowers for chefs in Amsterdam who love working with local, seasonal produce. With up to 90 products per season, Groenhartig collaborates with eco-friendly growers to promote biodiversity.</p>
                    
                </div>
            </div>
            <div class="farmer-card">
                <img src="https://images.unsplash.com/photo-1500937386664-56d1dfef3854?auto=format&fit=crop&q=80&w=400" style="width:100%; height:200px; object-fit:cover;" alt="Natuurboerderij Hardebol">
                <div class="farmer-info">
                    <h3>Natuurboerderij Hardebol</h3>
                    <p>Nature Farm Hardebol offers premium Black-Angus beef from the lush Ilperveld pastures, along with free-range meats and seasonal produce. Discover the unique Croosduijkertje liqueur and savor flavors rooted in tradition and nature.</p>
                    
                </div>
            </div>
        </div>
    </section>

    <section style="background-color:#004445; color: white;" class="reveal">
        <div style="max-width: 800px; margin: 0 auto; text-align: center;">
            <h2 style="margin-bottom: 20px;">Why is local better?</h2>
            <p style="font-size: 18px;">Local produce is fresher, as it doesn't travel long distances to reach you. This means better taste and higher nutritional value. By choosing local, you also support the local economy, promote sustainable farming, and reduce environmental impact.</p>
            <a href="shop.php" class="btn" style="background:#ffcc00; color:#004445; margin-top:30px;">Start to Buy local</a>
        </div>
    </section>

    <section class="reviews reveal">
        <h2 class="section-title">How customers rate FarmDirect</h2>
        <div class="grid-3" style="align-items: start;">
            <div class="review-card">
                <strong>Caroline de Mooij</strong>
                <p style="margin-top: 10px; color:#4a5568;">"Mooie producten, genoeg keus, variërend assortiment, geweldig concept en visie, eerlijke keten en vriendelijk personeel. Als dit bedrijf zijn bezorggebied heeft kunnen uitbreiden is het helemaal top."</p>
            </div>
            <div class="review-card">
                <strong>Jessica Andriessen</strong>
                <p style="margin-top: 10px; color:#4a5568;">"Ik ben meteen al fan van FarmDirect: hele verse producten, direct van de boer of producent. Korte keten, eerlijke prijzen voor de boer en heerlijke producten voor de klant. Ik vind het aanbod heel uitgebreid, echt een kijkje waard! Het contact met de klantenservice is snel..."</p>
            </div>
            <div class="review-card">
                <strong>Receptentester (Koen Fransen)</strong>
                <p style="margin-top: 10px; color:#4a5568;">"Prachtige 'eerlijke' producten, letterlijk afkomstig van boerderijen om de hoek! Een heel mooi initiatief, waarmee je niet alleen goed voor jezelf zorgt, maar ook de lokale boerderijen ondersteunt!"</p>
            </div>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-6 py-20">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <h2 class="font-heading font-bold text-4xl sm:text-5xl text-surfaceDark mb-4">Let's dive into the app</h2>
            <p class="text-gray-500 font-medium text-lg">Experience field-to-fork tracking and order direct from local farmers with just a couple of taps.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            
            <div class="lg:col-span-4 space-y-4 order-2 lg:order-1">
                <div onclick="setAppView(1)" id="node-1" class="step-node active-step p-4 rounded-2xl border border-gray-100 bg-white shadow-sm cursor-pointer transition-all duration-300 flex items-start gap-4">
                    <span class="step-badge w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center font-bold text-sm text-gray-600 transition-colors shrink-0">1</span>
                    <div>
                        <h4 class="font-bold text-gray-900 mb-1">Wide Product Range</h4>
                        <p class="text-xs text-gray-500 leading-relaxed">Access hundreds of fresh farm basics, seasonal items, and exclusive organic products directly from fields.</p>
                    </div>
                </div>

                <div onclick="setAppView(2)" id="node-2" class="step-node p-4 rounded-2xl border border-gray-100 bg-white shadow-sm cursor-pointer transition-all duration-300 flex items-start gap-4">
                    <span class="step-badge w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center font-bold text-sm text-gray-600 transition-colors shrink-0">2</span>
                    <div>
                        <h4 class="font-bold text-gray-900 mb-1">Curated Box Selection</h4>
                        <p class="text-xs text-gray-500 leading-relaxed">Easily build custom assortments or select curated ready-made seasonal farmer subscription boxes.</p>
                    </div>
                </div>

                <div onclick="setAppView(3)" id="node-3" class="step-node p-4 rounded-2xl border border-gray-100 bg-white shadow-sm cursor-pointer transition-all duration-300 flex items-start gap-4">
                    <span class="step-badge w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center font-bold text-sm text-gray-600 transition-colors shrink-0">3</span>
                    <div>
                        <h4 class="font-bold text-gray-900 mb-1">Farmer Biographies</h4>
                        <p class="text-xs text-gray-500 leading-relaxed">Read authentic profiles and view direct transparency interviews with independent community producers.</p>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-4 flex justify-center order-1 lg:order-2">
                <div class="relative w-[310px] h-[630px] bg-black rounded-[45px] p-3 shadow-floating border-4 border-gray-800 ring-8 ring-gray-900/10">
                    <div class="absolute top-5 left-1/2 -translate-x-1/2 w-28 h-6 bg-black rounded-full z-30"></div>
                    
                    <div class="w-full h-full bg-[#fdfbf7] rounded-[36px] overflow-hidden relative border border-gray-900/5 flex flex-col">
                        
                        <div class="bg-white border-b border-gray-100 px-4 pt-8 pb-3 flex justify-between items-center shrink-0">
                            <span class="font-heading font-extrabold text-sm text-surfaceDark">Farm<span class="text-primary">Direct+</span></span>
                            <div class="flex items-center gap-1.5 text-[10px] font-bold text-gray-400 border border-gray-200 px-1.5 py-0.5 rounded-md">
                                <i class="fas fa-globe text-gray-300"></i> EN <i class="fas fa-chevron-down text-[8px]"></i>
                            </div>
                        </div>

                        <div class="p-4 flex-1 overflow-y-auto space-y-3" id="mockup-frame">
                            <div id="view-1" class="space-y-3 animate__animated animate__fadeIn">
                                <div class="bg-primary/10 p-3.5 rounded-2xl border border-primary/20 text-center">
                                    <h5 class="font-bold text-xs text-primaryDark mb-0.5">De Boerderij in een Box</h5>
                                    <p class="text-[9px] text-gray-500">Verse, lokale producten met één klik besteld en bij je thuis geleverd</p>
                                </div>
                                <div class="bg-gray-100 text-gray-400 rounded-xl p-2.5 flex items-center gap-2 text-[11px]">
                                    <i class="fas fa-search text-gray-300"></i> I'm looking for...
                                </div>
                                <div class="grid grid-cols-2 gap-2">
                                    <div class="bg-white p-2 rounded-xl border border-gray-100 text-center shadow-2xs">
                                        <div class="text-lg">🍓</div>
                                        <div class="font-bold text-[10px] mt-1 text-gray-700">Fresh Berries</div>
                                    </div>
                                    <div class="bg-white p-2 rounded-xl border border-gray-100 text-center shadow-2xs">
                                        <div class="text-lg">🥦</div>
                                        <div class="font-bold text-[10px] mt-1 text-gray-700">Crisp Greens</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-4 space-y-4 order-3">
                <div onclick="setAppView(4)" id="node-4" class="step-node p-4 rounded-2xl border border-gray-100 bg-white shadow-sm cursor-pointer transition-all duration-300 flex items-start gap-4">
                    <span class="step-badge w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center font-bold text-sm text-gray-600 transition-colors shrink-0">4</span>
                    <div>
                        <h4 class="font-bold text-gray-900 mb-1">In-App Recipes</h4>
                        <p class="text-xs text-gray-500 leading-relaxed">Discover custom tailored recipe lists alongside one-click farm meal ingredient boxing toolsets.</p>
                    </div>
                </div>

                <div onclick="setAppView(5)" id="node-5" class="step-node p-4 rounded-2xl border border-gray-100 bg-white shadow-sm cursor-pointer transition-all duration-300 flex items-start gap-4">
                    <span class="step-badge w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center font-bold text-sm text-gray-600 transition-colors shrink-0">5</span>
                    <div>
                        <h4 class="font-bold text-gray-900 mb-1">Flexible Payments</h4>
                        <p class="text-xs text-gray-500 leading-relaxed">Secure transaction settlement using modern card integration or verified pay-on-delivery options.</p>
                    </div>
                </div>

                <div onclick="setAppView(6)" id="node-6" class="step-node p-4 rounded-2xl border border-gray-100 bg-white shadow-sm cursor-pointer transition-all duration-300 flex items-start gap-4">
                    <span class="step-badge w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center font-bold text-sm text-gray-600 transition-colors shrink-0">6</span>
                    <div>
                        <h4 class="font-bold text-gray-900 mb-1">Smart Route Tracking</h4>
                        <p class="text-xs text-gray-500 leading-relaxed">Monitor delivery fulfillment with integrated route update notifications right to your doorstep.</p>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <script>
        const layoutViews = {
            1: `<div class="space-y-3 animate__animated animate__fadeIn">
                    <div class="bg-primary/10 p-3.5 rounded-2xl border border-primary/20 text-center">
                        <h5 class="font-bold text-xs text-primaryDark mb-0.5">De Boerderij in een Box</h5>
                        <p class="text-[9px] text-gray-500">Verse, lokale producten met één klik besteld en bij je thuis geleverd</p>
                    </div>
                    <div class="bg-gray-100 text-gray-400 rounded-xl p-2.5 flex items-center gap-2 text-[11px]"><i class="fas fa-search text-gray-300"></i> I'm looking for...</div>
                    <div class="grid grid-cols-2 gap-2">
                        <div class="bg-white p-2 rounded-xl border border-gray-100 text-center"><div class="text-lg">🍓</div><div class="font-bold text-[10px] mt-1 text-gray-700">Fresh Berries</div></div>
                        <div class="bg-white p-2 rounded-xl border border-gray-100 text-center"><div class="text-lg">🥦</div><div class="font-bold text-[10px] mt-1 text-gray-700">Crisp Greens</div></div>
                    </div>
                </div>`,
            2: `<div class="space-y-3 animate__animated animate__fadeIn">
                    <h5 class="font-bold text-xs text-gray-800">Select Box Configuration</h5>
                    <div class="bg-white p-3 rounded-xl border-2 border-primary flex items-center justify-between">
                        <div>
                            <div class="font-bold text-[11px] text-gray-900">Family Harvest Box</div>
                            <div class="text-[9px] text-gray-400">8.5kg Organic Selection</div>
                        </div>
                        <span class="text-xs font-bold text-primary">€29.90</span>
                    </div>
                    <div class="bg-white p-3 rounded-xl border border-gray-100 flex items-center justify-between opacity-70">
                        <div>
                            <div class="font-bold text-[11px] text-gray-900">Single Orchard Box</div>
                            <div class="text-[9px] text-gray-400">4.0kg Seasonal Fruit</div>
                        </div>
                        <span class="text-xs font-bold text-gray-700">€16.50</span>
                    </div>
                </div>`,
            3: `<div class="space-y-3 animate__animated animate__fadeIn">
                    <div class="rounded-xl overflow-hidden bg-white border border-gray-100">
                        <div class="h-20 bg-emerald-800 flex items-center justify-center text-white text-2xl font-bold">🌾</div>
                        <div class="p-3">
                            <h5 class="font-bold text-xs text-gray-900">Firma Ruizendaal</h5>
                            <p class="text-[9px] text-gray-500 mt-1">Specializing in apples, plums, and sweet cherries directly from Waverveen soil bases.</p>
                        </div>
                    </div>
                </div>`,
            4: `<div class="space-y-3 animate__animated animate__fadeIn">
                    <h5 class="font-bold text-xs text-gray-800">Trending Farm Meals</h5>
                    <div class="bg-white rounded-xl border border-gray-100 overflow-hidden">
                        <div class="h-16 bg-amber-100 flex items-center justify-center text-xl">🍲</div>
                        <div class="p-2 text-center">
                            <div class="font-bold text-[10px]">Rustic Tomato Stew</div>
                            <button class="mt-1 bg-primary text-white text-[9px] px-3 py-1 rounded-full w-full font-bold">Add Ingredients Box</button>
                        </div>
                    </div>
                </div>`,
            5: `<div class="space-y-3 animate__animated animate__fadeIn">
                    <h5 class="font-bold text-xs text-gray-800">Checkout Options</h5>
                    <div class="space-y-2">
                        <div class="bg-white p-2.5 rounded-lg border border-gray-200 flex items-center gap-3 text-[11px] font-medium"><i class="fab fa-apple-pay text-base text-gray-900"></i> Apple Pay Secure</div>
                        <div class="bg-white p-2.5 rounded-lg border border-gray-200 flex items-center gap-3 text-[11px] font-medium"><i class="far fa-credit-card text-base text-primary"></i> Credit / Debit Card</div>
                        <div class="bg-white p-2.5 rounded-lg border border-primary bg-primary/5 flex items-center gap-3 text-[11px] font-medium"><i class="fas fa-truck text-base text-primary"></i> Pay upon Delivery</div>
                    </div>
                </div>`,
            6: `<div class="space-y-3 animate__animated animate__fadeIn">
                    <div class="bg-white p-3 rounded-xl border border-gray-100 shadow-xs">
                        <div class="flex justify-between items-center text-[10px] text-gray-400 mb-2"><span>Order #49204</span><span class="text-primary font-bold">On the way</span></div>
                        <div class="h-1.5 w-full bg-gray-100 rounded-full overflow-hidden"><div class="w-3/4 h-full bg-primary rounded-full"></div></div>
                        <p class="text-[10px] text-gray-600 mt-2"><i class="fas fa-clock text-primary"></i> ETA: <b>Wednesday, 2:15 PM</b></p>
                    </div>
                </div>`
        };

        function setAppView(stepIndex) {
            document.querySelectorAll('.step-node').forEach(el => el.classList.remove('active-step'));
            document.getElementById(`node-${stepIndex}`).classList.add('active-step');
            document.getElementById('mockup-frame').innerHTML = layoutViews[stepIndex];
        }
    </script>

    
    
  

    <section class="reveal">
        <h2 class="section-title">Frequently asked questions</h2>
        <div style="max-width: 800px; margin: 0 auto;">
            <div class="faq-item">
                <div class="faq-header" onclick="toggleFaq(this)">Why should I order from FarmDirect+? <span class="faq-icon">▼</span></div>
                <div class="faq-body"><p>Ordering from FarmDirect means enjoying the freshest, highest-quality produce available. Our user-friendly app lets you easily browse a wide variety of delicious products, all delivered straight to your door. Experience the convenience and taste of farm-fresh food every day.</p></div>
            </div>
            <div class="faq-item">
                <div class="faq-header" onclick="toggleFaq(this)">Where do you deliver? <span class="faq-icon">▼</span></div>
                <div class="faq-body"><p>We now deliver nationwide across the Netherlands — so everyone can enjoy fresh, local products at home.</p></div>
            </div>
            <div class="faq-item">
                <div class="faq-header" onclick="toggleFaq(this)">Is all your produce organic? <span class="faq-icon">▼</span></div>
                <div class="faq-body"><p>We offer a mix of organic and non-organic produce, all clearly labeled so you make the choice that's right for you.</p></div>
            </div>
            <div class="faq-item">
                <div class="faq-header" onclick="toggleFaq(this)">How do I place an order? <span class="faq-icon">▼</span></div>
                <div class="faq-body"><p>It's a breeze! Pick the freshest items you love, add them to the cart, and proceed to checkout. Just in a few taps, they're on their way to you!</p></div>
            </div>
        </div>
    </section>

    

    <script>
        // Scroll Detection Logic
        function revealOnScroll() {
            const reveals = document.querySelectorAll('.reveal');
            const windowHeight = window.innerHeight;
            reveals.forEach(element => {
                const elementTop = element.getBoundingClientRect().top;
                if (elementTop < windowHeight - 100) {
                    element.classList.add('active');
                }
            });
        }
        window.addEventListener('scroll', revealOnScroll);
        window.addEventListener('load', revealOnScroll);

        // App Walkthrough Switch Logic
        function switchStep(stepNum) {
            document.querySelectorAll('.step-dot').forEach(dot => dot.classList.remove('active'));
            document.querySelectorAll('.step-content').forEach(content => content.classList.remove('active'));
            
            document.querySelectorAll('.step-dot')[stepNum - 1].classList.add('active');
            document.getElementById(`step${stepNum}`).classList.add('active');
        }

        // FAQ Collapse Accordion Logic
        function toggleFaq(headerElement) {
            const wrapper = headerElement.parentElement;
            const body = wrapper.querySelector('.faq-body');
            
            if(wrapper.classList.contains('open')) {
                wrapper.classList.remove('open');
                body.style.maxHeight = "0px";
            } else {
                // Optional: closes other items if open
                document.querySelectorAll('.faq-item').forEach(item => {
                    item.classList.remove('open');
                    item.querySelector('.faq-body').style.maxHeight = "0px";
                });
                wrapper.classList.add('open');
                body.style.maxHeight = body.scrollHeight + "px";
            }
        }
    </script>
</body>
</html>



<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FarmDirect+ | Buy Fresh Organic Produce & Dairy Direct From Local Farms</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        heading: ['Playfair Display', 'serif'],
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    },
                    colors: {
                        primary: '#16a34a',
                        primaryDark: '#15803d',
                        secondary: '#f97316',
                        surface: '#f8fafc',
                        surfaceDark: '#0f172a',
                    },
                    boxShadow: {
                        'soft': '0 20px 40px -15px rgba(0,0,0,0.05)',
                        'floating': '0 30px 60px -10px rgba(22, 163, 74, 0.15)',
                    }
                }
            }
        }
    </script>

    <style>
        body {
            background-color: #fafcfb;
            color: #1e293b;
            overflow-x: hidden;
        }

        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

        .glass-panel {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        @keyframes ticker {
            0% { transform: translate3d(0, 0, 0); }
            100% { transform: translate3d(-50%, 0, 0); }
        }
        .ticker-wrap { display: flex; width: max-content; animation: ticker 30s linear infinite; }
        .ticker-wrap:hover { animation-play-state: paused; }

        /* Step selector interactions */
        .step-node.active-step {
            border-color: #16a34a;
            background-color: rgba(22, 163, 74, 0.05);
        }
        .step-node.active-step .step-badge {
            background-color: #16a34a;
            color: white;
        }
    </style>
</head>
<body class="font-sans antialiased selection:bg-primary selection:text-white">

    
<!-- Footer Section -->
<footer class="bg-gray-50 pt-2 pb-1 mt-0 border-t border-gray-200">
  
  <!-- Pre-footer / Value Props (Like Flipkart/Adani) -->
  <div class="max-w-7xl mx-auto px-6 mb-2 grid grid-cols-1 md:grid-cols-3 gap-12 text-center">
    <div class="p-6">
      <div class="text-3xl mb-4 text-green-600">🌱</div>
      <h4 class="font-bold text-gray-900 mb-2">Farm Fresh</h4>
      <p class="text-sm text-gray-500">Direct from local farms to your kitchen in under 24 hours.</p>
    </div>
    <div class="p-6">
      <div class="text-3xl mb-4 text-green-600">🚚</div>
      <h4 class="font-bold text-gray-900 mb-2">Fast Delivery</h4>
      <p class="text-sm text-gray-500">Reliable delivery across your region with real-time tracking.</p>
    </div>
    <div class="p-6">
      <div class="text-3xl mb-4 text-green-600">🔒</div>
      <h4 class="font-bold text-gray-900 mb-2">Secure Payments</h4>
      <p class="text-sm text-gray-500">Encrypted transactions for a safe and seamless shopping experience.</p>
    </div>
  </div>

  <!-- Main Footer Content -->
  <div class="max-w-7xl mx-auto px-6 grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-16 mb-2">
    
    <!-- Brand Info -->
    <div class="col-span-2 lg:col-span-1 space-y-4">
      <h2 class="text-2xl font-black text-green-700">FarmDirect+</h2>
      <p class="text-gray-500 text-sm leading-relaxed">
        Building a sustainable future by connecting rural farmers with urban consumers. Quality you can trust.
      </p>
    </div>

    <!-- Links Groups -->
    <div>
      <h3 class="text-xs font-bold text-gray-900 uppercase tracking-widest mb-6">Explore</h3>
      <ul class="space-y-4 text-sm text-gray-600">
        <li><a href="index.php" class="hover:text-green-600 transition-colors">Home</a></li>
        <li><a href="about.html" class="hover:text-green-600 transition-colors">About Us</a></li>
        <li><a href="products.html" class="hover:text-green-600 transition-colors">Products</a></li>
        <li><a href="farmers.html" class="hover:text-green-600 transition-colors">Our Farmers</a></li>
      </ul>
    </div>

    <div>
      <h3 class="text-xs font-bold text-gray-900 uppercase tracking-widest mb-6">Support</h3>
      <ul class="space-y-4 text-sm text-gray-600">
        <li><a href="contact.php" class="hover:text-green-600 transition-colors">Contact Us</a></li>
        <li><a href="" class="hover:text-green-600 transition-colors">Track </a></li>
        <li><a href="#" class="hover:text-green-600 transition-colors">Return Policy</a></li>
        <li><a href="#" class="hover:text-green-600 transition-colors">Shipping</a></li>
      </ul>
    </div>

    <div>
      <h3 class="text-xs font-bold text-gray-900 uppercase tracking-widest mb-6">Resources</h3>
      <ul class="space-y-4 text-sm text-gray-600">
        <li><a href="#" class="hover:text-green-600 transition-colors">Privacy</a></li>
        <li><a href="#" class="hover:text-green-600 transition-colors">Terms of Service</a></li>
        <li><a href="#" class="hover:text-green-600 transition-colors">Sustainability</a></li>
      </ul>
    </div>

    <!-- Newsletter -->
    <div class="col-span-2 lg:col-span-1">
      <h3 class="text-xs font-bold text-gray-900 uppercase tracking-widest mb-6">Newsletter</h3>
      <p class="text-xs text-gray-500 mb-6">Subscribe for exclusive farm offers and seasonal discounts.</p>
      <!-- Newsletter Form inside your footer -->
<form id="newsletter-form" action="subscribe.php" method="POST" class="space-y-3">
  <input type="email" name="email" placeholder="Your email address" required 
         class="w-full bg-white px-4 py-3 border border-gray-200 rounded-lg text-black focus:border-green-500 outline-none transition-all">
  <button type="submit" class="w-full bg-gray-900 text-white py-3 rounded-lg hover:bg-green-600 transition-all font-medium text-sm">
    Subscribe
  </button>
</form>
    </div>
  </div>

  <!-- Copyright Strip -->
  <div class="max-w-12xl mx-auto px-7 border-t border- pt-8 text-center text-xm text-black">
    &copy; 2026 FarmDirect+ India. All rights reserved. 
    <span class="mx-2">|</span> 
    Operating in Guntakal, Andhra Pradesh.
  </div>
</footer>

<script>
document.getElementById('newsletter-form').addEventListener('submit', function(e) {
    e.preventDefault(); // This keeps you on the same page
    
    let formData = new FormData(this);
    
    fetch('subscribe.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        let status = data.trim();
        
        if(status === "success") {
            alert('Successfully subscribed! Thank you for joining us. 🎉');
            document.getElementById('newsletter-form').reset();
        } else if(status === "exists") {
            alert('You are already subscribed to our newsletter! 😊');
        } else {
            alert('Something went wrong. Please try again later.');
        }
    })
    .catch(error => {
        alert('Connection error. Please check your server.');
    });
});
</script>

