<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | FarmDirect+</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root { --primary-green: #2e7d32; --light-green: #e8f5e9; --accent-orange: #f57c00; --text-dark: #333333; --text-light: #777777; --white: #ffffff; --bg-gray: #f9f9f9; }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { background: linear-gradient(135deg, var(--light-green) 0%, #c8e6c9 100%); color: var(--text-dark); height: 100vh; display: flex; align-items: center; justify-content: center; }
        
        .auth-container { background: var(--white); width: 100%; max-width: 450px; padding: 50px 40px; border-radius: 20px; box-shadow: 0 20px 50px rgba(0,0,0,0.1); position: relative; overflow: hidden; }
        
        .logo { font-size: 28px; font-weight: 800; color: var(--primary-green); text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 10px; margin-bottom: 30px; }
        .logo span { color: var(--accent-orange); }

        .auth-tabs { display: flex; margin-bottom: 30px; border-bottom: 2px solid #eee; }
        .tab { flex: 1; text-align: center; padding: 15px; cursor: pointer; font-weight: 600; color: var(--text-light); transition: all 0.3s; }
        .tab.active { color: var(--primary-green); border-bottom: 3px solid var(--primary-green); }

        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 600; font-size: 0.9rem; }
        .form-group input { width: 100%; padding: 15px; border: 1px solid #ddd; border-radius: 10px; outline: none; transition: 0.3s; }
        .form-group input:focus { border-color: var(--primary-green); box-shadow: 0 0 0 3px var(--light-green); }
        
        .forgot-pass { display: block; text-align: right; color: var(--primary-green); font-size: 0.85rem; text-decoration: none; margin-bottom: 20px; font-weight: 600; }
        
        .auth-btn { width: 100%; padding: 16px; background: var(--primary-green); color: white; border: none; border-radius: 10px; font-size: 1.1rem; font-weight: bold; cursor: pointer; transition: all 0.3s; box-shadow: 0 5px 15px rgba(46, 125, 50, 0.3); }
        .auth-btn:hover { background: #1b5e20; transform: translateY(-2px); }

        .back-home { display: block; text-align: center; margin-top: 25px; color: var(--text-light); text-decoration: none; font-size: 0.9rem; transition: color 0.3s; }
        .back-home:hover { color: var(--primary-green); }

        /* Form Toggle Logic */
        #register-form { display: none; }
    </style>
</head>
<body>

    <div class="auth-container">
        <a href="home.html" class="logo"><i class="fas fa-leaf"></i> FarmDirect<span>+</span></a>
        
        <div class="auth-tabs">
            <div class="tab active" onclick="switchTab('login')" id="tab-login">Login</div>
            <div class="tab" onclick="switchTab('register')" id="tab-register">Register</div>
        </div>

        <!-- Login Form -->
         <form id="login-form" action="login_actions.php" method="POST">
    <div class="form-group">
        <label>Email Address</label>
        <input type="email" name="email" placeholder="you@example.com" required>
    </div>
    <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" placeholder="••••••••" required>
    </div>
    <a href="#" class="forgot-pass">Forgot Password?</a>
    <button type="submit" class="auth-btn">Sign In</button>
</form>
        

        <!-- Register Form -->
        <!-- Register Form -->
<form id="register-form" action="register.php" method="POST">
    <div class="form-group">
        <label>Full Name</label>
        <input type="text" name="fullname" placeholder="John Doe" required>
    </div>
    <div class="form-group">
        <label>Email Address</label>
        <input type="email" name="email" placeholder="you@example.com" required>
    </div>
    <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" placeholder="Create a password" required>
    </div>
    <!-- ADDED ROLE SELECTION -->
    <div class="form-group">
        <label>Account Type</label>
        <select name="role" required style="width: 100%; padding: 15px; border: 1px solid #ddd; border-radius: 10px; outline: none; background: white; font-family: inherit;">
            <option value="user">Customer</option>
            <option value="farmer">Farmer</option>
        </select>
    </div>
    <button type="submit" class="auth-btn">Create Account</button>
</form>

        <a href="home.html" class="back-home"><i class="fas fa-arrow-left"></i> Back to Store</a>
    </div>

    <script>
        function switchTab(tab) {
            const loginForm = document.getElementById('login-form');
            const registerForm = document.getElementById('register-form');
            const tabLogin = document.getElementById('tab-login');
            const tabRegister = document.getElementById('tab-register');

            if (tab === 'login') {
                loginForm.style.display = 'block';
                registerForm.style.display = 'none';
                tabLogin.classList.add('active');
                tabRegister.classList.remove('active');
            } else {
                loginForm.style.display = 'none';
                registerForm.style.display = 'block';
                tabRegister.classList.add('active');
                tabLogin.classList.remove('active');
            }
        }
    </script>
</body>
</html>