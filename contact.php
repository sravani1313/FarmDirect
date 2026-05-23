<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us | FarmDirect+</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root { --primary-green: #2e7d32; --light-green: #e8f5e9; --accent-orange: #f57c00; --text-dark: #333333; --text-light: #777777; --white: #ffffff; --bg-gray: #f9f9f9; }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { background-color: var(--white); color: var(--text-dark); line-height: 1.6; overflow-x: hidden; }
        .hidden-element { opacity: 0; transform: translateY(40px); transition: all 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94); }
        .show-element { opacity: 1; transform: translateY(0); }
        .delay-1 { transition-delay: 0.1s; } .delay-2 { transition-delay: 0.2s; }
        
        /* Navigation */
        header { background-color: var(--white); box-shadow: 0 2px 15px rgba(0,0,0,0.08); position: sticky; top: 0; z-index: 100; }
        .nav-container { max-width: 1200px; margin: 0 auto; padding: 15px 20px; display: flex; justify-content: space-between; align-items: center; }
        .logo { font-size: 26px; font-weight: 800; color: var(--primary-green); text-decoration: none; display: flex; align-items: center; gap: 10px; }
        .logo span { color: var(--accent-orange); }
        .nav-links { display: flex; gap: 30px; list-style: none; }
        .nav-links a { text-decoration: none; color: var(--text-dark); font-weight: 600; padding-bottom: 5px; }
        .nav-links a:hover { color: var(--primary-green); }
        .nav-icons { display: flex; gap: 25px; font-size: 22px; color: var(--text-dark); cursor: pointer; }
        
        /* Modern Animated Hero Section */
/* --- Premium Nav Style --- */
header { 
    background: #ffffff; 
    border-bottom: 1px solid #e5e7eb; 
    padding: 10px 0;
}
.nav-container { max-width: 1300px; }

/* --- Adani-Inspired Hero --- */
.page-header { 
    position: relative;
    height: 60vh; /* Taller for more impact */
    display: flex; 
    align-items: center; 
    background-color: #f8f9fa;
    overflow: hidden;
}

/* Right-side image with a slanted clip-path */
.hero-image {
    position: absolute;
    right: 0;
    top: 0;
    width: 50%;
    height: 100%;
    background: url('https://images.unsplash.com/photo-1495908333425-29a1e0918c5f?auto=format&fit=crop&w=2000&q=80') center/cover;
    clip-path: polygon(15% 0, 100% 0, 100% 100%, 0% 100%);
    animation: slideInRight 1.5s ease-out;
}

/* Left-side Text Container */
.hero-content {
    padding-left: 10%;
    max-width: 600px;
    z-index: 1;
}

.hero-content h1 {
    font-size: 4.5rem;
    color: #1a1a1a;
    line-height: 1.1;
    margin-bottom: 20px;
    animation: fadeInUp 1s ease-out;
}

.hero-content p {
    font-size: 1.2rem;
    color: #555;
    animation: fadeInUp 1.2s ease-out;
}

/* Animations */
@keyframes slideInRight {
    0% { transform: translateX(100px); opacity: 0; }
    100% { transform: translateX(0); opacity: 1; }
}

@keyframes fadeInUp {
    0% { opacity: 0; transform: translateY(30px); }
    100% { opacity: 1; transform: translateY(0); }
}
/* --- Premium Nav Style --- */
header { 
    background: #ffffff; 
    border-bottom: 1px solid #e5e7eb; 
    padding: 10px 0;
}
.nav-container { max-width: 1300px; }

/* --- Adani-Inspired Hero --- */
.page-header { 
    position: relative;
    height: 60vh; /* Taller for more impact */
    display: flex; 
    align-items: center; 
    background-color: #f8f9fa;
    overflow: hidden;
}

/* Right-side image with a slanted clip-path */
.hero-image {
    position: absolute;
    right: 0;
    top: 0;
    width: 50%;
    height: 100%;
    background: url('https://images.unsplash.com/photo-1495908333425-29a1e0918c5f?auto=format&fit=crop&w=2000&q=80') center/cover;
    clip-path: polygon(15% 0, 100% 0, 100% 100%, 0% 100%);
    animation: slideInRight 1.5s ease-out;
}

/* Left-side Text Container */
.hero-content {
    padding-left: 10%;
    max-width: 600px;
    z-index: 1;
}

.hero-content h1 {
    font-size: 4.5rem;
    color: #1a1a1a;
    line-height: 1.1;
    margin-bottom: 20px;
    animation: fadeInUp 1s ease-out;
}

.hero-content p {
    font-size: 1.2rem;
    color: #555;
    animation: fadeInUp 1.2s ease-out;
}

/* Animations */
@keyframes slideInRight {
    0% { transform: translateX(100px); opacity: 0; }
    100% { transform: translateX(0); opacity: 1; }
}

@keyframes fadeInUp {
    0% { opacity: 0; transform: translateY(30px); }
    100% { opacity: 1; transform: translateY(0); }
}

/* Glassmorphism Overlay */
.hero-content {
    position: relative;
    padding: 30px 60px;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 20px;
    animation: revealContent 1.2s cubic-bezier(0.16, 1, 0.3, 1);
}

.page-header h1 { 
    font-size: 3.5rem;
    letter-spacing: -1px;
    text-shadow: 0 4px 10px rgba(0,0,0,0.3);
}

@keyframes slowDrift {
    0% { transform: scale(1) translate(0, 0); }
    100% { transform: scale(1.1) translate(-2%, -2%); }
}

@keyframes revealContent {
    0% { opacity: 0; transform: scale(0.9); }
    100% { opacity: 1; transform: scale(1); }
}

        /* Contact Section */
        .contact-container { max-width: 1200px; margin: 80px auto; padding: 0 20px; display: grid; grid-template-columns: 1fr 1fr; gap: 60px; }
        
        /* Left: Info */
        .contact-info { padding-right: 40px; }
        .contact-info h2 { font-size: 2.5rem; color: var(--primary-green); margin-bottom: 20px; }
        .contact-info p { font-size: 1.1rem; color: var(--text-light); margin-bottom: 40px; }
        .info-card { display: flex; align-items: flex-start; gap: 20px; margin-bottom: 35px; }
        .info-card-icon { width: 60px; height: 60px; background-color: var(--light-green); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--primary-green); font-size: 1.5rem; flex-shrink: 0; transition: transform 0.3s; }
        .info-card:hover .info-card-icon { transform: scale(1.1) rotate(10deg); background-color: var(--primary-green); color: white; }
        .info-card-text h4 { font-size: 1.2rem; color: var(--text-dark); margin-bottom: 5px; }
        .info-card-text p { font-size: 1.05rem; margin: 0; color: var(--text-light); }

        /* Right: Form */
        .contact-form { background: var(--white); padding: 50px; border-radius: 20px; box-shadow: 0 15px 40px rgba(0,0,0,0.08); }
        .form-group { margin-bottom: 25px; }
        .form-group label { display: block; font-weight: 600; margin-bottom: 8px; color: var(--text-dark); }
        .form-group input, .form-group textarea { width: 100%; padding: 15px; border: 1px solid #ddd; border-radius: 10px; font-size: 1rem; font-family: inherit; transition: border-color 0.3s, box-shadow 0.3s; outline: none; }
        .form-group textarea { resize: vertical; min-height: 150px; }
        .form-group input:focus, .form-group textarea:focus { border-color: var(--primary-green); box-shadow: 0 0 0 3px var(--light-green); }
        .submit-btn { width: 100%; padding: 18px; background: var(--accent-orange); color: white; border: none; border-radius: 10px; font-size: 1.2rem; font-weight: bold; cursor: pointer; transition: all 0.3s; box-shadow: 0 8px 20px rgba(245, 124, 0, 0.3); }
        .submit-btn:hover { background: #e65100; transform: translateY(-3px); box-shadow: 0 12px 25px rgba(245, 124, 0, 0.4); }

        /* Footer */
        footer { background-color: #1a1a1a; color: #ddd; padding: 70px 20px 30px; margin-top: 60px; }
        .footer-content { max-width: 1200px; margin: 0 auto; display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 50px; }
        .footer-section h3 { color: var(--white); margin-bottom: 25px; }
        .footer-section ul { list-style: none; }
        .footer-section ul li { margin-bottom: 15px; }
        .footer-section a { color: #bbb; text-decoration: none; }
        .footer-bottom { text-align: center; padding-top: 30px; margin-top: 40px; border-top: 1px solid #333; }

        @media (max-width: 900px) { .contact-container { grid-template-columns: 1fr; } .contact-info { padding-right: 0; } }
    </style>
</head>
<body>
    <header>
    <div class="nav-container">
        <a href="home.html" class="logo">
            <i class="fas fa-leaf"></i> FarmDirect<span>+</span>
        </a>

        <ul class="nav-links">
            <li><a href="index.php">Home</a></li>
            <li><a href="about.html">About Us</a></li>
            <li><a href="shop.php">Shop</a></li>
            <li><a href="farmers.html">Our Farmers</a></li>
            <li><a href="subscription.html">Subscriptions</a></li>
            <li><a href="contact.php">Contact</a></li>
        </ul>

        <div class="nav-icons">
            
            
            <a href="login.php" style="color: inherit;"><i class="fas fa-user" title="Login"></i></a>
            
        </div>
    </div>
</header>
<div class="page-header">
    <div class="hero-content">
        <h1>Building a <br><span style="color: var(--primary-green);">Sustainable</span> Future.</h1>
        <p>At FarmDirect+, we combine scale, technology, and commitment to empower farmers across the nation.</p>
    </div>
    <div class="hero-image"></div>
</div>
    
    <div class="contact-container">
        <!-- Contact Info -->
        <div class="contact-info hidden-element delay-1">
            <h2>We'd Love to Hear From You</h2>
            <p>Whether you have a question about our organic certification, a delivery inquiry, or just want to chat about farming, our team is ready to answer all your questions.</p>
            
            <div class="info-card">
                <div class="info-card-icon"><i class="fas fa-map-marker-alt"></i></div>
                <div class="info-card-text">
                    <h4>Our Farm Headquarters</h4>
                    <p>123 Farmville Road, Agritown, ST 12345</p>
                </div>
            </div>
            
            <div class="info-card">
                <div class="info-card-icon"><i class="fas fa-envelope"></i></div>
                <div class="info-card-text">
                    <h4>Email Us</h4>
                    <p>support@farmdirectplus.com</p>
                </div>
            </div>
            
            <div class="info-card">
                <div class="info-card-icon"><i class="fas fa-phone-alt"></i></div>
                <div class="info-card-text">
                    <h4>Call Us</h4>
                    <p>+1 (555) 987-6543<br><span style="font-size: 0.9rem;">Mon-Fri, 8am - 6pm</span></p>
                </div>
            </div>
        </div>

        <!-- Contact Form -->
        <div class="contact-form hidden-element delay-2">
            <form action="contact_action.php" method="POST">
                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" name="name" placeholder="Jane Doe" required>
                </div>
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" name="email" placeholder="jane@example.com" required>
                </div>
                <div class="form-group">
                    <label>Subject</label>
                    <input type="text" name="subject" placeholder="How can we help?" required>
                </div>
                <div class="form-group">
                    <label>Message</label>
                    <textarea name="message" placeholder="Write your message here..." required></textarea>
                </div>
                <button type="submit" class="submit-btn">Send Message <i class="fas fa-paper-plane" style="margin-left: 5px;"></i></button>
            </form>
        </div>
    </div>

    

    <script>
        const observer = new IntersectionObserver((entries, obs) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) { entry.target.classList.add('show-element'); obs.unobserve(entry.target); }
            });
        }, { threshold: 0.15 });
        document.querySelectorAll('.hidden-element').forEach(el => observer.observe(el));

        function submitForm(btn) {
            const originalText = btn.innerHTML;
            btn.innerHTML = "<i class='fas fa-spinner fa-spin'></i> Sending...";
            setTimeout(() => {
                btn.style.backgroundColor = "var(--primary-green)";
                btn.innerHTML = "✓ Message Sent!";
                document.querySelector('form').reset();
                setTimeout(() => {
                    btn.innerHTML = originalText;
                    btn.style.backgroundColor = "var(--accent-orange)";
                }, 3000);
            }, 1500);
        }
    </script>
</body>
</html>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us | FarmDirect+</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root { --primary-green: #2e7d32; --light-green: #e8f5e9; --accent-orange: #f57c00; --text-dark: #333333; --text-light: #777777; --white: #ffffff; --bg-gray: #f9f9f9; }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { background-color: var(--white); color: var(--text-dark); line-height: 1.6; overflow-x: hidden; }
        .hidden-element { opacity: 0; transform: translateY(40px); transition: all 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94); }
        .show-element { opacity: 1; transform: translateY(0); }
        .delay-1 { transition-delay: 0.1s; } .delay-2 { transition-delay: 0.2s; }
        
        header { background: #ffffff; border-bottom: 1px solid #e5e7eb; padding: 10px 0; position: sticky; top: 0; z-index: 100; }
        .nav-container { max-width: 1300px; margin: 0 auto; padding: 0 20px; display: flex; justify-content: space-between; align-items: center; }
        .logo { font-size: 26px; font-weight: 800; color: var(--primary-green); text-decoration: none; display: flex; align-items: center; gap: 10px; }
        .logo span { color: var(--accent-orange); }
        .nav-links { display: flex; gap: 30px; list-style: none; }
        .nav-links a { text-decoration: none; color: var(--text-dark); font-weight: 600; }
        
        /* ... (Keep your existing Hero and Contact CSS) ... */
        .page-header { position: relative; height: 60vh; display: flex; align-items: center; background-color: #f8f9fa; overflow: hidden; }
        .hero-image { position: absolute; right: 0; top: 0; width: 50%; height: 100%; background: url('https://images.unsplash.com/photo-1495908333425-29a1e0918c5f?auto=format&fit=crop&w=2000&q=80') center/cover; clip-path: polygon(15% 0, 100% 0, 100% 100%, 0% 100%); }
        .hero-content { padding-left: 10%; max-width: 600px; z-index: 1; }
        .contact-container { max-width: 1200px; margin: 80px auto; padding: 0 20px; display: grid; grid-template-columns: 1fr 1fr; gap: 60px; }
    </style>
</head>
<body>

    

    

    <footer class="bg-gray-50 pt-1 pb-8 mt- border-t border-gray-0">
        <div class="max-w-7xl mx-auto px-6 mb-12 grid grid-cols-1 md:grid-cols-3 gap-12 text-center">
            <div class="p-6">
                <div class="text-3xl mb-4">🌱</div>
                <h4 class="font-bold text-gray-900 mb-2">Farm Fresh</h4>
                <p class="text-sm text-gray-500">Direct from local farms to your kitchen in under 24 hours.</p>
            </div>
            <div class="p-6">
                <div class="text-3xl mb-4">🚚</div>
                <h4 class="font-bold text-gray-900 mb-2">Fast Delivery</h4>
                <p class="text-sm text-gray-500">Reliable delivery across your region with real-time tracking.</p>
            </div>
            <div class="p-6">
                <div class="text-3xl mb-4">🔒</div>
                <h4 class="font-bold text-gray-900 mb-2">Secure Payments</h4>
                <p class="text-sm text-gray-500">Encrypted transactions for a safe and seamless shopping experience.</p>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-6 grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-16 mb-2">
            <div class="col-span-2 lg:col-span-1 space-y-4">
                <h2 class="text-2xl font-black text-green-700">FarmDirect+</h2>
                <p class="text-gray-500 text-sm">Building a sustainable future by connecting rural farmers with urban consumers.</p>
            </div>
            <div>
                
      <h3 class="text-xs font-bold text-gray-900 uppercase tracking-widest mb-2">Explore</h3>
      <ul class="space-y-4 text-sm text-gray-600">
        <li><a href="index.php" class="hover:text-green-600 transition-colors">Home</a></li>
        <li><a href="about.html" class="hover:text-green-600 transition-colors">About Us</a></li>
        <li><a href="products.html" class="hover:text-green-600 transition-colors">Products</a></li>
        <li><a href="farmers.html" class="hover:text-green-600 transition-colors">Our Farmers</a></li>
      </ul>
    </div>

    <div>
      <h3 class="text-xs font-bold text-gray-900 uppercase tracking-widest mb-2">Support</h3>
      <ul class="space-y-4 text-sm text-gray-600">
        <li><a href="contact.php" class="hover:text-green-600 transition-colors">Contact Us</a></li>
        <li><a href="" class="hover:text-green-600 transition-colors">Track </a></li>
        <li><a href="#" class="hover:text-green-600 transition-colors">Return Policy</a></li>
        <li><a href="#" class="hover:text-green-600 transition-colors">Shipping</a></li>
      </ul>
    </div>

    <div>
      <h3 class="text-xs font-bold text-gray-900 uppercase tracking-widest mb-2">Resources</h3>
      <ul class="space-y-4 text-sm text-gray-600">
        <li><a href="#" class="hover:text-green-600 transition-colors">Privacy</a></li>
        <li><a href="#" class="hover:text-green-600 transition-colors">Terms of Service</a></li>
        <li><a href="#" class="hover:text-green-600 transition-colors">Sustainability</a></li>
      </ul>
    </div>

    <!-- Newsletter -->
    <div class="col-span-2 lg:col-span-1">
      <h3 class="text-xs font-bold text-gray-900 uppercase tracking-widest mb-2">Newsletter</h3>
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
                    
                
            

        <div class="max-w-7xl mx-auto px-6 border-t pt-8 text-center text-sm text-gray-600">
            &copy; 2026 FarmDirect+ India. All rights reserved. | Operating in Guntakal, Andhra Pradesh.
        </div>
    </footer>

    <script>
        document.getElementById('newsletter-form').addEventListener('submit', function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            fetch('subscribe.php', { method: 'POST', body: formData })
            .then(res => res.text())
            .then(data => {
                let status = data.trim();
                if(status === "success") { alert('Successfully subscribed! 🎉'); this.reset(); }
                else if(status === "exists") { alert('Already subscribed! 😊'); }
                else { alert('Error. Please try again.'); }
            });
        });
    </script>
</body>
</html>



