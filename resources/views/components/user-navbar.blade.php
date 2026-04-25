<nav class="bg-white border-b border-gray-100 px-4 sm:px-6 py-0 sticky top-0 z-50 shadow-sm">
    <div class="flex justify-between items-center max-w-5xl mx-auto h-14 gap-3 sm:gap-4">

        {{-- Brand --}}
        <a href="/" class="flex items-center gap-2 shrink-0 group">
            <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-emerald-600 to-green-700 flex items-center justify-center shadow-sm group-hover:scale-105 transition-transform">
                <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                    <path d="M7 1L9.5 5.5H12.5L10 8.5L11 12.5L7 10.5L3 12.5L4 8.5L1.5 5.5H4.5L7 1Z" fill="white"/>
                </svg>
            </div>
            <span class="text-emerald-900 font-bold text-[15px] tracking-tight">Quiz System</span>
        </a>

        {{-- Search Bar --}}
        <form action="/quiz-search" method="GET" class="flex-1 max-w-xs hidden sm:block">
            <div class="relative">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" xmlns="http://www.w3.org/2000/svg" height="15px" viewBox="0 -960 960 960" width="15px" fill="currentColor">
                    <path d="M784-120 532-372q-30 24-69 38t-83 14q-109 0-184.5-75.5T120-580q0-109 75.5-184.5T380-840q109 0 184.5 75.5T640-580q0 44-14 83t-38 69l252 252-56 56ZM380-400q75 0 127.5-52.5T560-580q0-75-52.5-127.5T380-760q-75 0-127.5 52.5T200-580q0 75 52.5 127.5T380-400Z"/>
                </svg>
                <input
                    type="text"
                    name="search"
                    placeholder="Search quizzes..."
                    class="w-full pl-9 pr-4 py-1.5 text-sm bg-slate-50 border border-gray-200 rounded-lg text-slate-700 placeholder:text-slate-400 focus:outline-none focus:border-emerald-400 focus:bg-white transition-all duration-150"
                >
            </div>
        </form>

        {{-- Nav Links + Auth --}}
        <div class="flex items-center gap-1 shrink-0">

            {{-- Desktop Navigation Links --}}
            <a class="text-slate-500 hover:text-emerald-700 hover:bg-emerald-50 px-3 py-1.5 rounded-lg text-sm font-medium transition-all duration-150 hidden md:inline-flex items-center gap-1" href="/">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Home
            </a>
            <a class="text-slate-500 hover:text-emerald-700 hover:bg-emerald-50 px-3 py-1.5 rounded-lg text-sm font-medium transition-all duration-150 hidden md:inline-flex items-center gap-1" href="/categories-list">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
                Categories
            </a>

            {{-- Learning Platform Dropdown --}}
            <div class="relative hidden md:block" id="learning-menu-wrapper">
                <button id="learning-menu-btn"
                    class="flex items-center gap-1 text-slate-500 hover:text-emerald-700 hover:bg-emerald-50 px-3 py-1.5 rounded-lg text-sm font-medium transition-all duration-150 cursor-pointer">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    Resources
                    <svg class="w-3 h-3 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div id="learning-dropdown"
                    class="hidden absolute right-0 mt-2 w-56 bg-white border border-gray-200 rounded-xl shadow-lg overflow-hidden z-50">
                    <a href="/cheat-sheets"
                        class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-600 hover:bg-emerald-50 hover:text-emerald-700 transition-colors duration-100">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Cheat Sheets
                    </a>
                    <a href="/tutorials"
                        class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-600 hover:bg-emerald-50 hover:text-emerald-700 transition-colors duration-100">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"/>
                        </svg>
                        Tutorials
                    </a>
                    <a href="/blog"
                        class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-600 hover:bg-emerald-50 hover:text-emerald-700 transition-colors duration-100">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                        </svg>
                        Blog
                    </a>
                    <div class="border-t border-gray-100"></div>
                    <a href="/practice"
                        class="flex items-center gap-3 px-4 py-2.5 text-sm text-emerald-600 hover:bg-emerald-50 transition-colors duration-100">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                        Practice Challenges
                    </a>
                </div>
            </div>

            <div class="w-px h-4 bg-gray-200 mx-1 hidden md:block"></div>

            @if(session('user'))
                {{-- User Dropdown --}}
                <div class="relative" id="user-menu-wrapper">
                    <button id="user-menu-btn"
                        class="flex items-center gap-2 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 pl-2 pr-3 py-1.5 rounded-lg text-sm font-medium transition-all duration-150 cursor-pointer">
                        <div class="w-6 h-6 rounded-md bg-gradient-to-br from-emerald-600 to-green-700 text-white flex items-center justify-center text-xs font-bold shrink-0">
                            {{ strtoupper(substr(session('user')['name'], 0, 1)) }}
                        </div>
                        <span class="hidden sm:inline">{{ session('user')['name'] }}</span>
                        <svg id="chevron-icon" xmlns="http://www.w3.org/2000/svg" height="14px" viewBox="0 -960 960 960" width="14px" fill="currentColor" class="transition-transform duration-200">
                            <path d="M480-360 280-560h400L480-360Z"/>
                        </svg>
                    </button>

                    <div id="user-dropdown"
                        class="hidden absolute right-0 mt-2 w-56 bg-white border border-gray-200 rounded-xl shadow-lg overflow-hidden z-50">
                        <div class="px-4 py-3 border-b border-gray-100">
                            <p class="text-xs text-slate-400">Signed in as</p>
                            <p class="text-sm font-semibold text-slate-700 truncate">{{ session('user')['email'] }}</p>
                        </div>
                        <a href="/user-profile"
                            class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-600 hover:bg-emerald-50 hover:text-emerald-700 transition-colors duration-100">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            My Profile
                        </a>
                        <a href="/user-details"
                            class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-600 hover:bg-emerald-50 hover:text-emerald-700 transition-colors duration-100">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            Quiz History
                        </a>
                        <a href="/favorites"
                            class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-600 hover:bg-emerald-50 hover:text-emerald-700 transition-colors duration-100">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                            </svg>
                            Favorites
                        </a>
                        <div class="border-t border-gray-100"></div>
                        <a href="/user-logout"
                            class="flex items-center gap-3 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition-colors duration-100">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            Log Out
                        </a>
                    </div>
                </div>
            @else
                <a class="text-slate-600 hover:text-emerald-700 hover:bg-emerald-50 px-3 py-1.5 rounded-lg text-sm font-medium transition-all duration-150" href="/user-login">
                    Login
                </a>
                <a class="bg-gradient-to-r from-emerald-600 to-green-700 hover:from-emerald-700 hover:to-green-800 text-white px-4 py-1.5 rounded-lg text-sm font-medium transition-all duration-150 shadow-sm hover:shadow" href="/user-signup">
                    Sign Up
                </a>
            @endif
        </div>
    </div>
</nav>

<script>
    // User dropdown functionality
    const userBtn = document.getElementById('user-menu-btn');
    const userDropdown = document.getElementById('user-dropdown');
    const chevron = document.getElementById('chevron-icon');

    if (userBtn) {
        userBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            const isHidden = userDropdown.classList.contains('hidden');
            userDropdown.classList.toggle('hidden', !isHidden);
            if (chevron) {
                chevron.style.transform = isHidden ? 'rotate(180deg)' : 'rotate(0deg)';
            }
        });

        document.addEventListener('click', () => {
            userDropdown.classList.add('hidden');
            if (chevron) {
                chevron.style.transform = 'rotate(0deg)';
            }
        });
    }

    // Learning dropdown functionality
    const learningBtn = document.getElementById('learning-menu-btn');
    const learningDropdown = document.getElementById('learning-dropdown');

    if (learningBtn) {
        learningBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            const isHidden = learningDropdown.classList.contains('hidden');
            
            // Close user dropdown if open
            if (userDropdown && !userDropdown.classList.contains('hidden')) {
                userDropdown.classList.add('hidden');
                if (chevron) chevron.style.transform = 'rotate(0deg)';
            }
            
            learningDropdown.classList.toggle('hidden', !isHidden);
        });

        document.addEventListener('click', () => {
            learningDropdown.classList.add('hidden');
        });
    }

    // Close dropdowns when pressing Escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            if (userDropdown && !userDropdown.classList.contains('hidden')) {
                userDropdown.classList.add('hidden');
                if (chevron) chevron.style.transform = 'rotate(0deg)';
            }
            if (learningDropdown && !learningDropdown.classList.contains('hidden')) {
                learningDropdown.classList.add('hidden');
            }
        }
    });
</script>