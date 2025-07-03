<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AttendanceHub - Debug Registration</title>
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
        
        .form-floating > select {
            padding-top: 1.625rem;
            padding-bottom: 0.625rem;
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
        
        .alert-custom {
            border-radius: 15px;
            border: none;
            margin-bottom: 1.5rem;
            font-weight: 500;
        }
        
        .is-invalid {
            border-color: var(--danger-color) !important;
        }
        
        .invalid-feedback {
            display: none;
            width: 100%;
            margin-top: 0.25rem;
            font-size: 0.875em;
            color: var(--danger-color);
        }
        
        .is-invalid ~ .invalid-feedback {
            display: block;
        }
        
        .debug-info {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 1rem;
            font-family: monospace;
            font-size: 0.85rem;
        }
        
        @media (max-width: 768px) {
            .auth-card {
                margin: 10px;
                border-radius: 20px;
                max-width: 90%;
            }
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <!-- Registration Form -->
        <div class="auth-card">
            <div class="auth-header">
                <div class="auth-logo">
                    <i class="fas fa-user-plus"></i>
                </div>
                <h1 class="auth-title">Join Us</h1>
                <p class="auth-subtitle">Create your AttendanceHub account</p>
            </div>
            
            <div class="auth-body">
                <!-- Debug Information -->
                <div class="debug-info" id="debug-info">
                    <strong>Debug Console:</strong><br>
                    <span id="debug-text">Form ready. Fill out and submit to see debug info.</span>
                </div>
                
                <div class="alert alert-danger alert-custom" id="register-error" style="display: none;">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <span id="register-error-message"></span>
                </div>
                
<form id="register-form-element" action="{{ route('signup') }}" method="POST" novalidate>                    <!-- Add CSRF token if using Laravel -->
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
                        <label for="username">Username</label>
                        <div class="invalid-feedback">Username is required.</div>
                    </div>
                    
                    <div class="form-floating">
                        <input type="password" class="form-control" id="register-password" name="password" placeholder="Password" required>
                        <label for="register-password">Password</label>
                        <div class="invalid-feedback">Password must be at least 8 characters.</div>
                    </div>
                    
                    <div class="form-floating">
                        <input type="text" class="form-control" id="nama-lengkap" name="nama_lengkap" placeholder="Nama Lengkap" required>
                        <label for="nama-lengkap">Nama Lengkap</label>
                        <div class="invalid-feedback">Nama lengkap is required.</div>
                    </div>
                    
                    <div class="form-floating">
                        <input type="email" class="form-control" id="register-email" name="email" placeholder="name@example.com" required>
                        <label for="register-email">Email</label>
                        <div class="invalid-feedback">Please enter a valid email address.</div>
                    </div>
                    
                    <div class="form-floating">
                        <input type="text" class="form-control" id="telegram" name="telegram" placeholder="Telegram Username" required>
                        <label for="telegram">Telegram</label>
                        <div class="invalid-feedback">Telegram username is required.</div>
                    </div>
                    
                    <div class="form-floating">
                        <select class="form-control" id="jenis-kelamin" name="jenis_kelamin" required>
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="laki-laki">Laki-laki</option>
                            <option value="perempuan">Perempuan</option>
                        </select>
                        <label for="jenis-kelamin">Jenis Kelamin</label>
                        <div class="invalid-feedback">Please select jenis kelamin.</div>
                    </div>
                    
                    <div class="form-floating">
                        <select class="form-control" id="agama" name="agama" required>
                            <option value="">Pilih Agama</option>
                            <option value="islam">Islam</option>
                            <option value="kristen">Kristen</option>
                            <option value="katolik">Katolik</option>
                            <option value="hindu">Hindu</option>
                            <option value="buddha">Buddha</option>
                            <option value="konghucu">Konghucu</option>
                            <option value="lainnya">Lainnya</option>
                        </select>
                        <label for="agama">Agama</label>
                        <div class="invalid-feedback">Please select agama.</div>
                    </div>
                    
                    <div class="form-floating">
                        <select class="form-control" id="bo-web" name="bo" required>
                            <option value="">Pilih BO / Web</option>
                            <option value="web-a">Web A</option>
                            <option value="web-b">Web B</option>
                            <option value="web-c">Web C</option>
                            <option value="bo-main">BO Main</option>
                            <option value="bo-backup">BO Backup</option>
                        </select>
                        <label for="bo-web">BO / Web</label>
                        <div class="invalid-feedback">Please select BO / Web.</div>
                    </div>
                    
                    <div class="form-floating">
                        <select class="form-control" id="jabatan" name="jabatan" required>
                            <option value="">Pilih Jabatan</option>
                            <option value="admin">Admin</option>
                            <option value="cs">Customer Service</option>
                            <option value="marketing">Marketing</option>
                            <option value="finance">Finance</option>
                            <option value="tech-support">Tech Support</option>
                            <option value="manager">Manager</option>
                            <option value="supervisor">Supervisor</option>
                        </select>
                        <label for="jabatan">Jabatan</label>
                        <div class="invalid-feedback">Please select jabatan.</div>
                    </div>
                    
                    <div class="form-floating">
                        <input type="date" class="form-control" id="tanggal-bergabung" name="tanggal_masuk_kerja" required>
                        <label for="tanggal-bergabung">Tanggal Bergabung</label>
                        <div class="invalid-feedback">Tanggal bergabung is required.</div>
                    </div>
                    
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="terms-agree" name="terms_agree" required>
                        <label class="form-check-label" for="terms-agree">
                            I agree to the <a href="#" target="_blank">Terms of Service</a> and <a href="#" target="_blank">Privacy Policy</a>
                        </label>
                        <div class="invalid-feedback">You must agree to the terms.</div>
                    </div>
                    
                    <button type="submit" class="btn btn-auth">
                        <span class="btn-text">Create Account</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Debug function to log information
        function debugLog(message) {
            const debugText = document.getElementById('debug-text');
            const timestamp = new Date().toLocaleTimeString();
            debugText.innerHTML += `<br>[${timestamp}] ${message}`;
            console.log(`[DEBUG] ${message}`);
        }
        
        // Form validation functions
        function validateEmail(email) {
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(email);
        }
        
        function validatePassword(password) {
            return password.length >= 8;
        }
        
        // Show error message
        function showError(message) {
            const errorDiv = document.getElementById('register-error');
            const errorMessage = document.getElementById('register-error-message');
            
            errorMessage.textContent = message;
            errorDiv.style.display = 'block';
            debugLog(`Error shown: ${message}`);
        }
        
        // Hide error message
        function hideError() {
            document.getElementById('register-error').style.display = 'none';
        }
        
        // Registration form handling with detailed debugging
        document.getElementById('register-form-element').addEventListener('submit', function(e) {
            debugLog('Form submit event triggered');
            
            // Get all form values
            const formData = {
                username: document.getElementById('username').value.trim(),
                password: document.getElementById('register-password').value,
                namaLengkap: document.getElementById('nama-lengkap').value.trim(),
                email: document.getElementById('register-email').value.trim(),
                telegram: document.getElementById('telegram').value.trim(),
                jenisKelamin: document.getElementById('jenis-kelamin').value,
                agama: document.getElementById('agama').value,
                boWeb: document.getElementById('bo-web').value,
                jabatan: document.getElementById('jabatan').value,
                tanggalBergabung: document.getElementById('tanggal-bergabung').value,
                termsAgree: document.getElementById('terms-agree').checked
            };
            
            debugLog('Form data collected: ' + JSON.stringify(formData, null, 2));
            
            // Reset previous validation
            this.classList.remove('was-validated');
            hideError();
            
            // Clear all previous invalid classes
            const allInputs = this.querySelectorAll('.form-control, .form-check-input');
            allInputs.forEach(input => input.classList.remove('is-invalid'));
            
            let isValid = true;
            let validationErrors = [];
            
            // Validate each field
            if (!formData.username) {
                document.getElementById('username').classList.add('is-invalid');
                validationErrors.push('Username is required');
                isValid = false;
            }
            
            if (!formData.password || !validatePassword(formData.password)) {
                document.getElementById('register-password').classList.add('is-invalid');
                validationErrors.push('Password must be at least 8 characters');
                isValid = false;
            }
            
            if (!formData.namaLengkap) {
                document.getElementById('nama-lengkap').classList.add('is-invalid');
                validationErrors.push('Nama lengkap is required');
                isValid = false;
            }
            
            if (!formData.email || !validateEmail(formData.email)) {
                document.getElementById('register-email').classList.add('is-invalid');
                validationErrors.push('Valid email is required');
                isValid = false;
            }
            
            if (!formData.telegram) {
                document.getElementById('telegram').classList.add('is-invalid');
                validationErrors.push('Telegram username is required');
                isValid = false;
            }
            
            if (!formData.jenisKelamin) {
                document.getElementById('jenis-kelamin').classList.add('is-invalid');
                validationErrors.push('Jenis kelamin must be selected');
                isValid = false;
            }
            
            if (!formData.agama) {
                document.getElementById('agama').classList.add('is-invalid');
                validationErrors.push('Agama must be selected');
                isValid = false;
            }
            
            if (!formData.boWeb) {
                document.getElementById('bo-web').classList.add('is-invalid');
                validationErrors.push('BO/Web must be selected');
                isValid = false;
            }
            
            if (!formData.jabatan) {
                document.getElementById('jabatan').classList.add('is-invalid');
                validationErrors.push('Jabatan must be selected');
                isValid = false;
            }
            
            if (!formData.tanggalBergabung) {
                document.getElementById('tanggal-bergabung').classList.add('is-invalid');
                validationErrors.push('Tanggal bergabung is required');
                isValid = false;
            }
            
            if (!formData.termsAgree) {
                document.getElementById('terms-agree').classList.add('is-invalid');
                validationErrors.push('You must agree to the terms');
                isValid = false;
            }
            
            debugLog(`Validation complete. Valid: ${isValid}`);
            if (validationErrors.length > 0) {
                debugLog('Validation errors: ' + validationErrors.join(', '));
            }
            
            if (!isValid) {
                showError('Please fill in all required fields correctly.');
                debugLog('Form submission prevented due to validation errors');
                e.preventDefault(); // Only prevent submission if validation fails
                return false;
            }
            
            // If we get here, the form is valid - let it submit naturally
            debugLog('Form validation passed! Submitting to Laravel backend...');
            debugLog('Form will now submit to: ' + this.action);
            
            // Show loading state
            const submitButton = this.querySelector('.btn-auth');
            const originalText = submitButton.innerHTML;
            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Creating Account...';
            submitButton.disabled = true;
            
            // Don't prevent default - let the form submit to Laravel
            // The form will now submit to /signup
        });
        
        // Initial debug message
        debugLog('Registration form loaded and ready');
        
        // Add event listeners for real-time validation feedback
        document.addEventListener('DOMContentLoaded', function() {
            // Email validation on blur
            document.getElementById('register-email').addEventListener('blur', function() {
                if (this.value && !validateEmail(this.value)) {
                    this.classList.add('is-invalid');
                    debugLog('Email validation failed');
                } else if (this.value) {
                    this.classList.remove('is-invalid');
                    debugLog('Email validation passed');
                }
            });
            
            // Password validation on input
            document.getElementById('register-password').addEventListener('input', function() {
                if (this.value && !validatePassword(this.value)) {
                    this.classList.add('is-invalid');
                } else if (this.value) {
                    this.classList.remove('is-invalid');
                }
            });
            
            debugLog('Real-time validation listeners added');
        });
    </script>
</body>
</html>