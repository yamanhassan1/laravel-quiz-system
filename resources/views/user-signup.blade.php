<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Create your Quiz System account to start testing your knowledge">
    <title>User SignUp — Quiz System</title>
    @vite('resources/css/app.css')
    <style>
        body { font-family: 'Inter', system-ui, sans-serif; }
        
        input:focus {
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
        }
        
        .password-strength-bar {
            transition: all 0.3s ease;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-green-50 via-emerald-50 to-teal-50">
    <x-user-navbar></x-user-navbar>
    
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-md">
            
            {{-- Logo / Brand --}}
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-gradient-to-br from-green-700 to-emerald-700 shadow-lg mb-4">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2L15.5 9H22L16.5 14L19 21L12 16.5L5 21L7.5 14L2 9H8.5L12 2Z" fill="white" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <h1 class="text-green-900 text-2xl font-bold tracking-tight">Quiz System</h1>
                <p class="text-slate-500 text-sm mt-1">Create your account to start learning</p>
            </div>

            {{-- Card --}}
            <div class="bg-white/90 backdrop-blur-sm border border-gray-100 rounded-2xl p-8 shadow-xl">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-green-800 text-lg font-bold">Sign Up</h2>
                    <div class="flex gap-1">
                        <div class="w-2 h-2 rounded-full bg-green-200"></div>
                        <div class="w-2 h-2 rounded-full bg-green-300"></div>
                        <div class="w-2 h-2 rounded-full bg-green-400"></div>
                    </div>
                </div>

                {{-- Success Message --}}
                @if(session('message-success'))
                    <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 text-sm rounded-lg px-4 py-3 mb-4 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        {{ session('message-success') }}
                    </div>
                @endif

                {{-- Error Alert --}}
                @if($errors->any())
                    <div class="bg-red-50 border-l-4 border-red-500 text-red-700 text-sm rounded-lg px-4 py-3 mb-4">
                        <div class="flex items-center gap-2 mb-1">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            <span class="font-semibold">Please fix the following errors:</span>
                        </div>
                        <ul class="list-disc list-inside text-xs space-y-0.5">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="/user-signup" method="post" id="signupForm" class="space-y-5">
                    @csrf
                    
                    {{-- Username Field --}}
                    <div>
                        <label class="block text-slate-700 text-xs font-bold mb-2 uppercase tracking-wide">
                            Username <span class="text-red-500">*</span>
                        </label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-4 w-4 text-slate-400 group-focus-within:text-green-600 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <input type="text" 
                                   name="name" 
                                   id="username"
                                   value="{{ old('name') }}"
                                   placeholder="Enter username"
                                   class="w-full pl-9 pr-3 py-2.5 border border-gray-200 rounded-xl text-sm text-slate-800 bg-slate-50 focus:bg-white focus:border-green-400 focus:outline-none transition-all duration-150 placeholder:text-slate-300">
                        </div>
                        <p class="text-slate-400 text-xs mt-1.5">Username must be at least 3 characters</p>
                    </div>
                    
                    {{-- Email Field --}}
                    <div>
                        <label class="block text-slate-700 text-xs font-bold mb-2 uppercase tracking-wide">
                            Email Address <span class="text-red-500">*</span>
                        </label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-4 w-4 text-slate-400 group-focus-within:text-green-600 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <input type="email" 
                                   name="email" 
                                   id="email"
                                   value="{{ old('email') }}"
                                   placeholder="you@example.com"
                                   class="w-full pl-9 pr-3 py-2.5 border border-gray-200 rounded-xl text-sm text-slate-800 bg-slate-50 focus:bg-white focus:border-green-400 focus:outline-none transition-all duration-150 placeholder:text-slate-300">
                        </div>
                    </div>
                    
                    {{-- Password Field --}}
                    <div>
                        <label class="block text-slate-700 text-xs font-bold mb-2 uppercase tracking-wide">
                            Password <span class="text-red-500">*</span>
                        </label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-4 w-4 text-slate-400 group-focus-within:text-green-600 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </div>
                            <input type="password" 
                                   name="password" 
                                   id="password"
                                   placeholder="Create a strong password"
                                   class="w-full pl-9 pr-10 py-2.5 border border-gray-200 rounded-xl text-sm text-slate-800 bg-slate-50 focus:bg-white focus:border-green-400 focus:outline-none transition-all duration-150 placeholder:text-slate-300">
                            <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <svg class="h-4 w-4 text-slate-400 hover:text-slate-600 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                        
                        {{-- Password Strength Indicator --}}
                        <div class="mt-2">
                            <div class="flex gap-1 mb-1">
                                <div class="strength-bar flex-1 h-1 rounded-full bg-gray-200"></div>
                                <div class="strength-bar flex-1 h-1 rounded-full bg-gray-200"></div>
                                <div class="strength-bar flex-1 h-1 rounded-full bg-gray-200"></div>
                            </div>
                            <p id="strengthText" class="text-xs text-slate-400">Password strength: Not entered</p>
                        </div>
                    </div>
                    
                    {{-- Confirm Password Field --}}
                    <div>
                        <label class="block text-slate-700 text-xs font-bold mb-2 uppercase tracking-wide">
                            Confirm Password <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </div>
                            <input type="password" 
                                   name="password_confirmation" 
                                   id="password_confirmation"
                                   placeholder="Confirm your password"
                                   class="w-full pl-9 pr-3 py-2.5 border border-gray-200 rounded-xl text-sm text-slate-800 bg-slate-50 focus:bg-white focus:border-green-400 focus:outline-none transition-all duration-150 placeholder:text-slate-300">
                        </div>
                        <p id="matchMessage" class="text-xs mt-1.5"></p>
                    </div>
                    
                    {{-- Terms and Conditions --}}
                    <div class="flex items-start gap-2 pt-2">
                        <input type="checkbox" 
                               name="terms" 
                               id="terms" 
                               value="1"
                               class="mt-0.5 w-3.5 h-3.5 rounded border-gray-300 text-green-600 focus:ring-green-500 cursor-pointer">
                        <label for="terms" class="text-xs text-slate-600 leading-relaxed cursor-pointer">
                            I agree to the 
                            <a href="#" class="text-green-600 hover:text-green-700 font-medium hover:underline">Terms of Service</a> 
                            and 
                            <a href="#" class="text-green-600 hover:text-green-700 font-medium hover:underline">Privacy Policy</a>
                        </label>
                    </div>
                    
                    {{-- Submit Button --}}
                    <button type="submit"
                            id="submitBtn"
                            class="w-full py-2.5 bg-gradient-to-r from-green-700 to-emerald-700 hover:from-green-800 hover:to-emerald-800 text-white text-sm font-semibold rounded-xl transition-all duration-150 mt-2 shadow-md hover:shadow-lg">
                        Create Account
                    </button>
                    
                    {{-- Login Link --}}
                    <div class="text-center text-sm text-slate-600 pt-3">
                        Already have an account? 
                        <a href="/user-login" class="text-green-600 hover:text-green-700 font-semibold hover:underline">
                            Log In Here
                        </a>
                    </div>
                </form>
            </div>
            
            {{-- Footer --}}
            <p class="text-center text-slate-400 text-xs mt-6">
                © {{ date('Y') }} Quiz System. All rights reserved.
            </p>
        </div>
    </div>
    
    <script>
        // Password strength checker
        const passwordInput = document.getElementById('password');
        const confirmInput = document.getElementById('password_confirmation');
        const strengthBars = document.querySelectorAll('.strength-bar');
        const strengthText = document.getElementById('strengthText');
        const matchMessage = document.getElementById('matchMessage');
        const submitBtn = document.getElementById('submitBtn');
        const termsCheckbox = document.getElementById('terms');
        const form = document.getElementById('signupForm');
        
        function checkPasswordStrength(password) {
            let strength = 0;
            
            // Length check
            if (password.length >= 8) strength++;
            
            // Contains number
            if (/[0-9]/.test(password)) strength++;
            
            // Contains uppercase and lowercase
            if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength++;
            
            // Update strength bars
            const colors = ['bg-red-400', 'bg-orange-400', 'bg-yellow-400', 'bg-green-500'];
            
            strengthBars.forEach((bar, index) => {
                if (index < strength) {
                    bar.classList.remove('bg-gray-200');
                    bar.classList.add(colors[strength - 1]);
                } else {
                    bar.classList.remove('bg-red-400', 'bg-orange-400', 'bg-yellow-400', 'bg-green-500');
                    bar.classList.add('bg-gray-200');
                }
            });
            
            if (password.length === 0) {
                strengthText.textContent = 'Password strength: Not entered';
                strengthText.className = 'text-xs text-slate-400';
            } else if (strength === 3) {
                strengthText.textContent = 'Strong password';
                strengthText.className = 'text-xs text-green-600 font-medium';
            } else if (strength === 2) {
                strengthText.textContent = 'Medium strength - add numbers and mix case';
                strengthText.className = 'text-xs text-yellow-600';
            } else if (strength === 1) {
                strengthText.textContent = 'Weak password - use 8+ characters with numbers and mixed case';
                strengthText.className = 'text-xs text-orange-600';
            } else {
                strengthText.textContent = 'Very weak - use at least 8 characters';
                strengthText.className = 'text-xs text-red-600';
            }
            
            return strength;
        }
        
        function checkPasswordMatch() {
            const password = passwordInput.value;
            const confirm = confirmInput.value;
            
            if (confirm.length === 0) {
                matchMessage.textContent = '';
                return false;
            }
            
            if (password === confirm) {
                matchMessage.textContent = 'Passwords match';
                matchMessage.className = 'text-xs text-green-600 mt-1.5';
                return true;
            } else {
                matchMessage.textContent = 'Passwords do not match';
                matchMessage.className = 'text-xs text-red-500 mt-1.5';
                return false;
            }
        }
        
        function validateForm() {
            const password = passwordInput.value;
            const strength = checkPasswordStrength(password);
            const passwordsMatch = checkPasswordMatch();
            const termsAccepted = termsCheckbox.checked;
            
            if (password.length > 0 && strength >= 2 && passwordsMatch && termsAccepted) {
                submitBtn.disabled = false;
                submitBtn.style.opacity = '1';
                submitBtn.style.cursor = 'pointer';
            } else {
                submitBtn.disabled = true;
                submitBtn.style.opacity = '0.6';
                submitBtn.style.cursor = 'not-allowed';
            }
        }
        
        // Event listeners
        if (passwordInput) {
            passwordInput.addEventListener('input', () => {
                checkPasswordStrength(passwordInput.value);
                checkPasswordMatch();
                validateForm();
            });
        }
        
        if (confirmInput) {
            confirmInput.addEventListener('input', () => {
                checkPasswordMatch();
                validateForm();
            });
        }
        
        if (termsCheckbox) {
            termsCheckbox.addEventListener('change', validateForm);
        }
        
        // Toggle password visibility
        const toggleBtn = document.getElementById('togglePassword');
        if (toggleBtn) {
            toggleBtn.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                
                const icon = this.querySelector('svg');
                if (type === 'text') {
                    icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.977 9.977 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>';
                } else {
                    icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>';
                }
            });
        }
        
        // Real-time validation for email format
        const emailInput = document.querySelector('input[name="email"]');
        if (emailInput) {
            emailInput.addEventListener('input', function() {
                const email = this.value;
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                
                if (email.length > 0 && !emailRegex.test(email)) {
                    this.style.borderColor = '#ef4444';
                } else if (email.length > 0) {
                    this.style.borderColor = '#10b981';
                } else {
                    this.style.borderColor = '#e5e7eb';
                }
            });
        }
        
        // Real-time validation for username
        const usernameInput = document.querySelector('input[name="name"]');
        if (usernameInput) {
            usernameInput.addEventListener('input', function() {
                const username = this.value;
                
                if (username.length > 0 && username.length < 3) {
                    this.style.borderColor = '#ef4444';
                } else if (username.length >= 3) {
                    this.style.borderColor = '#10b981';
                } else {
                    this.style.borderColor = '#e5e7eb';
                }
            });
        }
        
        // Form submission with simple disabled state (no loading animation)
        if (form) {
            form.addEventListener('submit', function(e) {
                const password = passwordInput?.value;
                const confirm = confirmInput?.value;
                const terms = termsCheckbox?.checked;
                let hasError = false;
                
                // Client-side validation
                if (!password || password.length < 8) {
                    if (passwordInput) {
                        passwordInput.classList.add('input-error');
                    }
                    hasError = true;
                }
                
                if (!confirm || password !== confirm) {
                    if (confirmInput) {
                        confirmInput.classList.add('input-error');
                    }
                    hasError = true;
                }
                
                if (!terms) {
                    hasError = true;
                }
                
                if (hasError) {
                    e.preventDefault();
                    return false;
                }
                
                // Disable button on submit (no loading animation)
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.style.opacity = '0.7';
                    submitBtn.textContent = 'Creating account...';
                }
            });
        }
        
        // Remove error styling on focus
        const inputs = document.querySelectorAll('input');
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.classList.remove('input-error');
                if (this.name === 'email' || this.name === 'name') {
                    this.style.borderColor = '#e5e7eb';
                }
            });
        });
        
        // Initialize form validation on page load
        validateForm();
    </script>
</body>
</html>