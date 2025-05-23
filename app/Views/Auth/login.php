<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login and Registration</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f5f5f5;
            background-image: url('<?= base_url('images/bglogin.jpg') ?>');
            background-size: cover;         /* Membuat gambar menutupi seluruh area */
            background-repeat: no-repeat;   /* Mencegah gambar diulang */
            background-position: center;    /* Posisikan gambar di tengah */
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }
        
        .container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            overflow: hidden;
        }
        
        .tabs {
            display: flex;
            background-color: #f8f9fa;
        }
        
        .tab {
            flex: 1;
            text-align: center;
            padding: 15px;
            cursor: pointer;
            font-weight: 600;
            transition: background-color 0.3s;
        }
        
        .tab.active {
            background-color: white;
            border-bottom: 3px solid #4a6cfa;
            color: #4a6cfa;
        }
        
        .form-container {
            padding: 30px;
        }
        
        .form {
            display: none;
        }
        
        .form.active {
            display: block;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #333;
        }
        
        .form-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            transition: border-color 0.3s;
        }
        
        .form-group input:focus {
            outline: none;
            border-color: #4a6cfa;
        }
        
        .password-container {
            position: relative;
        }
        
        .toggle-password {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #777;
            user-select: none;
        }
        
        .btn {
            width: 100%;
            padding: 12px;
            background-color: #4a6cfa;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        
        .btn:hover {
            background-color: #3a5ce4;
        }
        
        .switch-form {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #666;
        }
        
        .switch-form a {
            color: #4a6cfa;
            text-decoration: none;
            font-weight: 600;
            cursor: pointer;
        }
        
        .switch-form a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="tabs">
            <div class="tab active" id="tab-login">Login</div>
            <div class="tab" id="tab-register">Register</div>
        </div>
        
        <div class="form-container">
            <?php if (!empty($error)) : ?>
                <div style="color: #fff; background: #e74c3c; padding: 10px 15px; border-radius: 5px; margin-bottom: 15px;">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>
            <?php if (!empty($success)) : ?>
                <div style="color: #fff; background: #27ae60; padding: 10px 15px; border-radius: 5px; margin-bottom: 15px;">
                    <?= htmlspecialchars($success) ?>
                </div>
            <?php endif; ?>
            <!-- Login Form -->
            <form class="form active" id="login-form" method="post" action="<?= site_url('login') ?>">
                <div class="form-group">
                    <label for="login-username">Username</label>
                    <input type="text" id="login-username" name="username" placeholder="Enter your username" required>
                </div>
                <div class="form-group">
                    <label for="login-password">Password</label>
                    <div class="password-container">
                        <input type="password" id="login-password" name="password" placeholder="Enter your password" required>
                        <span class="toggle-password" onclick="togglePassword('login-password', this)">👁️</span>
                    </div>
                </div>
                <button type="submit" class="btn">Login</button>
                <div class="switch-form">
                    Don't have an account? <a id="switch-to-register">Register now</a>
                </div>
            </form>
            
            <!-- Registration Form -->
            <form class="form" id="register-form" method="post" action="<?= site_url('register') ?>">
                <div class="form-group">
                    <label for="register-fullname">Full Name</label>
                    <input type="text" id="register-fullname" name="fullname" placeholder="Enter your full name" required>
                </div>
                <div class="form-group">
                    <label for="register-username">Username</label>
                    <input type="text" id="register-username" name="username" placeholder="Choose a username" required>
                </div>
                <div class="form-group">
                    <label for="register-email">Email</label>
                    <input type="email" id="register-email" name="email" placeholder="Enter your email" required>
                </div>
                <div class="form-group">
                    <label for="register-password">Password</label>
                    <div class="password-container">
                        <input type="password" id="register-password" name="password" placeholder="Create a password" required>
                        <span class="toggle-password" onclick="togglePassword('register-password', this)">👁️</span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="register-phone">Phone Number</label>
                    <input type="tel" id="register-phone" name="phone" placeholder="Enter your phone number" required>
                </div>
                <button type="submit" class="btn">Register</button>
                <div class="switch-form">
                    Already have an account? <a id="switch-to-login">Login now</a>
                </div>
            </form>
        </div>
    </div>
    
    <script>
        // Tab switching functionality
        document.getElementById('tab-login').addEventListener('click', function() {
            switchTab('login');
        });
        
        document.getElementById('tab-register').addEventListener('click', function() {
            switchTab('register');
        });
        
        document.getElementById('switch-to-register').addEventListener('click', function() {
            switchTab('register');
        });
        
        document.getElementById('switch-to-login').addEventListener('click', function() {
            switchTab('login');
        });
        
        function switchTab(tab) {
            // Update tab status
            document.getElementById('tab-login').classList.toggle('active', tab === 'login');
            document.getElementById('tab-register').classList.toggle('active', tab === 'register');
            
            // Show/hide forms
            document.getElementById('login-form').classList.toggle('active', tab === 'login');
            document.getElementById('register-form').classList.toggle('active', tab === 'register');
        }
        
        // Toggle password visibility
        function togglePassword(inputId, toggleBtn) {
            const passwordInput = document.getElementById(inputId);
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleBtn.textContent = '🔒';
            } else {
                passwordInput.type = 'password';
                toggleBtn.textContent = '👁️';
            }
        }
    </script>
</body>
</html>