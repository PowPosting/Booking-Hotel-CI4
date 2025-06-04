<?php
?>
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
            background-image: url('<?= base_url('images/bglogin3.jpg') ?>');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
            position: relative;
        }
        
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('<?= base_url('images/bglogin3.jpg') ?>');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            filter: blur(5px);
            z-index: -1;
        }
        
        /* Back Button Styles */
        .back-button {
            position: absolute;
            top: 20px;
            left: 20px;
            background-color: rgba(255, 255, 255, 0.9);
            color: #4a6cfa;
            border: 2px solid #4a6cfa;
            border-radius: 50px;
            padding: 12px 20px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
    
        
        .back-button i {
            font-size: 16px;
        }
        
        .container {
            background-color: rgba(255, 255, 255, 0.95);
            border-radius: 10px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
            overflow: hidden;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            position: relative;
            z-index: 1;
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

        /* Responsive Design */
        @media (max-width: 768px) {
            .back-button {
                top: 10px;
                left: 10px;
                padding: 10px 16px;
                font-size: 12px;
            }
        }
    </style>
    <!-- FontAwesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <!-- Back Button -->
    <a href="<?= base_url('/') ?>" class="back-button">
        <i class="fas fa-arrow-left"></i>
        Kembali ke Beranda
    </a>

    <div class="container">
        <div class="tabs">
            <div class="tab active" id="tab-login">Login</div>
            <div class="tab" id="tab-register">Register</div>
        </div>
        
        <div class="form-container">
            <h2 style="text-align: center;">Welcome!</h2>
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
                    <label for="register-confirm-password">Confirm Password</label>
                    <div class="password-container">
                        <input type="password" id="register-confirm-password" name="confirm_password" placeholder="Confirm your password" required>
                        <span class="toggle-password" onclick="togglePassword('register-confirm-password', this)">👁️</span>
                    </div>
                    <div id="password-match-error" style="color: #e74c3c; font-size: 12px; margin-top: 5px; display: none;">
                        Passwords do not match!
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
        
        // Password confirmation validation
        document.getElementById('register-confirm-password').addEventListener('input', function() {
            const password = document.getElementById('register-password').value;
            const confirmPassword = this.value;
            const errorDiv = document.getElementById('password-match-error');
            
            if (confirmPassword && password !== confirmPassword) {
                errorDiv.style.display = 'block';
                this.style.borderColor = '#e74c3c';
            } else {
                errorDiv.style.display = 'none';
                this.style.borderColor = '#ddd';
            }
        });
        
        // Form validation before submit
        document.getElementById('register-form').addEventListener('submit', function(e) {
            const password = document.getElementById('register-password').value;
            const confirmPassword = document.getElementById('register-confirm-password').value;
            
            if (password !== confirmPassword) {
                e.preventDefault();
                alert('Passwords do not match!');
                return false;
            }
            
            if (password.length < 6) {
                e.preventDefault();
                alert('Password must be at least 6 characters long!');
                return false;
            }
        });
    </script>
</body>
</html>