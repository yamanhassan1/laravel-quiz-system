<footer class="bg-emerald-950 text-emerald-300/70 w-full mt-auto">

    {{-- Main grid --}}
    <div class="max-w-5xl mx-auto px-4 sm:px-6 pt-12 pb-8 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8 md:gap-10">

        {{-- Brand column --}}
        <div class="sm:col-span-2 md:col-span-1">
            <div class="flex items-center gap-2 mb-3">
                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-emerald-500 to-green-600 flex items-center justify-center shrink-0 shadow-sm">
                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                        <path d="M7 1L9.5 5.5H12.5L10 8.5L11 12.5L7 10.5L3 12.5L4 8.5L1.5 5.5H4.5L7 1Z" fill="white"/>
                    </svg>
                </div>
                <span class="text-emerald-100 font-bold text-base tracking-tight">Quiz System</span>
            </div>
            <p class="text-emerald-300/60 text-xs leading-relaxed mb-4">
                Your ultimate destination for fun and challenging quizzes across every topic imaginable. Learn, practice, and master new skills.
            </p>

            {{-- Newsletter --}}
            <div class="mt-4">
                <p class="text-emerald-400 text-[10px] font-semibold uppercase tracking-wider mb-2 flex items-center gap-1.5">
                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    Stay updated
                </p>
                <form action="/newsletter" method="post" class="flex gap-2">
                    @csrf
                    <input type="email" name="email" placeholder="your@email.com"
                        class="flex-1 min-w-0 bg-emerald-900/50 border border-emerald-800 rounded-lg px-3 py-2 text-xs text-emerald-100 placeholder:text-emerald-700 focus:outline-none focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 transition-all">
                    <button type="submit"
                        class="bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-semibold px-3 py-2 rounded-lg transition-all duration-150 shrink-0 hover:shadow-md">
                        Join
                    </button>
                </form>
            </div>

            {{-- Social links --}}
            <div class="flex gap-2 mt-4">
                @foreach([
                    ['label'=>'Twitter',  'path'=>'M24 4.557a9.83 9.83 0 0 1-2.828.775 4.932 4.932 0 0 0 2.165-2.724 9.864 9.864 0 0 1-3.127 1.195 4.916 4.916 0 0 0-8.384 4.482C7.691 8.094 4.066 6.13 1.64 3.161a4.822 4.822 0 0 0-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 0 1-2.228-.616v.061a4.923 4.923 0 0 0 3.946 4.827 4.996 4.996 0 0 1-2.212.085 4.937 4.937 0 0 0 4.604 3.417 9.868 9.868 0 0 1-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 0 0 7.557 2.209c9.054 0 13.999-7.496 13.999-13.986 0-.209 0-.42-.015-.63a9.936 9.936 0 0 0 2.46-2.548l-.047-.02z'],
                    ['label'=>'Facebook', 'path'=>'M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z'],
                    ['label'=>'LinkedIn', 'path'=>'M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z'],
                    ['label'=>'GitHub',   'path'=>'M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.108-.775.418-1.305.762-1.604-2.665-.3-5.466-1.332-5.466-5.93 0-1.31.465-2.38 1.235-3.22-.135-.303-.54-1.523.105-3.176 0 0 1.005-.322 3.3 1.23.96-.267 1.98-.399 3-.405 1.02.006 2.04.138 3 .405 2.28-1.552 3.285-1.23 3.285-1.23.645 1.653.24 2.873.12 3.176.765.84 1.23 1.91 1.23 3.22 0 4.61-2.805 5.625-5.475 5.92.42.36.81 1.096.81 2.22v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z'],
                ] as $s)
                <a href="#" aria-label="{{ $s['label'] }}"
                    class="w-8 h-8 rounded-lg bg-emerald-900/80 hover:bg-emerald-800 border border-emerald-800 hover:border-emerald-600 flex items-center justify-center transition-all duration-150 hover:scale-105">
                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="#6ee7b7">
                        <path d="{{ $s['path'] }}"/>
                    </svg>
                </a>
                @endforeach
            </div>
        </div>

        {{-- Explore column --}}
        <div>
            <p class="text-emerald-400 text-[10px] font-semibold uppercase tracking-wider mb-4 flex items-center gap-1.5">
                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Explore
            </p>
            <ul class="space-y-2.5">
                @foreach([
                    ['label'=>'Home',            'href'=>'/'],
                    ['label'=>'Categories',      'href'=>'/categories-list'],
                    ['label'=>'Cheat Sheets',    'href'=>'/cheat-sheets'],
                    ['label'=>'Popular Quizzes', 'href'=>'/'],
                    ['label'=>'New Quizzes',     'href'=>'/'],
                ] as $link)
                <li>
                    <a href="{{ $link['href'] }}"
                        class="text-emerald-300/60 hover:text-emerald-200 text-xs transition-colors duration-150 flex items-center gap-1.5 group">
                        <svg class="w-2.5 h-2.5 opacity-0 group-hover:opacity-100 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                        {{ $link['label'] }}
                    </a>
                </li>
                @endforeach
            </ul>
        </div>

        {{-- Learning Platform column --}}
        <div>
            <p class="text-emerald-400 text-[10px] font-semibold uppercase tracking-wider mb-4 flex items-center gap-1.5">
                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                Learning
            </p>
            <ul class="space-y-2.5">
                @foreach([
                    ['label'=>'Tutorials',       'href'=>'/tutorials'],
                    ['label'=>'Blog',            'href'=>'/blog'],
                    ['label'=>'Practice',        'href'=>'/practice'],
                    ['label'=>'Leaderboard',     'href'=>'/leaderboard'],
                    ['label'=>'Certifications',  'href'=>'/certifications'],
                ] as $link)
                <li>
                    <a href="{{ $link['href'] }}"
                        class="text-emerald-300/60 hover:text-emerald-200 text-xs transition-colors duration-150 flex items-center gap-1.5 group">
                        <svg class="w-2.5 h-2.5 opacity-0 group-hover:opacity-100 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                        {{ $link['label'] }}
                    </a>
                </li>
                @endforeach
            </ul>
        </div>

        {{-- Company & Legal column --}}
        <div>
            <p class="text-emerald-400 text-[10px] font-semibold uppercase tracking-wider mb-4 flex items-center gap-1.5">
                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
                Company
            </p>
            <ul class="space-y-2.5">
                @foreach([
                    ['label'=>'About Us',   'href'=>'/about'],
                    ['label'=>'Contact',    'href'=>'/contact'],
                    ['label'=>'Careers',    'href'=>'/careers'],
                    ['label'=>'Support',    'href'=>'/support'],
                ] as $link)
                <li>
                    <a href="{{ $link['href'] }}"
                        class="text-emerald-300/60 hover:text-emerald-200 text-xs transition-colors duration-150 flex items-center gap-1.5 group">
                        <svg class="w-2.5 h-2.5 opacity-0 group-hover:opacity-100 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                        {{ $link['label'] }}
                    </a>
                </li>
                @endforeach
            </ul>

            {{-- Legal sub-section --}}
            <p class="text-emerald-400 text-[10px] font-semibold uppercase tracking-wider mt-5 mb-3 flex items-center gap-1.5">
                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
                Legal
            </p>
            <ul class="space-y-2.5">
                @foreach([
                    ['label'=>'Privacy Policy', 'href'=>'/privacy'],
                    ['label'=>'Terms of Use',   'href'=>'/terms'],
                    ['label'=>'Cookie Policy',  'href'=>'/cookies'],
                ] as $link)
                <li>
                    <a href="{{ $link['href'] }}"
                        class="text-emerald-300/60 hover:text-emerald-200 text-xs transition-colors duration-150 flex items-center gap-1.5 group">
                        <svg class="w-2.5 h-2.5 opacity-0 group-hover:opacity-100 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                        {{ $link['label'] }}
                    </a>
                </li>
                @endforeach
            </ul>
        </div>
    </div>

    {{-- Contact info row (below grid) --}}
    <div class="max-w-5xl mx-auto px-4 sm:px-6 mt-4">
        <div class="flex flex-wrap items-center justify-center gap-4 md:gap-6 py-4 border-t border-emerald-900/50">
            <div class="flex items-center gap-2 text-emerald-300/60 text-xs">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                support@quizsystem.com
            </div>
            <div class="flex items-center gap-2 text-emerald-300/60 text-xs">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                </svg>
                +1 (555) 000-1234
            </div>
            <div class="flex items-center gap-2 text-emerald-300/60 text-xs">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                San Francisco, CA
            </div>
        </div>
    </div>

    {{-- Divider --}}
    <div class="max-w-5xl mx-auto px-4 sm:px-6">
        <div class="border-t border-emerald-900/50"></div>
    </div>

    {{-- Bottom bar --}}
    <div class="max-w-5xl mx-auto px-4 sm:px-6 py-4 flex flex-col sm:flex-row items-center justify-between gap-3">
        <p class="text-emerald-700 text-[11px]">&copy; {{ date('Y') }} Quiz System. All rights reserved.</p>
        <div class="flex flex-wrap items-center justify-center gap-2">
            @foreach(['Free to use', 'No ads', 'Open quizzes', 'Community driven'] as $badge)
                <span class="text-[9px] font-semibold text-emerald-500 bg-emerald-900/60 border border-emerald-800 px-2.5 py-1 rounded-full">
                    {{ $badge }}
                </span>
            @endforeach
        </div>
    </div>

</footer>