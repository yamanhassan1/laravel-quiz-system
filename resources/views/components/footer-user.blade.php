<footer class="bg-emerald-950 text-emerald-300/70 w-full mt-auto">

    {{-- ── Main grid ── --}}
    <div class="max-w-5xl mx-auto px-6 pt-12 pb-8 grid grid-cols-1 md:grid-cols-4 gap-10">

        {{-- Brand column --}}
        <div class="md:col-span-1">
            <div class="flex items-center gap-2 mb-3">
                <div class="w-7 h-7 rounded-lg bg-emerald-600 flex items-center justify-center shrink-0">
                    <svg width="13" height="13" viewBox="0 0 14 14" fill="none">
                        <path d="M7 1L9.5 5.5H12.5L10 8.5L11 12.5L7 10.5L3 12.5L4 8.5L1.5 5.5H4.5L7 1Z" fill="white"/>
                    </svg>
                </div>
                <span class="text-emerald-100 font-semibold text-[15px] tracking-tight">Quiz System</span>
            </div>
            <p class="text-emerald-300/60 text-[12.5px] leading-relaxed mb-4">
                Your ultimate destination for fun and challenging quizzes across every topic imaginable.
            </p>

            {{-- Newsletter --}}
            <p class="text-emerald-400 text-[10.5px] font-semibold uppercase tracking-widest mb-2">Stay updated</p>
            <form action="/newsletter" method="post" class="flex gap-2">
                @csrf
                <input type="email" name="email" placeholder="your@email.com"
                    class="flex-1 min-w-0 bg-emerald-900/50 border border-emerald-800 rounded-lg px-3 py-2 text-[12px] text-emerald-100 placeholder:text-emerald-700 focus:outline-none focus:border-emerald-600 transition-colors duration-150">
                <button type="submit"
                    class="bg-emerald-600 hover:bg-emerald-500 text-white text-[12px] font-semibold px-3 py-2 rounded-lg transition-colors duration-150 shrink-0">
                    Join
                </button>
            </form>

            {{-- Social links --}}
            <div class="flex gap-2 mt-4">
                @foreach([
                    ['label'=>'Twitter',  'path'=>'M24 4.557a9.83 9.83 0 0 1-2.828.775 4.932 4.932 0 0 0 2.165-2.724 9.864 9.864 0 0 1-3.127 1.195 4.916 4.916 0 0 0-8.384 4.482C7.691 8.094 4.066 6.13 1.64 3.161a4.822 4.822 0 0 0-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 0 1-2.228-.616v.061a4.923 4.923 0 0 0 3.946 4.827 4.996 4.996 0 0 1-2.212.085 4.937 4.937 0 0 0 4.604 3.417 9.868 9.868 0 0 1-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 0 0 7.557 2.209c9.054 0 13.999-7.496 13.999-13.986 0-.209 0-.42-.015-.63a9.936 9.936 0 0 0 2.46-2.548l-.047-.02z'],
                    ['label'=>'Facebook', 'path'=>'M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z'],
                    ['label'=>'LinkedIn', 'path'=>'M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z'],
                ] as $s)
                <a href="/" aria-label="{{ $s['label'] }}"
                    class="w-8 h-8 rounded-lg bg-emerald-900 hover:bg-emerald-800 border border-emerald-800 hover:border-emerald-700 flex items-center justify-center transition-all duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="#6ee7b7">
                        <path d="{{ $s['path'] }}"/>
                    </svg>
                </a>
                @endforeach
            </div>
        </div>

        {{-- Explore column --}}
        <div>
            <p class="text-emerald-400 text-[10.5px] font-semibold uppercase tracking-widest mb-4">Explore</p>
            <ul class="space-y-2.5">
                @foreach([
                    ['label'=>'Home',            'href'=>'/'],
                    ['label'=>'Categories',      'href'=>'/'],
                    ['label'=>'Leaderboard',     'href'=>'/'],
                    ['label'=>'New Quizzes',     'href'=>'/'],
                    ['label'=>'Popular Quizzes', 'href'=>'/'],
                ] as $link)
                <li>
                    <a href="{{ $link['href'] }}"
                        class="text-emerald-300/60 hover:text-emerald-200 text-[12.5px] transition-colors duration-150">
                        {{ $link['label'] }}
                    </a>
                </li>
                @endforeach
            </ul>
        </div>

        {{-- Company column --}}
        <div>
            <p class="text-emerald-400 text-[10.5px] font-semibold uppercase tracking-widest mb-4">Company</p>
            <ul class="space-y-2.5">
                @foreach([
                    ['label'=>'About Us', 'href'=>'/'],
                    ['label'=>'Blog',     'href'=>'/'],
                    ['label'=>'Contact',  'href'=>'/'],
                    ['label'=>'Careers',  'href'=>'/'],
                ] as $link)
                <li>
                    <a href="{{ $link['href'] }}"
                        class="text-emerald-300/60 hover:text-emerald-200 text-[12.5px] transition-colors duration-150">
                        {{ $link['label'] }}
                    </a>
                </li>
                @endforeach
            </ul>
        </div>

        {{-- Legal column --}}
        <div>
            <p class="text-emerald-400 text-[10.5px] font-semibold uppercase tracking-widest mb-4">Legal</p>
            <ul class="space-y-2.5">
                @foreach([
                    ['label'=>'Privacy Policy', 'href'=>'/'],
                    ['label'=>'Terms of Use',   'href'=>'/'],
                    ['label'=>'Cookie Policy',  'href'=>'/'],
                    ['label'=>'Accessibility',  'href'=>'/'],
                ] as $link)
                <li>
                    <a href="{{ $link['href'] }}"
                        class="text-emerald-300/60 hover:text-emerald-200 text-[12.5px] transition-colors duration-150">
                        {{ $link['label'] }}
                    </a>
                </li>
                @endforeach
            </ul>

            {{-- Contact info --}}
            <p class="text-emerald-400 text-[10.5px] font-semibold uppercase tracking-widest mt-6 mb-3">Contact</p>
            <ul class="space-y-2">
                <li class="flex items-center gap-2 text-emerald-300/60 text-[12px]">
                    <svg xmlns="http://www.w3.org/2000/svg" height="13px" viewBox="0 -960 960 960" width="13px" fill="#6ee7b7" class="shrink-0">
                        <path d="M160-160q-33 0-56.5-23.5T80-240v-480q0-33 23.5-56.5T160-800h640q33 0 56.5 23.5T880-720v480q0 33-23.5 56.5T800-160H160Zm320-280L160-640v400h640v-400L480-440Zm0-80 320-200H160l320 200ZM160-640v-80 480-400Z"/>
                    </svg>
                    support@quizsystem.com
                </li>
                <li class="flex items-center gap-2 text-emerald-300/60 text-[12px]">
                    <svg xmlns="http://www.w3.org/2000/svg" height="13px" viewBox="0 -960 960 960" width="13px" fill="#6ee7b7" class="shrink-0">
                        <path d="M798-120q-125 0-247-54.5T329-329Q229-429 174.5-551T120-798q0-18 12-30t30-12h162q14 0 25 9.5t13 22.5l26 140q2 16-1 27t-11 19l-97 98q20 37 47.5 71.5T387-386q31 31 65 57.5t72 48.5l94-94q9-9 23.5-13.5T670-390l138 28q14 4 23 14.5t9 23.5v162q0 18-12 30t-30 12Z"/>
                    </svg>
                    +1 (555) 000-1234
                </li>
            </ul>
        </div>

    </div>

    {{-- ── Divider ── --}}
    <div class="max-w-5xl mx-auto px-6">
        <div class="border-t border-emerald-900"></div>
    </div>

    {{-- ── Bottom bar ── --}}
    <div class="max-w-5xl mx-auto px-6 py-4 flex flex-col sm:flex-row items-center justify-between gap-3">
        <p class="text-emerald-700 text-[11.5px]">&copy; 2026 Quiz System. All rights reserved.</p>
        <div class="flex items-center gap-2">
            @foreach(['Free to use', 'No ads', 'Open quizzes'] as $badge)
            <span class="text-[10px] font-semibold text-emerald-500 bg-emerald-900/60 border border-emerald-800 px-2.5 py-1 rounded-full">
                {{ $badge }}
            </span>
            @endforeach
        </div>
    </div>

</footer>