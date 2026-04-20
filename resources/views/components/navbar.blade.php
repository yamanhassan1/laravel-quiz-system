<nav class="bg-white border-b border-gray-200 px-6 py-0">
    <div class="flex justify-between items-center max-w-7xl mx-auto h-14">
        <div class="flex items-center gap-2">
            <div class="w-7 h-7 rounded-lg bg-slate-800 flex items-center justify-center">
                <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M7 1L9.5 5.5H12.5L10 8.5L11 12.5L7 10.5L3 12.5L4 8.5L1.5 5.5H4.5L7 1Z" fill="white"/></svg>
            </div>
            <span class="text-slate-800 font-semibold text-[15px] tracking-tight">Quiz System</span>
            <span class="ml-1 text-[10px] font-semibold bg-slate-100 text-slate-500 px-1.5 py-0.5 rounded uppercase tracking-wider">Admin</span>
        </div>
        <div class="flex items-center gap-1">
            <a class="text-slate-500 hover:text-slate-900 hover:bg-slate-50 px-3 py-1.5 rounded-lg text-sm font-medium transition-all duration-150" href="/dashboard">Dashboard</a>
            <a class="text-slate-500 hover:text-slate-900 hover:bg-slate-50 px-3 py-1.5 rounded-lg text-sm font-medium transition-all duration-150" href="/admin-categories">Categories</a>
            <a class="text-slate-500 hover:text-slate-900 hover:bg-slate-50 px-3 py-1.5 rounded-lg text-sm font-medium transition-all duration-150" href="/add-quiz">Quiz</a>
            <div class="w-px h-4 bg-gray-200 mx-2"></div>
            <span class="text-slate-600 text-sm font-medium px-3">{{$name}}</span>
            <a class="text-red-500 hover:text-red-700 hover:bg-red-50 px-3 py-1.5 rounded-lg text-sm font-medium transition-all duration-150" href="/admin-logout">Logout</a>
        </div>
    </div>
</nav>