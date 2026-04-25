<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Reset your password for Quiz System. Enter your email to receive password reset instructions.">
    <title>Forgot Password — Quiz System</title>
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
                <p class="text-slate-500 text-sm mt-1">Reset your password</p>
            </div>
            
            {{-- Card --}}
            <div class="bg-white/90 backdrop-blur-sm border border-gray-100 rounded-2xl p-8 shadow-xl">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-green-800 text-lg font-bold">Forgot Password?</h2>
                    <div class="flex gap-1">
                        <div class="w-2 h-2 rounded-full bg-green-200"></div>
                        <div class="w-2 h-2 rounded-full bg-green-300"></div>
                        <div class="w-2 h-2 rounded-full bg-green-400"></div>
                    </div>
                </div>
                
                {{-- Info Text --}}
                <div class="mb-5">
                    <div class="flex items-start gap-3 p-3 bg-blue-50 rounded-xl border border-blue-100">
                        <svg class="w-4 h-4 text-blue-600 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-xs text-blue-700 leading-relaxed">
                            Enter your email address and we'll send you a link to reset your password. You'll receive instructions to create a new password.
                        </p>
                    </div>
                </div>
                
                {{-- Success Message --}}
                @if(session('message-success'))
                    <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 text-sm rounded-lg px-4 py-3 mb-4 flex items-center gap-2">
                        <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span>{{ session('message-success') }}</span>
                    </div>
                @endif
                
                {{-- Error Messages --}}
                @if(session('message-error'))
                    <div class="bg-red-50 border-l-4 border-red-500 text-red-700 text-sm rounded-lg px-4 py-3 mb-4 flex items-center gap-2">
                        <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        <span>{{ session('message-error') }}</span>
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
                
                <form action="/user-forgot-password" method="post" id="forgotPasswordForm" class="space-y-5">
                    @csrf
                    
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
                                   autocomplete="email"
                                   autofocus
                                   class="w-full pl-9 pr-3 py-2.5 border border-gray-200 rounded-xl text-sm text-slate-800 bg-slate-50 focus:bg-white focus:border-green-400 focus:outline-none transition-all duration-150 placeholder:text-slate-300">
                        </div>
                        @error('email')
                            <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                        <p id="emailHint" class="text-xs text-slate-400 mt-1.5">We'll send a password reset link to this email</p>
                    </div>
                    
                    {{-- Submit Button --}}
                    <button type="submit"
                            id="submitBtn"
                            class="w-full py-2.5 bg-gradient-to-r from-green-700 to-emerald-700 hover:from-green-800 hover:to-emerald-800 text-white text-sm font-semibold rounded-xl transition-all duration-150 mt-2 shadow-md hover:shadow-lg">
                        Send Reset Link
                    </button>
                    
                    {{-- Back to Login Link --}}
                    <div class="text-center text-sm text-slate-600 pt-2">
                        <a href="/user-login" class="text-green-600 hover:text-green-700 font-semibold hover:underline inline-flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Back to Login
                        </a>
                    </div>
                </form>
                
                {{-- Help Text --}}
                <div class="mt-5 pt-4 border-t border-gray-100">
                    <div class="flex items-center justify-center gap-4">
                        <div class="flex items-center gap-1.5">
                            <div class="w-1.5 h-1.5 rounded-full bg-green-300"></div>
                            <span class="text-[10px] text-slate-400">Check spam folder</span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <div class="w-1.5 h-1.5 rounded-full bg-green-300"></div>
                            <span class="text-[10px] text-slate-400">Link expires in 60 min</span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <div class="w-1.5 h-1.5 rounded-full bg-green-300"></div>
                            <span class="text-[10px] text-slate-400">Contact support</span>
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- Footer --}}
            <p class="text-center text-slate-400 text-xs mt-6">
                © {{ date('Y') }} Quiz System. All rights reserved.
            </p>
        </div>
    </div>
    
    <script>
        const emailInput = document.getElementById('email');
        const submitBtn = document.getElementById('submitBtn');
        const emailHint = document.getElementById('emailHint');
        const form = document.getElementById('forgotPasswordForm');
        
        // Real-time email validation
        function validateEmail(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }
        
        function updateEmailValidation() {
            const email = emailInput.value.trim();
            
            if (email.length === 0) {
                emailInput.classList.remove('input-error', 'input-success');
                emailHint.textContent = 'We\'ll send a password reset link to this email';
                emailHint.className = 'text-xs text-slate-400 mt-1.5';
                return false;
            }
            
            if (validateEmail(email)) {
                emailInput.classList.add('input-success');
                emailInput.classList.remove('input-error');
                emailHint.textContent = 'Valid email address';
                emailHint.className = 'text-xs text-green-600 mt-1.5';
                return true;
            } else {
                emailInput.classList.add('input-error');
                emailInput.classList.remove('input-success');
                emailHint.textContent = 'Please enter a valid email address (e.g., name@example.com)';
                emailHint.className = 'text-xs text-red-500 mt-1.5';
                return false;
            }
        }
        
        function validateForm() {
            const email = emailInput.value.trim();
            const isValid = email.length > 0 && validateEmail(email);
            
            if (isValid) {
                submitBtn.disabled = false;
                submitBtn.style.opacity = '1';
                submitBtn.style.cursor = 'pointer';
            } else {
                submitBtn.disabled = true;
                submitBtn.style.opacity = '0.6';
                submitBtn.style.cursor = 'not-allowed';
            }
            
            return isValid;
        }
        
        // Email input event listeners
        if (emailInput) {
            emailInput.addEventListener('input', () => {
                updateEmailValidation();
                validateForm();
            });
            
            emailInput.addEventListener('blur', () => {
                updateEmailValidation();
            });
            
            emailInput.addEventListener('focus', () => {
                if (emailInput.classList.contains('input-error')) {
                    emailInput.classList.remove('input-error');
                    emailHint.textContent = 'We\'ll send a password reset link to this email';
                    emailHint.className = 'text-xs text-slate-400 mt-1.5';
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
        if (form) {
            form.addEventListener('submit', function(e) {
                const email = emailInput?.value.trim();
                
                // Client-side validation
                if (!email || !validateEmail(email)) {
                    e.preventDefault();
                    if (emailInput) {
                        emailInput.classList.add('input-error');
                    }
                    emailHint.textContent = 'Please enter a valid email address';
                    emailHint.className = 'text-xs text-red-500 mt-1.5';
                    return false;
                }
                
                // Disable button on submit (no loading animation)
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.style.opacity = '0.7';
                    submitBtn.textContent = 'Sending...';
                }
            });
        }
        
        // Initialize form validation on page load
        if (emailInput && emailInput.value.trim().length > 0) {
            updateEmailValidation();
            validateForm();
        } else {
            validateForm();
        }
        
        // Auto-focus on email field
        if (emailInput) {
            emailInput.focus();
        }
        
        // Prevent multiple submissions
        let submitted = false;
        if (form) {
            form.addEventListener('submit', function(e) {
                if (submitted) {
                    e.preventDefault();
                    return false;
                }
                submitted = true;
            });
        }
    </script>
</body>
</html>