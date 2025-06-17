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
            background-color: #f7fafc; 
            background-image: url('<?= base_url('images/bglogin4.jpg') ?>');
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
            background-image: url('<?= base_url('images/bglogin4.jpg') ?>');
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
            background-color: rgba(255, 255, 255, 0.95);
            color: #5a67d8; 
            border: 2px solid #e2e8f0; 
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
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08); 
            z-index: 10;
        }
        
        .back-button:hover {
            background-color: #5a67d8; 
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(90, 103, 216, 0.25);
            border-color: #5a67d8;
        }

        .container {
            background-color: rgba(255, 255, 255, 0.98); 
            border-radius: 12px; 
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1); 
            width: 100%;
            max-width: 450px; 
            max-height: 90vh; 
            overflow-y: auto; 
            backdrop-filter: blur(10px);
            border: 1px solid rgba(226, 232, 240, 0.6); 
            position: relative;
            z-index: 1;
        }
        
        .form-container {
            padding: 30px 25px 25px; 
        }
        
        .form-title {
            text-align: center;
            margin-bottom: 20px;
            color: #2d3748; 
            font-size: 24px; 
            font-weight: 700;
        }
        
        .form {
            display: none;
        }
        
        .form.active {
            display: block;
        }
        
        .form-group {
            margin-bottom: 15px; 
        }
        
        .form-group label {
            display: block;
            margin-bottom: 5px; 
            font-weight: 500;
            color: #4a5568; 
            font-size: 14px;
        }
        
        .form-group input, .form-group select {
            width: 100%;
            padding: 10px; 
            border: 2px solid #e2e8f0; 
            border-radius: 6px; 
            font-size: 14px;
            transition: border-color 0.3s;
            background-color: #f7fafc; 
            color: #2d3748; 
        }
        
        .form-group input:focus {
            outline: none;
            border-color: #5a67d8; 
            box-shadow: 0 0 0 3px rgba(90, 103, 216, 0.1); 
            background-color: white;
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
            color: #718096; 
            user-select: none;
        }
        
        .toggle-password:hover {
            color: #5a67d8; 
        }
        
        .btn {
            width: 100%;
            padding: 12px; 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
            color: white;
            border: none;
            border-radius: 6px; 
            font-size: 15px; 
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 8px; 
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }
        
        .btn:hover {
            background: linear-gradient(135deg, #5a67d8 0%, #667eea 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(90, 103, 216, 0.4);
        }
        
        .switch-form {
            text-align: center;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid #eee;
            font-size: 13px;
            color: #666;
        }
        
        .switch-form a {
            color: #5a67d8; 
            text-decoration: none;
            font-weight: 600;
            cursor: pointer;
            padding: 2px 4px;
            border-radius: 4px;
            transition: background-color 0.3s;
        }
        
        .switch-form a:hover {
            background-color: rgba(90, 103, 216, 0.1); 
        }

        /* Alert Messages */
        .alert {
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
        }
        
        .alert-error {
            color: #c53030;
            background-color: #fed7d7; 
            border: 1px solid #feb2b2; 
        }
        
        .alert-success {
            color: #38a169; 
            background-color: #c6f6d5; 
            border: 1px solid #9ae6b4; 
        }

        /* Forgot Password Styles */
        .forgot-password {
            text-align: right;
            margin-bottom: 20px;
        }
        
        .forgot-password a {
            color: #5a67d8; 
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
        }
        
        .forgot-password a:hover {
            text-decoration: underline;
        }

        /* Security Question Section - Kompak */
        .security-section {
            margin-bottom: 15px;
        }
        
        .security-section h6 {
            color: #4a5568; 
            background-color: #edf2f7; 
            padding: 8px 12px;
            border-radius: 6px;
            border-left: 4px solid #5a67d8; 
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        #question-display {
            background-color: #edf2f7 !important; 
            border: 2px solid #e2e8f0 !important; 
            color: #4a5568 !important; 
            padding: 10px;
            border-radius: 6px;
            font-weight: 500;
            font-size: 13px;
        }

        /* Validation States */
        .form-group input.is-valid {
            border-color: #28a745;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%2328a745' d='m2.3 6.73.7-.7 1.71-1.7 2.43-2.43.7-.7-.7-.7-.7.7-2.43 2.43-1.71 1.7-.7.7z'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right calc(0.375em + 0.1875rem) center;
            background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
        }

        .form-group input.is-invalid {
            border-color: #dc3545;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath d='m5.8 4.6 2.4 2.4M8.2 4.6l-2.4 2.4'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right calc(0.375em + 0.1875rem) center;
            background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
        }

        .text-success {
            color: #28a745 !important;
        }

        .text-danger {
            color: #dc3545 !important;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .back-button {
                top: 10px;
                left: 10px;
                padding: 10px 16px;
                font-size: 12px;
            }
            
            .form-container {
                padding: 30px 20px 20px;
            }
            
            .form-title {
                font-size: 24px;
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
        <div class="form-container">
            <?php if (!empty($error)) : ?>
                <div class="alert alert-error">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>
            <?php if (!empty($success)) : ?>
                <div class="alert alert-success">
                    <?= htmlspecialchars($success) ?>
                </div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('errors')): ?>
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        <?php foreach (session()->getFlashdata('errors') as $error): ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach ?>
                    </ul>
                </div>
            <?php endif ?>
            
            <!-- Login Form -->
            <form class="form active" id="login-form" method="post" action="<?= site_url('login') ?>">
                <h2 class="form-title">Welcome Back!</h2>
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
                
                <!-- Forgot Password Link -->
                <div class="forgot-password">
                    <a href="#" id="forgot-password-link">Forgot your password?</a>
                </div>
                
                <button type="submit" class="btn">
                    <i class="fas fa-sign-in-alt me-2"></i>Login
                </button>
                <div class="switch-form">
                    Don't have an account? <a id="switch-to-register">Create one here</a>
                </div>
            </form>
            
            <!-- Registration Form -->
            <form class="form" id="register-form" method="post" action="<?= site_url('register') ?>">
                <h2 class="form-title">Create Account</h2>
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
                    <label for="register_password">Password</label>
                    <div class="password-container">
                        <input type="password" id="register_password" name="password" 
                               pattern="^(?=.*[a-zA-Z])(?=.*\d)[A-Za-z\d@$!%*?&]{6,}$"
                               title="Password minimal 6 karakter, harus mengandung huruf dan angka"
                               minlength="6"
                               required>
                        <span class="toggle-password" onclick="togglePassword('register_password', this)">
                            <i class="fas fa-eye"></i>
                        </span>
                    </div>
                    <small class="text-muted">Minimal 6 karakter, kombinasi huruf dan angka</small>
                </div>
                <div class="form-group">
                    <label for="confirm_password">Konfirmasi Password</label>
                    <div class="password-container">
                        <input type="password" id="confirm_password" name="confirm_password" 
                               pattern="^(?=.*[a-zA-Z])(?=.*\d)[A-Za-z\d@$!%*?&]{6,}$"
                               title="Konfirmasi password harus sama"
                               minlength="6"
                               required>
                        <span class="toggle-password" onclick="togglePassword('confirm_password', this)">
                            <i class="fas fa-eye"></i>
                        </span>
                    </div>
                    <small class="text-muted">Ulangi password yang sama</small>
                </div>
                <div class="form-group">
                    <label for="register-phone">Phone Number</label>
                    <input type="tel" id="register-phone" name="phone" placeholder="Enter your phone number" required>
                </div>
                
                <!-- Security Question Section - Kompak -->
                <div class="security-section">
                    <h6><i class="fas fa-shield-alt"></i> Security Question</h6>
                    <div class="form-group">
                        <label for="security-question">Pertanyaan Keamanan</label>
                        <select id="security-question" name="security_question" required>
                            <option value="">-- Pilih Pertanyaan --</option>
                            <option value="pet_name">Nama hewan peliharaan pertama?</option>
                            <option value="birth_city">Kota kelahiran?</option>
                            <option value="school_name">Nama sekolah dasar?</option>
                            <option value="mother_maiden">Nama gadis ibu?</option>
                            <option value="favorite_food">Makanan favorit?</option>
                            <option value="favorite_color">Warna favorit?</option>
                            <option value="best_friend">Nama sahabat terbaik?</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="security-answer">Jawaban</label>
                        <input type="text" id="security-answer" name="security_answer" placeholder="Jawaban (huruf kecil)" required style="text-transform: lowercase;">
                        <small>* Jawaban disimpan dalam huruf kecil</small>
                    </div>
                </div>
                
                <button type="submit" class="btn">
                    <i class="fas fa-user-plus me-2"></i>Create Account
                </button>
                <div class="switch-form">
                    Already have an account? <a id="switch-to-login">Login here</a>
                </div>
            </form>

            <!-- Forgot Password Form -->
            <form class="form" id="forgot-password-form" method="post" action="<?= site_url('forgot-password') ?>">
                <h2 class="form-title">Reset Password</h2>
                <p style="text-align: center; color: #666; margin-bottom: 25px; font-size: 14px;">
                    Masukkan username dan jawab pertanyaan keamanan untuk reset password.
                </p>
                
                <div class="form-group">
                    <label for="forgot-username">Username</label>
                    <input type="text" id="forgot-username" name="username" placeholder="Enter your username" required>
                </div>
                
                <div id="security-section" style="display: none;">
                    <div class="form-group">
                        <label for="security-question-display">Security Question</label>
                        <div id="question-display" style="background-color: #edf2f7; padding: 10px; border: 1px solid #ddd; border-radius: 6px; font-weight: 500; font-size: 13px;">
                            <!-- Question will be loaded here -->
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="security-answer-input">Your Answer</label>
                        <input type="text" id="security-answer-input" name="security_answer" placeholder="Masukkan jawaban Anda" style="text-transform: lowercase;">
                    </div>
                </div>
                
                <button type="button" id="check-username-btn" class="btn">
                    <i class="fas fa-search me-2"></i>Check Username
                </button>
                
                <button type="submit" id="reset-password-btn" class="btn" style="display: none;">
                    <i class="fas fa-key me-2"></i>Reset Password
                </button>
                
                <div class="switch-form">
                    Remember your password? <a id="back-to-login">Back to Login</a>
                </div>
            </form>
        </div>
    </div>
    
    <script>
        document.getElementById('switch-to-register').addEventListener('click', function() {
            switchForm('register');
        });
        
        document.getElementById('switch-to-login').addEventListener('click', function() {
            switchForm('login');
        });
        
        document.getElementById('forgot-password-link').addEventListener('click', function(e) {
            e.preventDefault();
            switchForm('forgot-password');
        });
        
        document.getElementById('back-to-login').addEventListener('click', function() {
            switchForm('login');
        });
        
        function switchForm(form) {
            // Hide all forms
            document.getElementById('login-form').classList.remove('active');
            document.getElementById('register-form').classList.remove('active');
            document.getElementById('forgot-password-form').classList.remove('active');
            
            // Show selected form
            if (form === 'login') {
                document.getElementById('login-form').classList.add('active');
            } else if (form === 'register') {
                document.getElementById('register-form').classList.add('active');
            } else if (form === 'forgot-password') {
                document.getElementById('forgot-password-form').classList.add('active');
            }
        }
        
        // Toggle password visibility
        function togglePassword(inputId, toggleBtn) {
            const passwordInput = document.getElementById(inputId);
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleBtn.innerHTML = '<i class="fas fa-eye-slash"></i>';
            } else {
                passwordInput.type = 'password';
                toggleBtn.innerHTML = '<i class="fas fa-eye"></i>';
            }
        }
        
        // Password confirmation validation
        document.getElementById('register-confirm-password')?.addEventListener('input', function() {
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
        
        // Check username and load security question
        document.getElementById('check-username-btn').addEventListener('click', function() {
            const username = document.getElementById('forgot-username').value;
            
            if (!username) {
                alert('Silakan masukkan username terlebih dahulu!');
                return;
            }
            
            // AJAX call untuk check username
            fetch('<?= site_url('check-username') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'username=' + encodeURIComponent(username)
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    document.getElementById('question-display').textContent = data.question;
                    document.getElementById('security-section').style.display = 'block';
                    document.getElementById('check-username-btn').style.display = 'none';
                    document.getElementById('reset-password-btn').style.display = 'block';
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                alert('Terjadi kesalahan. Silakan coba lagi.');
            });
        });
        
        // Password validation
        function validatePassword(password) {
            const minLength = 6;
            const hasLetter = /[a-zA-Z]/.test(password);
            const hasNumber = /\d/.test(password);
            
            if (password.length < minLength) {
                return `Password minimal ${minLength} karakter`;
            }
            
            if (!hasLetter || !hasNumber) {
                return 'Password harus mengandung huruf dan angka';
            }
            
            return null; // Valid
        }

        // Login form validation
        document.getElementById('loginForm')?.addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const error = validatePassword(password);
            
            if (error) {
                e.preventDefault();
                alert(error);
                return false;
            }
        });

        // Register form validation
        document.getElementById('registerForm')?.addEventListener('submit', function(e) {
            const password = document.getElementById('register_password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            
            // Validate password
            const passwordError = validatePassword(password);
            if (passwordError) {
                e.preventDefault();
                alert(passwordError);
                return false;
            }
            
            // Validate password match
            if (password !== confirmPassword) {
                e.preventDefault();
                alert('Konfirmasi password tidak sama');
                return false;
            }
        });

        // Real-time password validation
        document.getElementById('register_password')?.addEventListener('input', function() {
            const password = this.value;
            const error = validatePassword(password);
            const small = this.parentElement.nextElementSibling;
            
            if (error && password.length > 0) {
                small.textContent = error;
                small.className = 'text-danger';
                this.style.borderColor = '#dc3545';
            } else if (password.length >= 6) {
                small.textContent = 'Password valid ✓';
                small.className = 'text-success';
                this.style.borderColor = '#28a745';
            } else {
                small.textContent = 'Minimal 6 karakter, kombinasi huruf dan angka';
                small.className = 'text-muted';
                this.style.borderColor = '#e2e8f0';
            }
        });
    </script>
</body>
</html>