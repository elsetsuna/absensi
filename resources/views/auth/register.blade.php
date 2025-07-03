<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AttendanceHub - Sign In</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4f46e5;
            --success-color: #10b981;
            --danger-color: #ef4444;
            --warning-color: #f59e0b;
        }
        
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
        }
        
        .auth-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .auth-card {
            border-radius: 25px;
            box-shadow: 0 25px 50px rgba(0,0,0,0.15);
            border: none;
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(20px);
            max-width: 40%;
            width: 100%;
            transform: translateY(0);
            transition: all 0.3s ease;
            overflow: hidden;
        }
        
        .auth-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 35px 60px rgba(0,0,0,0.2);
        }
        
        .auth-header {
            background: linear-gradient(135deg, var(--primary-color), #6366f1);
            color: white;
            padding: 3rem 2rem 2rem;
            text-align: center;
            position: relative;
        }
        
        .auth-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" fill="white" opacity="0.1"><path d="M0,0v30c20,10 40,5 60,10s40,20 60,15 40-15 60-10 40,25 60,20 40-25 60-20 40,30 60,25 40-30 60-25 40,35 60,30 40-35 60-30v40H0z"/></svg>') repeat-x bottom;
            background-size: 100px 20px;
        }
        
        .auth-logo {
            font-size: 3rem;
            margin-bottom: 1rem;
            text-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }
        
        .auth-title {
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .auth-subtitle {
            opacity: 0.9;
            font-size: 1.1rem;
            font-weight: 300;
        }
        
        .auth-body {
            padding: 2.5rem;
        }
        
        .form-floating {
            margin-bottom: 1.5rem;
            position: relative;
        }
        
        .form-control {
            border-radius: 15px;
            border: 2px solid #e5e7eb;
            padding: 1rem 0.75rem;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: rgba(255,255,255,0.8);
            height: calc(3.5rem + 2px);
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(79, 70, 229, 0.25);
            background: white;
            transform: translateY(-2px);
        }
        
        .form-control.is-invalid {
            border-color: var(--danger-color);
            box-shadow: 0 0 0 0.2rem rgba(239, 68, 68, 0.25);
        }
        
        .form-control.is-valid {
            border-color: var(--success-color);
            box-shadow: 0 0 0 0.2rem rgba(16, 185, 129, 0.25);
        }
        
        .form-floating > label {
            color: #6b7280;
            font-weight: 500;
            padding: 1rem 0.75rem;
            pointer-events: none;
            border: 1px solid transparent;
            transform-origin: 0 0;
            transition: opacity 0.1s ease-in-out, transform 0.1s ease-in-out;
        }
        
        .form-floating > .form-control:focus ~ label,
        .form-floating > .form-control:not(:placeholder-shown) ~ label {
            opacity: 0.65;
            transform: scale(0.85) translateY(-0.5rem) translateX(0.15rem);
        }
        
        .form-floating > select {
            padding-top: 1.625rem;
            padding-bottom: 0.625rem;
        }
        
        .form-floating > input[type="date"] {
            padding: 1rem 0.75rem;
            color: #6b7280;
        }
        
        .form-floating > input[type="date"]:focus ~ label,
        .form-floating > input[type="date"]:not(:placeholder-shown) ~ label,
        .form-floating > input[type="date"]:valid ~ label {
            opacity: 0.65;
            transform: scale(0.85) translateY(-0.5rem) translateX(0.15rem);
        }
        
        .btn-auth {
            padding: 15px 40px;
            border-radius: 50px;
            font-size: 1.1rem;
            font-weight: 600;
            border: none;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            background: linear-gradient(135deg, var(--primary-color), #6366f1);
            color: white;
            width: 100%;
            margin-bottom: 1.5rem;
        }
        
        .btn-auth:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(79, 70, 229, 0.4);
            color: white;
        }
        
        .btn-auth:active {
            transform: translateY(-1px);
        }
        
        .btn-auth:disabled {
            opacity: 0.7;
            transform: none;
        }
        
        .btn-outline-auth {
            background: transparent;
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
        }
        
        .btn-outline-auth:hover {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }
        
        .auth-link {
            text-align: center;
            color: #6b7280;
            font-weight: 500;
        }
        
        .auth-link a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .auth-link a:hover {
            color: #3730a3;
            text-decoration: underline;
        }
        
        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #6b7280;
            font-size: 1.1rem;
            cursor: pointer;
            z-index: 10;
            transition: color 0.3s ease;
        }
        
        .password-toggle:hover {
            color: var(--primary-color);
        }
        
        .form-check {
            margin-bottom: 1.5rem;
        }
        
        .form-check-input {
            border-radius: 6px;
            border: 2px solid #e5e7eb;
            margin-right: 0.5rem;
        }
        
        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .form-check-label {
            color: #6b7280;
            font-weight: 500;
        }
        
        .form-check-label a {
            color: var(--primary-color);
            text-decoration: none;
        }
        
        .form-check-label a:hover {
            text-decoration: underline;
        }
        
        .alert {
            border-radius: 15px;
            border: none;
            margin-bottom: 1.5rem;
            font-weight: 500;
        }
        
        .invalid-feedback {
            display: block;
            width: 100%;
            margin-top: 0.25rem;
            font-size: 0.875rem;
            color: var(--danger-color);
        }
        
        .valid-feedback {
            display: block;
            width: 100%;
            margin-top: 0.25rem;
            font-size: 0.875rem;
            color: var(--success-color);
        }
        
        .floating-elements {
            position: fixed;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: -1;
        }
        
        .floating-element {
            position: absolute;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }
        
        .floating-element:nth-child(1) {
            width: 80px;
            height: 80px;
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }
        
        .floating-element:nth-child(2) {
            width: 120px;
            height: 120px;
            top: 60%;
            right: 10%;
            animation-delay: 2s;
        }
        
        .floating-element:nth-child(3) {
            width: 60px;
            height: 60px;
            top: 40%;
            left: 80%;
            animation-delay: 4s;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }
        
        .fade-in {
            animation: fadeIn 0.8s ease-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @media (max-width: 768px) {
            .auth-card {
                margin: 10px;
                border-radius: 20px;
                max-width: 90%;
            }
            
            .auth-header {
                padding: 2rem 1.5rem 1.5rem;
            }
            
            .auth-body {
                padding: 2rem 1.5rem;
            }
            
            .auth-title {
                font-size: 1.8rem;
            }
            
            .auth-logo {
                font-size: 2.5rem;
            }
        }
    </style>
</head>
<body>
    <!-- Floating Background Elements -->
    <div class="floating-elements">
        <div class="floating-element"></div>
        <div class="floating-element"></div>
        <div class="floating-element"></div>
    </div>

    <div class="auth-container">
        <!-- Sign In Form -->
        <div class="auth-card fade-in" id="signin-form">
            <div class="auth-header">
                <div class="auth-logo">
                    <i class="fas fa-clock"></i>
                </div>
                <h1 class="auth-title">Welcome Back</h1>
                <p class="auth-subtitle">Sign in to your AttendanceHub account</p>
            </div>
            
            <div class="auth-body">
                <form id="signin-form-element" novalidate>
                    <div class="form-floating">
                        <input type="email" class="form-control" id="signin-email" name="email" placeholder="name@example.com" required>
                        <label for="signin-email">Email address</label>
                    </div>
                    
                    <div class="form-floating" style="position: relative;">
                        <input type="password" class="form-control" id="signin-password" name="password" placeholder="Password" required>
                        <label for="signin-password">Password</label>
                        <button type="button" class="password-toggle" onclick="togglePassword('signin-password')">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="remember-me">
                            <label class="form-check-label" for="remember-me">
                                Remember me
                            </label>
                        </div>
                        <a href="#" class="text-decoration-none" style="color: var(--primary-color); font-weight: 600;">
                            Forgot password?
                        </a>
                    </div>
                    
                    <button type="submit" class="btn btn-auth">
                        Sign In
                    </button>
                </form>
                
                <div class="auth-link">
                    Don't have an account? <a href="#" onclick="switchToRegister()">Create one</a>
                </div>
            </div>
        </div>
        
        <!-- Registration Form -->
        <div class="auth-card fade-in" id="register-form" style="display: none;">
            <div class="auth-header">
                <div class="auth-logo">
                    <i class="fas fa-user-plus"></i>
                </div>
                <h1 class="auth-title">Join Us</h1>
                <p class="auth-subtitle">Create your AttendanceHub account</p>
            </div>
            
            <div class="auth-body">
                <form id="register-form-element" novalidate>
                    <div class="form-floating">
                        <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
                        <label for="username">Username</label>
                    </div>
                    
                    <div class="form-floating" style="position: relative;">
                        <input type="password" class="form-control" id="register-password" name="password" placeholder="Password" required>
                        <label for="register-password">Password</label>
                        <button type="button" class="password-toggle" onclick="togglePassword('register-password')">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    
                    <div class="form-floating">
                        <input type="text" class="form-control" id="nama-lengkap" name="nama_lengkap" placeholder="Nama Lengkap" required>
                        <label for="nama-lengkap">Nama Lengkap</label>
                    </div>
                    
                    <div class="form-floating">
                        <input type="email" class="form-control" id="register-email" name="email" placeholder="name@example.com" required>
                        <label for="register-email">Email</label>
                    </div>
                    
                    <div class="form-floating">
                        <input type="text" class="form-control" id="telegram" name="telegram" placeholder="Telegram Username" required>
                        <label for="telegram">Telegram</label>
                    </div>
                    
                    <div class="form-floating">
                        <select class="form-control" id="jenis-kelamin" name="jenis_kelamin" required>
                            <option value="">Pilih Jenis Kelamin</option>
                        </select>
                        <label for="jenis-kelamin">Jenis Kelamin</label>
                    </div>
                    
                    <div class="form-floating">
                        <select class="form-control" id="agama" name="agama" required>
                            <option value="">Pilih Agama</option>
                        </select>
                        <label for="agama">Agama</label>
                    </div>
                    
                    <div class="form-floating">
                        <select class="form-control" id="bo-web" name="bo_web" required>
                            <option value="">Pilih BO / Web</option>
                        </select>
                        <label for="bo-web">BO / Web</label>
                    </div>
                    
                    <div class="form-floating">
                        <select class="form-control" id="jabatan" name="jabatan" required>
                            <option value="">Pilih Jabatan</option>
                        </select>
                        <label for="jabatan">Jabatan</label>
                    </div>
                    
                    <div class="form-floating">
                        <input type="date" class="form-control" id="tanggal-bergabung" name="tanggal_bergabung" required>
                        <label for="tanggal-bergabung">Tanggal Bergabung</label>
                    </div>
                    
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="terms-agree" required>
                        <label class="form-check-label" for="terms-agree">
                            I agree to the <a href="#" target="_blank">Terms of Service</a> and <a href="#" target="_blank">Privacy Policy</a>
                        </label>
                    </div>
                    
                    <button type="submit" class="btn btn-auth">
                        Create Account
                    </button>
                </form>
                
                <div class="auth-link">
                    Already have an account? <a href="#" onclick="switchToSignin()">Sign in</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Simple Authentication System
        class SimpleAuth {
            constructor() {
                this.baseURL = '/api';
                this.token = localStorage.getItem('auth_token');
                this.init();
            }

            init() {
                this.setupForms();
                this.loadFormOptions();
                this.setAuthHeader();
                this.addDemoButton();
            }

            setAuthHeader() {
                if (this.token && typeof axios !== 'undefined') {
                    axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;
                }
            }

            setupForms() {
                const registerForm = document.getElementById('register-form-element');
                if (registerForm) {
                    registerForm.addEventListener('submit', (e) => this.handleRegister(e));
                }

                const loginForm = document.getElementById('signin-form-element');
                if (loginForm) {
                    loginForm.addEventListener('submit', (e) => this.handleLogin(e));
                }
            }

            async loadFormOptions() {
                try {
                    const response = await fetch(`${this.baseURL}/form-options`);
                    const result = await response.json();
                    
                    if (result.success) {
                        this.populateSelects(result.data);
                    }
                } catch (error) {
                    console.error('Failed to load form options:', error);
                }
            }

            populateSelects(options) {
                Object.keys(options).forEach(fieldName => {
                    const select = document.getElementById(fieldName.replace('_', '-'));
                    if (select) {
                        Object.entries(options[fieldName]).forEach(([value, label]) => {
                            const option = document.createElement('option');
                            option.value = value;
                            option.textContent = label;
                            select.appendChild(option);
                        });
                    }
                });
            }

            async handleRegister(e) {
                e.preventDefault();
                
                const form = e.target;
                const submitBtn = form.querySelector('button[type="submit"]');
                const originalText = submitBtn.textContent;
                
                try {
                    this.setLoading(submitBtn, true);
                    
                    const formData = new FormData(form);
                    const data = Object.fromEntries(formData.entries());
                    
                    const response = await fetch(`${this.baseURL}/register`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify(data)
                    });
                    
                    const result = await response.json();
                    
                    if (result.success) {
                        this.saveToken(result.data.token);
                        this.showMessage('Registration successful! Employee ID: ' + result.data.user.employee_id, 'success');
                        
                        setTimeout(() => {
                            window.location.href = '/dashboard';
                        }, 2000);
                        
                    } else {
                        this.handleErrors(result.errors || { general: [result.message] });
                    }
                    
                } catch (error) {
                    this.showMessage('Registration failed. Please try again.', 'danger');
                    console.error('Registration error:', error);
                } finally {
                    this.setLoading(submitBtn, false, originalText);
                }
            }

            async handleLogin(e) {
                e.preventDefault();
                
                const form = e.target;
                const submitBtn = form.querySelector('button[type="submit"]');
                const originalText = submitBtn.textContent;
                
                try {
                    this.setLoading(submitBtn, true);
                    
                    const email = form.querySelector('#signin-email').value;
                    const password = form.querySelector('#signin-password').value;
                    
                    const response = await fetch(`${this.baseURL}/login`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ email, password })
                    });
                    
                    const result = await response.json();
                    
                    if (result.success) {
                        this.saveToken(result.data.token);
                        this.showMessage('Login successful! Welcome back.', 'success');
                        
                        setTimeout(() => {
                            window.location.href = '/dashboard';
                        }, 1000);
                        
                    } else {
                        this.showMessage(result.message, 'danger');
                    }
                    
                } catch (error) {
                    this.showMessage('Login failed. Please try again.', 'danger');
                    console.error('Login error:', error);
                } finally {
                    this.setLoading(submitBtn, false, originalText);
                }
            }

            saveToken(token) {
                this.token = token;
                localStorage.setItem('auth_token', token);
                this.setAuthHeader();
            }

            handleErrors(errors) {
                document.querySelectorAll('.is-invalid').forEach(el => {
                    el.classList.remove('is-invalid');
                });
                document.querySelectorAll('.invalid-feedback').forEach(el => {
                    el.remove();
                });

                Object.keys(errors).forEach(field => {
                    const input = document.getElementById(field.replace('_', '-')) || 
                                 document.querySelector(`[name="${field}"]`);
                    
                    if (input) {
                        input.classList.add('is-invalid');
                        
                        const feedback = document.createElement('div');
                        feedback.className = 'invalid-feedback';
                        feedback.textContent = Array.isArray(errors[field]) ? errors[field][0] : errors[field];
                        
                        input.parentNode.appendChild(feedback);
                    }
                });

                if (errors.general) {
                    this.showMessage(errors.general[0], 'danger');
                }
            }

            setLoading(button, loading, originalText = '') {
                if (loading) {
                    button.disabled = true;
                    button.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Processing...';
                } else {
                    button.disabled = false;
                    button.innerHTML = originalText;
                }
            }

            showMessage(message, type = 'info') {
                const existing = document.querySelector('.alert-message');
                if (existing) existing.remove();

                const alertDiv = document.createElement('div');
                alertDiv.className = `alert alert-${type} alert-dismissible fade show alert-message`;
                alertDiv.innerHTML = `
                    <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'danger' ? 'exclamation-circle' : 'info-circle'} me-2"></i>
                    ${message}
                    <button type="button" class="btn-close" onclick="this.parentElement.remove()"></button>
                `;

                const activeForm = document.querySelector('#signin-form:not([style*="display: none"]) .auth-body, #register-form:not([style*="display: none"]) .auth-body');
                if (activeForm) {
                    activeForm.insertBefore(alertDiv, activeForm.querySelector('form'));
                }

                setTimeout(() => {
                    if (alertDiv.parentNode) {
                        alertDiv.remove();
                    }
                }, 5000);
            }

            fillDemoData() {
                const demoData = {
                    'username': 'demo_' + Math.floor(Math.random() * 1000),
                    'register-password': 'demo123',
                    'nama-lengkap': 'Demo User',
                    'register-email': `demo${Math.floor(Math.random() * 1000)}@company.com`,
                    'telegram': 'demouser',
                    'jenis-kelamin': 'laki-laki',
                    'agama': 'islam',
                    'bo-web': 'web-a',
                    'jabatan': 'admin',
                    'tanggal-bergabung': new Date().toISOString().split('T')[0]
                };

                Object.keys(demoData).forEach(id => {
                    const field = document.getElementById(id);
                    if (field) {
                        field.value = demoData[id];
                    }
                });

                const terms = document.getElementById('terms-agree');
                if (terms) terms.checked = true;

                this.showMessage('Demo data filled!', 'info');
            }

            addDemoButton() {
                if (window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1') {
                    const registerForm = document.getElementById('register-form-element');
                    if (registerForm) {
                        const demoBtn = document.createElement('button');
                        demoBtn.type = 'button';
                        demoBtn.className = 'btn btn-outline-auth btn-sm mb-3';
                        demoBtn.innerHTML = '<i class="fas fa-magic me-1"></i>Fill Demo Data';
                        demoBtn.onclick = () => this.fillDemoData();
                        
                        const submitBtn = registerForm.querySelector('button[type="submit"]');
                        submitBtn.parentNode.insertBefore(demoBtn, submitBtn);
                    }
                }
            }
        }

        // Form switching functions (your existing functions)
        function switchToRegister() {
            document.getElementById('signin-form').style.display = 'none';
            document.getElementById('register-form').style.display = 'block';
            document.getElementById('register-form').classList.remove('fade-in');
            setTimeout(() => {
                document.getElementById('register-form').classList.add('fade-in');
            }, 50);
        }
        
        function switchToSignin() {
            document.getElementById('register-form').style.display = 'none';
            document.getElementById('signin-form').style.display = 'block';
            document.getElementById('signin-form').classList.remove('fade-in');
            setTimeout(() => {
                document.getElementById('signin-form').classList.add('fade-in');
            }, 50);
        }
        
        // Password toggle function (your existing function)
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const toggle = input.nextElementSibling.nextElementSibling;
            const icon = toggle.querySelector('i');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        // Initialize when page loads
        document.addEventListener('DOMContentLoaded', function() {
            window.auth = new SimpleAuth();
        });

        // Global logout function
        function logout() {
            if (window.auth) {
                window.auth.logout();
            }
        }
    </script>
</body>
</html>