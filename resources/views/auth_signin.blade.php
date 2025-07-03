<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AttendanceHub - Sign In</title>
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
            max-width: 50%;
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
        
        .btn-auth.loading {
            color: transparent;
        }
        
        .btn-auth .spinner {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            display: none;
        }
        
        .btn-auth.loading .spinner {
            display: block;
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
        
        .alert-custom {
            border-radius: 15px;
            border: none;
            margin-bottom: 1.5rem;
            font-weight: 500;
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
            

            
            .form-floating {
                margin-bottom: 1.2rem;
            }
            
            .form-floating > .form-control {
                padding: 1rem 0.75rem;
                font-size: 16px; /* Prevents zoom on iOS */
            }
            
            .form-floating > label {
                padding: 1rem 0.75rem;
                font-size: 0.9rem;
            }
            
            .password-toggle {
                right: 12px;
                font-size: 1rem;
            }
            
            .btn-auth {
                padding: 12px 30px;
                font-size: 1rem;
            }
            

            

            
            .auth-link {
                font-size: 0.9rem;
            }
        }
        
        @media (max-width: 480px) {
            .auth-container {
                padding: 10px;
            }
            
            .auth-card {
                margin: 5px;
                border-radius: 15px;
                max-width: 95%;
            }
            
            .auth-header {
                padding: 1.5rem 1rem 1rem;
            }
            
            .auth-body {
                padding: 1.5rem 1rem;
            }
            
            .auth-title {
                font-size: 1.6rem;
            }
            
            .auth-logo {
                font-size: 2rem;
            }
            
            .form-floating > .form-control {
                padding: 0.875rem 0.6rem;
            }
            
            .form-floating > label {
                padding: 0.875rem 0.6rem;
            }
            
            .password-toggle {
                right: 10px;
            }
            
            .btn-auth {
                padding: 10px 25px;
                font-size: 0.95rem;
            }
            
            .d-flex.justify-content-between {
                flex-direction: column;
                gap: 0.5rem;
            }
            
            .d-flex.justify-content-between .form-check {
                margin-bottom: 0;
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
        <div class="auth-card fade-in">
            <div class="auth-header">
                <div class="auth-logo">
                    <i class="fas fa-clock"></i>
                </div>
                <h1 class="auth-title">Welcome Back</h1>
                <p class="auth-subtitle">Sign in to your AttendanceHub account</p>
            </div>
            
            <div class="auth-body">
                <div class="alert alert-danger alert-custom" id="signin-error" style="display: none;">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <span id="signin-error-message"></span>
                </div>
                

                

                
                <form id="signin-form-element" action="{{ route('login')}}" method="POST" novalidate>
                    @csrf
                    <div class="form-floating">
                        <input type="text" name="username" class="form-control" id="signin-username" placeholder="username" required>
                        <label for="signin-username">Username</label>
                        <div class="invalid-feedback">Username is required.</div>
                    </div>
                    
                    <div class="form-floating" style="position: relative;">
                        <input type="password" name="password" class="form-control" id="signin-password" placeholder="Password" required>
                        <label for="signin-password">Password</label>
                        <button type="button" class="password-toggle" onclick="togglePassword('signin-password')">
                            <i class="fas fa-eye"></i>
                        </button>
                        <div class="invalid-feedback">Password is required.</div>
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
                        <span class="btn-text">Sign In</span>
                        <div class="spinner">
                            <i class="fas fa-spinner fa-spin"></i>
                        </div>
                    </button>
                </form>
                
                <div class="auth-link">
                    Don't have an account? <a href="register.html">Create one</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Password toggle
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
        
        // Sign in form handling
        document.getElementById('signin-form-element').addEventListener('submit', function(e) {
            const username = document.getElementById('signin-username').value.trim();
            const password = document.getElementById('signin-password').value;
            
            // Reset previous validation
            this.classList.remove('was-validated');
            document.getElementById('signin-error').style.display = 'none';
            
            let isValid = true;
            
            // Username validation
            if (!username) {
                document.getElementById('signin-username').classList.add('is-invalid');
                isValid = false;
                e.preventDefault();
            } else {
                document.getElementById('signin-username').classList.remove('is-invalid');
            }
            
            // Password validation
            if (!password) {
                document.getElementById('signin-password').classList.add('is-invalid');
                isValid = false;
                e.preventDefault();
            } else {
                document.getElementById('signin-password').classList.remove('is-invalid');
            }
            
            // If validation fails, prevent form submission
            if (!isValid) {
                e.preventDefault();
                return false;
            }
            
            // If validation passes, allow normal form submission to action URL
            // Form will submit to dashboard.html via POST method
        });
        
        // Social login simulation
        function socialLogin(provider) {
            showToast(`Connecting to ${provider}...`, 'info');
            
            // Simulate social login process
            setTimeout(() => {
                showToast(`${provider} login successful! Redirecting...`, 'success');
                setTimeout(() => {
                    window.location.href = 'dashboard.html';
                }, 1500);
            }, 2000);
        }
        
        // Show error message
        function showError(formType, message) {
            const errorDiv = document.getElementById(`${formType}-error`);
            const errorMessage = document.getElementById(`${formType}-error-message`);
            
            errorMessage.textContent = message;
            errorDiv.style.display = 'block';
            
            // Auto hide after 5 seconds
            setTimeout(() => {
                errorDiv.style.display = 'none';
            }, 5000);
        }
        
        // Toast notifications
        function showToast(message, type = 'info') {
            // Create toast container if it doesn't exist
            let toastContainer = document.getElementById('toast-container');
            if (!toastContainer) {
                toastContainer = document.createElement('div');
                toastContainer.id = 'toast-container';
                toastContainer.className = 'toast-container position-fixed top-0 end-0 p-3';
                toastContainer.style.zIndex = '9999';
                document.body.appendChild(toastContainer);
            }
            
            // Create toast element
            const toast = document.createElement('div');
            toast.className = `toast align-items-center text-white bg-${type === 'success' ? 'success' : type === 'error' ? 'danger' : 'info'} border-0`;
            toast.setAttribute('role', 'alert');
            toast.innerHTML = `
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'} me-2"></i>${message}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            `;
            
            toastContainer.appendChild(toast);
            const bsToast = new bootstrap.Toast(toast);
            bsToast.show();
            
            toast.addEventListener('hidden.bs.toast', () => {
                toast.remove();
            });
        }
        
    </script>
</body>
</html>