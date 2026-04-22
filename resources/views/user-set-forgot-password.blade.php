<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Set Password — Quiz System</title>
    @vite('resources/css/app.css')
    <style>
        body { font-family: 'Inter', system-ui, sans-serif; }
    </style>
</head>
<body>
    <x-user-navbar></x-user-navbar>
    <div class="bg-green-50 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-sm">

        {{-- Logo / Brand --}}
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-11 h-11 rounded-xl bg-green-800 mb-4">
                <svg width="20" height="20" viewBox="0 0 14 14" fill="none"><path d="M7 1L9.5 5.5H12.5L10 8.5L11 12.5L7 10.5L3 12.5L4 8.5L1.5 5.5H4.5L7 1Z" fill="white"/></svg>
            </div>
            <h1 class="text-green-900 text-xl font-semibold tracking-tight">Quiz System</h1>
            <p class="text-slate-400 text-sm mt-1">User Set Password</p>
        </div>

        {{-- Card --}}
        <div class="bg-white border border-gray-200 rounded-2xl p-8 shadow-sm">
            <h2 class="text-green-800 text-[15px] font-semibold mb-5">Reset your Password</h2>

            <form action="/user-set-forgot-password" method="post" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-slate-600 text-xs font-medium mb-1.5 uppercase tracking-wide">User Email</label>
                    <input type="hidden" name="email" placeholder="Enter email address" value="{{$email}}"
                        class="w-full px-3.5 py-2.5 border border-gray-200 rounded-xl text-sm text-slate-800 bg-slate-50 focus:bg-white focus:border-green-400 focus:outline-none transition-all duration-150 placeholder:text-slate-300">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-slate-600 text-xs font-medium mb-1.5 uppercase tracking-wide">New Password</label>
                    <input type="password" name="password" placeholder="••••••••"
                        class="w-full px-3.5 py-2.5 border border-gray-200 rounded-xl text-sm text-slate-800 bg-slate-50 focus:bg-white focus:border-green-400 focus:outline-none transition-all duration-150 placeholder:text-slate-300">
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-slate-600 text-xs font-medium mb-1.5 uppercase tracking-wide">Confirm Password</label>
                    <input type="password" name="password_confirmation" placeholder="••••••••"
                        class="w-full px-3.5 py-2.5 border border-gray-200 rounded-xl text-sm text-slate-800 bg-slate-50 focus:bg-white focus:border-green-400 focus:outline-none transition-all duration-150 placeholder:text-slate-300">
                </div>
                <button type="submit"
                    class="w-full py-2.5 bg-green-800 hover:bg-green-900 text-white text-sm font-medium rounded-xl transition-all duration-150 mt-1 cursor-pointer">
                    Update Password
                </button>
            </form>
        </div>

        <p class="text-center text-slate-400 text-xs mt-6">&copy; 2026 Quiz System</p>
    </div>
    </div>
</body>
</html>