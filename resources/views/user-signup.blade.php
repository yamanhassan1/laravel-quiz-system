<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User SignUp — Quiz System</title>
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
            <p class="text-slate-400 text-sm mt-1">User SignUp</p>
        </div>

        {{-- Card --}}
        <div class="bg-white border border-gray-200 rounded-2xl p-8 shadow-sm">
            <h2 class="text-green-800 text-[15px] font-semibold mb-5">Create your account</h2>

            @error('user')
                <div class="bg-red-50 border border-red-200 text-red-600 text-sm rounded-lg px-4 py-2.5 mb-4 flex items-center gap-2">
                    <svg width="14" height="14" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                    {{$message}}
                </div>
            @enderror

            <form action="/user-signup" method="post" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-slate-600 text-xs font-medium mb-1.5 uppercase tracking-wide">Username</label>
                    <input type="text" name="name" placeholder="Enter user name"
                        class="w-full px-3.5 py-2.5 border border-gray-200 rounded-xl text-sm text-slate-800 bg-slate-50 focus:bg-white focus:border-green-400 focus:outline-none transition-all duration-150 placeholder:text-slate-300">
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-slate-600 text-xs font-medium mb-1.5 uppercase tracking-wide">User Email</label>
                    <input type="email" name="email" placeholder="Enter email address"
                        class="w-full px-3.5 py-2.5 border border-gray-200 rounded-xl text-sm text-slate-800 bg-slate-50 focus:bg-white focus:border-green-400 focus:outline-none transition-all duration-150 placeholder:text-slate-300">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-slate-600 text-xs font-medium mb-1.5 uppercase tracking-wide">Password</label>
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
                    Sign Up
                </button>
            </form>
        </div>

        <p class="text-center text-slate-400 text-xs mt-6">&copy; 2026 Quiz System</p>
    </div>
    </div>
</body>
</html>