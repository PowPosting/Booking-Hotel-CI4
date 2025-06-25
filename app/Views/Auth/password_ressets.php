<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f5f5f5;
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
            z-index: 10;
        }
        
        .back-button:hover {
            background-color: #4a6cfa;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(74, 108, 250, 0.3);
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
        
        .form-container {
            padding: 40px 30px 30px;
        }
        
        .form-title {
            text-align: center;
            margin-bottom: 15px;
            color: #333;
            font-size: 28px;
            font-weight: 700;
        }
        
        .form-subtitle {
            text-align: center;
            color: #666;
            margin-bottom: 30px;
            font-size: 14px;
            line-height: 1.5;
        }
        
        .security-info {
            background-color: #f8f9fa;
            border-left: 4px solid #4a6cfa;
            padding: 15px;
            margin-bottom: 25px;
            border-radius: 0 8px 8px 0;
        }
        
        .security-info h6 {
            color: #4a6cfa;
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 14px;
        }
        
        .security-info ul {
            margin: 0;
            padding-left: 18px;
            color: #666;
            font-size: 13px;
        }
        
        .security-info li {
            margin-bottom: 4px;
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
            border-radius: 8px;
            font-size: 14px;
            transition: border-color 0.3s;
        }
        
        .form-group input:focus {
            outline: none;
            border-color: #4a6cfa;
            box-shadow: 0 0 0 3px rgba(74, 108, 250, 0.1);
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
        
        .password-strength {
            margin-top: 5px;
            font-size: 12px;
        }
        
        .strength-bar {
            height: 4px;
            background-color: #e0e0e0;
            border-radius: 2px;
            margin-top: 5px;
            overflow: hidden;
        }
        
        .strength-fill {
            height: 100%;
            transition: all 0.3s ease;
            border-radius: 2px;
        }
        
        .strength-weak { background-color: #e74c3c; width: 33%; }
        .strength-medium { background-color: #f39c12; width: 66%; }
        .strength-strong { background-color: #27ae60; width: 100%; }
        
        .btn {
            width: 100%;
            padding: 14px;
            background-color: #4a6cfa;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 10px;
        }
        
        .btn:hover {
            background-color: #3a5ce4;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(74, 108, 250, 0.3);
        }
        
        .btn:disabled {
            background-color: #ccc;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }
        
        .back-to-login {
            text-align: center;
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            font-size: 14px;
            color: #666;
        }
        
        .back-to-login a {
            color: #4a6cfa;
            text-decoration: none;
            font-weight: 600;
            cursor: pointer;
            padding: 2px 4px;
            border-radius: 4px;
            transition: background-color 0.3s;
        }
        
        .back-to-login a:hover {
            background-color: rgba(74, 108, 250, 0.1);
        }

        /* Alert Messages */
        .alert {
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
        }
        
        .alert-error {
            color: #721c24;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
        }
        
        .alert-success {
            color: #155724;
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
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
    <a href="<?= base_url('/login') ?>" class="back-button">
        <i class="fas fa-arrow-left"></i>
        Back to Login
    </a>

    <div class="container">
        <div class="form-container">
            <h2 class="form-title">Reset Password</h2>
            <p class="form-subtitle">
                Harap masukkan kata sandi baru Anda di bawah ini. Pastikan kata sandi kuat dan aman.
            </p>

            <!-- Security Information -->
            <div class="security-info">
                <h6><i class="fas fa-shield-alt me-2"></i>Persyaratan:</h6>
                <ul>
                    <li>panjang karakter minimal 6</li>
                    <li>Campuran huruf besar dan kecil</li>
                    <li>Termasuk angka dan karakter khusus</li>
                    <li>Jangan gunakan informasi pribadi</li>
                </ul>
            </div>

            <?php if (!empty($error)) : ?>
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-triangle me-2"></i><?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>
            <?php if (!empty($success)) : ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle me-2"></i><?= htmlspecialchars($success) ?>
                </div>
            <?php endif; ?>
            
            <!-- Reset Password Form -->
            <form id="reset-form" method="post" action="<?= site_url('reset-password/update') ?>">
                <input type="hidden" name="token" value="<?= esc($token) ?>">
                <input type="hidden" name="user_id" value="<?= esc($user_id) ?>">
                
                <div class="form-group">
                    <label for="password">Password Baru</label>
                    <div class="password-container">
                        <input type="password" id="password" name="password" placeholder="Masukkan kata sandi baru Anda" required>
                        <span class="toggle-password" onclick="togglePassword('password', this)">👁️</span>
                    </div>
                    <div class="password-strength">
                        <span id="strength-text">Kekuatan kata sandi: </span>
                        <div class="strength-bar">
                            <div class="strength-fill" id="strength-fill"></div>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="confirm-password">Konfirmasi Password Baru</label>
                    <div class="password-container">
                        <input type="password" id="confirm-password" name="confirm_password" placeholder="Konfirmasi kata sandi baru Anda" required>
                        <span class="toggle-password" onclick="togglePassword('confirm-password', this)">👁️</span>
                    </div>
                    <div id="password-match-error" style="color: #e74c3c; font-size: 12px; margin-top: 5px; display: none;">
                        <i class="fas fa-times-circle me-1"></i>Kata sandi tidak cocok!
                    </div>
                    <div id="password-match-success" style="color: #27ae60; font-size: 12px; margin-top: 5px; display: none;">
                        <i class="fas fa-check-circle me-1"></i>Kata sandi cocok!
                    </div>
                </div>
                
                <button type="submit" class="btn" id="submit-btn">
                    <i class="fas fa-key me-2"></i>Perbarui Password
                </button>
                
                <div class="back-to-login">
                    <a href="<?= base_url('/login') ?>">Kembali ke Login</a>
                </div>
            </form>
        </div>
    </div>
    
    <script>
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
        
        // Password strength checker
        function checkPasswordStrength(password) {
            let strength = 0;
            let feedback = '';
            
            if (password.length >= 6) strength++;
            if (password.match(/[a-z]/)) strength++;
            if (password.match(/[A-Z]/)) strength++;
            if (password.match(/[0-9]/)) strength++;
            if (password.match(/[^a-zA-Z0-9]/)) strength++;
            
            const strengthFill = document.getElementById('strength-fill');
            const strengthText = document.getElementById('strength-text');
            
            if (strength <= 2) {
                strengthFill.className = 'strength-fill strength-weak';
                feedback = 'Weak';
            } else if (strength <= 4) {
                strengthFill.className = 'strength-fill strength-medium';
                feedback = 'Medium';
            } else {
                strengthFill.className = 'strength-fill strength-strong';
                feedback = 'Strong';
            }
            
            strengthText.textContent = `Password strength: ${feedback}`;
        }
        
        // Password confirmation validation
        function validatePasswordMatch() {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm-password').value;
            const errorDiv = document.getElementById('password-match-error');
            const successDiv = document.getElementById('password-match-success');
            const submitBtn = document.getElementById('submit-btn');
            
            if (confirmPassword.length > 0) {
                if (password === confirmPassword) {
                    errorDiv.style.display = 'none';
                    successDiv.style.display = 'block';
                    document.getElementById('confirm-password').style.borderColor = '#27ae60';
                    submitBtn.disabled = false;
                } else {
                    errorDiv.style.display = 'block';
                    successDiv.style.display = 'none';
                    document.getElementById('confirm-password').style.borderColor = '#e74c3c';
                    submitBtn.disabled = true;
                }
            } else {
                errorDiv.style.display = 'none';
                successDiv.style.display = 'none';
                document.getElementById('confirm-password').style.borderColor = '#ddd';
                submitBtn.disabled = false;
            }
        }
        
        // Event listeners
        document.getElementById('password').addEventListener('input', function() {
            checkPasswordStrength(this.value);
            validatePasswordMatch();
        });
        
        document.getElementById('confirm-password').addEventListener('input', validatePasswordMatch);
        
        // Form validation before submit
        document.getElementById('reset-form').addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm-password').value;
            
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