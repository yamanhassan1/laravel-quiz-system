<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Reset your password and regain access to your Quiz System account">
    <title>Reset Password — Quiz System</title>
    @vite('resources/css/app.css')
    <style>
        body { font-family: 'Inter', system-ui, sans-serif; }
        
        input:focus {
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
        }
        
        .input-error {
            border-color: #ef4444 !important;
            background-color: #fef2f2 !important;
        }
        
        .input-success {
            border-color: #10b981 !important;
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
                <p class="text-slate-500 text-sm mt-1">Create a new password for your account</p>
            </div>
            
            {{-- Card --}}
            <div class="bg-white/90 backdrop-blur-sm border border-gray-100 rounded-2xl p-8 shadow-xl">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-green-800 text-lg font-bold">Reset Password</h2>
                    <div class="flex gap-1">
                        <div class="w-2 h-2 rounded-full bg-green-200"></div>
                        <div class="w-2 h-2 rounded-full bg-green-300"></div>
                        <div class="w-2 h-2 rounded-full bg-green-400"></div>
                    </div>
                </div>
                
                {{-- Error Messages --}}
                @if(session('message-error'))
                    <div class="bg-red-50 border-l-4 border-red-500 text-red-700 text-sm rounded-lg px-4 py-3 mb-4 flex items-center gap-2">
                        <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        <span>{{ session('message-error') }}</span>
                    </div>
                @endif
                
                {{-- Success Message --}}
                @if(session('message-success'))
                    <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 text-sm rounded-lg px-4 py-3 mb-4 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span>{{ session('message-success') }}</span>
                    </div>
                @endif
                
                {{-- Validation Errors --}}
                @if($errors->any())
                    <div class="bg-red-50 border-l-4 border-red-500 text-red-700 text-sm rounded-lg px-4 py-3 mb-4">
                        <div class="flex items-center gap-2 mb-1">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            <span class="font-semibold">Please fix the following:</span>
                        </div>
                        <ul class="list-disc list-inside text-xs space-y-0.5">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                {{-- Email Info Box --}}
                <div class="bg-blue-50 border border-blue-100 rounded-xl px-4 py-3 mb-5">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <p class="text-xs text-blue-700">
                            Resetting password for: <span class="font-semibold">{{ $email ?? 'your account' }}</span>
                        </p>
                    </div>
                </div>
                
                <form action="/user-set-forgot-password" method="post" id="resetPasswordForm" class="space-y-5">
                    @csrf
                    
                    {{-- Hidden Email Field --}}
                    <input type="hidden" name="email" value="{{ $email ?? '' }}">
                    
                    {{-- New Password Field --}}
                    <div>
                        <label class="block text-slate-700 text-xs font-bold mb-2 uppercase tracking-wide">
                            New Password <span class="text-red-500">*</span>
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
                                <div class="strength-bar flex-1 h-1 rounded-full bg-gray-200"></div>
                            </div>
                            <p id="strengthText" class="text-xs text-slate-400">Password strength: Not entered</p>
                        </div>
                        
                        {{-- Password Requirements --}}
                        <div class="mt-2 space-y-1">
                            <p class="text-xs text-slate-500 font-medium mb-1">Password must contain:</p>
                            <ul class="text-xs space-y-0.5">
                                <li id="req-length" class="flex items-center gap-1.5 text-slate-400">
                                    <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    At least 8 characters
                                </li>
                                <li id="req-uppercase" class="flex items-center gap-1.5 text-slate-400">
                                    <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    One uppercase letter (A-Z)
                                </li>
                                <li id="req-number" class="flex items-center gap-1.5 text-slate-400">
                                    <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    One number (0-9)
                                </li>
                                <li id="req-special" class="flex items-center gap-1.5 text-slate-400">
                                    <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    One special character (!@#$%^&*)
                                </li>
                            </ul>
                        </div>
                        
                        @error('password')
                            <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    
                    {{-- Confirm Password Field --}}
                    <div>
                        <label class="block text-slate-700 text-xs font-bold mb-2 uppercase tracking-wide">
                            Confirm New Password <span class="text-red-500">*</span>
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
                                   placeholder="Confirm your new password"
                                   class="w-full pl-9 pr-3 py-2.5 border border-gray-200 rounded-xl text-sm text-slate-800 bg-slate-50 focus:bg-white focus:border-green-400 focus:outline-none transition-all duration-150 placeholder:text-slate-300">
                        </div>
                        <p id="matchMessage" class="text-xs mt-1.5"></p>
                    </div>
                    
                    {{-- Password Tips --}}
                    <div class="bg-amber-50 border border-amber-100 rounded-xl px-3 py-2">
                        <div class="flex items-start gap-2">
                            <svg class="w-3.5 h-3.5 text-amber-600 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="text-xs text-amber-700">
                                <span class="font-semibold">Password tips:</span> Use a mix of letters, numbers, and symbols. Avoid common words or personal information.
                            </p>
                        </div>
                    </div>
                    
                    {{-- Submit Button --}}
                    <button type="submit"
                            id="submitBtn"
                            class="w-full py-2.5 bg-gradient-to-r from-green-700 to-emerald-700 hover:from-green-800 hover:to-emerald-800 text-white text-sm font-semibold rounded-xl transition-all duration-150 mt-2 shadow-md hover:shadow-lg">
                        Update Password
                    </button>
                    
                    {{-- Back to Login Link --}}
                    <div class="text-center text-sm text-slate-600 pt-2">
                        Remember your password? 
                        <a href="/user-login" class="text-green-600 hover:text-green-700 font-semibold hover:underline">
                            Back to Login
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
        
        // Requirement elements
        const reqLength = document.getElementById('req-length');
        const reqUppercase = document.getElementById('req-uppercase');
        const reqNumber = document.getElementById('req-number');
        const reqSpecial = document.getElementById('req-special');
        
        function checkPasswordStrength(password) {
            let strength = 0;
            
            // Check each requirement
            const hasLength = password.length >= 8;
            const hasUppercase = /[A-Z]/.test(password);
            const hasNumber = /[0-9]/.test(password);
            const hasSpecial = /[!@#$%^&*(),.?":{}|<>]/.test(password);
            
            // Update requirements list
            updateRequirement(reqLength, hasLength);
            updateRequirement(reqUppercase, hasUppercase);
            updateRequirement(reqNumber, hasNumber);
            updateRequirement(reqSpecial, hasSpecial);
            
            // Calculate strength
            if (hasLength) strength++;
            if (hasUppercase) strength++;
            if (hasNumber) strength++;
            if (hasSpecial) strength++;
            
            // Update strength bars
            const colors = ['bg-red-400', 'bg-orange-400', 'bg-yellow-400', 'bg-green-500'];
            const texts = ['Weak', 'Fair', 'Good', 'Strong'];
            
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
            } else if (strength === 4) {
                strengthText.textContent = 'Strong password';
                strengthText.className = 'text-xs text-green-600 font-medium';
            } else if (strength === 3) {
                strengthText.textContent = 'Good password - could be stronger';
                strengthText.className = 'text-xs text-yellow-600';
            } else if (strength === 2) {
                strengthText.textContent = 'Weak password - add more variety';
                strengthText.className = 'text-xs text-orange-600';
            } else {
                strengthText.textContent = 'Very weak - please strengthen your password';
                strengthText.className = 'text-xs text-red-600';
            }
            
            return strength;
        }
        
        function updateRequirement(element, isValid) {
            if (element) {
                if (isValid) {
                    element.className = 'flex items-center gap-1.5 text-green-600';
                    element.querySelector('svg').className = 'w-2.5 h-2.5 text-green-500';
                } else {
                    element.className = 'flex items-center gap-1.5 text-slate-400';
                    element.querySelector('svg').className = 'w-2.5 h-2.5 text-slate-300';
                }
            }
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
            
            if (password.length > 0 && strength >= 3 && passwordsMatch) {
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
        
        // Remove error styling on focus
        const inputs = document.querySelectorAll('input');
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.classList.remove('input-error');
            });
        });
        
        // Form submission with simple disabled state (no loading animation)
        const form = document.getElementById('resetPasswordForm');
        if (form) {
            form.addEventListener('submit', function(e) {
                const password = passwordInput?.value;
                const confirm = confirmInput?.value;
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
                
                if (hasError) {
                    e.preventDefault();
                    return false;
                }
                
                // Disable button on submit (no loading animation)
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.style.opacity = '0.7';
                    submitBtn.textContent = 'Updating...';
                }
            });
        }
        
        // Initialize validation on page load
        validateForm();
    </script>
</body>
</html>