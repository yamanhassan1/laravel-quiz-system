<nav class="bg-white border-b border-gray-100 px-6 py-0">
    <div class="flex justify-between items-center max-w-5xl mx-auto h-14">
        <div class="flex items-center gap-2">
            <div class="w-7 h-7 rounded-lg bg-emerald-600 flex items-center justify-center">
                <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M7 1L9.5 5.5H12.5L10 8.5L11 12.5L7 10.5L3 12.5L4 8.5L1.5 5.5H4.5L7 1Z" fill="white"/></svg>
            </div>
            <span class="text-emerald-900 font-semibold text-[15px] tracking-tight">Quiz System</span>
        </div>
        <div class="flex items-center gap-1">
            <a class="text-slate-500 hover:text-emerald-700 hover:bg-emerald-50 px-3 py-1.5 rounded-lg text-sm font-medium transition-all duration-150" href="/">Home</a>
            <a class="text-slate-500 hover:text-emerald-700 hover:bg-emerald-50 px-3 py-1.5 rounded-lg text-sm font-medium transition-all duration-150" href="/">Categories</a>
            <a class="text-slate-500 hover:text-emerald-700 hover:bg-emerald-50 px-3 py-1.5 rounded-lg text-sm font-medium transition-all duration-150" href="/">Blog</a>
            <div class="w-px h-4 bg-gray-200 mx-1"></div>
            @if(session('user'))
            <a class="bg-emerald-50 hover:bg-emerald-100 text-emerald-700 px-4 py-1.5 rounded-lg text-sm font-medium transition-all duration-150" href="/user-details">Welcome, {{session('user')->name}}</a>
            <a class="text-red-500 hover:text-red-700 bg-red-50 hover:bg-red-100 px-4 py-1.5 rounded-lg text-sm font-medium transition-all duration-150" href="/user-logout">LogOut</a>
            @else
            <a class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-1.5 rounded-lg text-sm font-medium transition-all duration-150" href="/user-login">Login</a>
            <a class="bg-emerald-50 hover:bg-emerald-100 text-emerald-700 px-4 py-1.5 rounded-lg text-sm font-medium transition-all duration-150" href="/user-signup">Sign Up</a>
            @endif
        </div>
    </div>
</nav>