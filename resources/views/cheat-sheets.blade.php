<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Programming cheat sheets for developers - quick reference guides for languages, frameworks, and tools">
    <title>Cheat Sheets — Quiz System</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">
    <x-user-navbar></x-user-navbar>

    {{-- Hero Section --}}
    <section class="bg-white border-b border-gray-100">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 pt-12 sm:pt-14 pb-8 sm:pb-10 text-center">
            <div class="inline-flex items-center gap-2 bg-emerald-50 px-3 py-1 rounded-full mb-4">
                <svg class="w-3 h-3 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="text-[10px] font-semibold text-emerald-700 uppercase tracking-wide">Quick Reference</span>
            </div>
            <h1 class="text-emerald-950 text-3xl sm:text-4xl font-extrabold tracking-tight mb-3">
                Programming<br>
                <span class="text-emerald-600">Cheat Sheets</span>
            </h1>
            <p class="text-slate-500 text-sm max-w-md mx-auto leading-relaxed mb-8">
                Comprehensive quick-reference guides for developers — from syntax to patterns.
            </p>

            {{-- Search Form --}}
            <form action="{{ route('cheat-sheets.search') }}" method="GET" class="relative max-w-md mx-auto">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input
                    type="text"
                    name="q"
                    value="{{ $searchQuery ?? '' }}"
                    placeholder="Search languages, frameworks..."
                    class="w-full pl-9 pr-24 py-3 border border-gray-200 rounded-xl text-sm text-slate-800 bg-white focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 focus:outline-none transition-all"
                >
                <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-medium px-4 py-1.5 rounded-lg transition">
                    Search
                </button>
            </form>

            {{-- Stats --}}
            <div class="flex flex-wrap items-center justify-center gap-4 sm:gap-6 mt-8 pt-6 border-t border-gray-100">
                <div class="flex items-center gap-2 text-xs text-slate-500">
                    <strong class="text-emerald-700 text-base">{{ count($sheets) }}</strong> cheat sheets
                </div>
                <div class="w-1 h-1 rounded-full bg-gray-300"></div>
                <div class="flex items-center gap-2 text-xs text-slate-500">
                    <strong class="text-emerald-700 text-base">{{ collect($sheets)->sum('topics') }}</strong> topics covered
                </div>
                <div class="w-1 h-1 rounded-full bg-gray-300"></div>
                <div class="flex items-center gap-2 text-xs text-slate-500">
                    <strong class="text-emerald-700 text-base">{{ collect($sheets)->pluck('tags')->flatten()->unique()->count() }}</strong> categories
                </div>
            </div>
        </div>
    </section>

    {{-- Filter Bar --}}
    @php
        $allTags = collect($sheets)->pluck('tags')->flatten()->unique()->sort()->values();
    @endphp
    <div class="bg-white border-b border-gray-100 sticky top-14 z-10">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 overflow-x-auto">
            <div class="flex items-center gap-1 py-3">
                <button class="filter-btn active px-3 py-1.5 rounded-lg text-xs font-medium bg-emerald-50 text-emerald-700 whitespace-nowrap transition" data-tag="all">All</button>
                @foreach($allTags as $tag)
                    <button class="filter-btn px-3 py-1.5 rounded-lg text-xs font-medium text-slate-500 hover:bg-gray-50 hover:text-slate-700 whitespace-nowrap transition" data-tag="{{ strtolower($tag) }}">{{ $tag }}</button>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Main Content --}}
    <main class="flex-1 max-w-5xl mx-auto w-full px-4 sm:px-6 py-8 sm:py-10">
        
        {{-- Search Result Header --}}
        @if(isset($searchQuery) && $searchQuery && count($sheets) > 0)
            <div class="flex items-center justify-between mb-5">
                <p class="text-sm text-slate-500">
                    <strong class="text-slate-700">{{ count($sheets) }}</strong> 
                    result{{ count($sheets) != 1 ? 's' : '' }} for 
                    "<strong class="text-emerald-600">{{ $searchQuery }}</strong>"
                </p>
                <a href="{{ route('cheat-sheets.index') }}" class="text-xs text-emerald-600 hover:text-emerald-700 font-medium">Clear</a>
            </div>
        @endif

        {{-- Empty State --}}
        @if(count($sheets) === 0)
            <div class="bg-white border border-gray-200 rounded-2xl px-6 py-16 text-center">
                <div class="w-16 h-16 rounded-2xl bg-gray-50 border border-gray-200 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <p class="text-slate-700 text-sm font-semibold mb-1">No results found</p>
                <p class="text-slate-400 text-sm max-w-xs mx-auto">Try searching for "Python", "JavaScript", or "Git"</p>
                <a href="{{ route('cheat-sheets.index') }}" class="inline-flex items-center gap-1.5 mt-5 text-xs font-semibold text-emerald-600 bg-emerald-50 px-4 py-2 rounded-xl hover:bg-emerald-100 transition">
                    View all cheat sheets
                </a>
            </div>
        @else
            {{-- Grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4" id="sheets-grid">
                @foreach($sheets as $idx => $sheet)
                    <a href="{{ route('cheat-sheets.show', $sheet['slug']) }}" 
                       class="sheet-card bg-white border border-gray-200 rounded-xl p-4 hover:shadow-md transition-all group"
                       data-tags="{{ strtolower(implode(',', $sheet['tags'])) }}">
                        
                        {{-- Header with Logo --}}
                        <div class="flex items-start gap-3">
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center shrink-0" style="background: {{ $sheet['bg'] }}">
                                @if(!empty($sheet['image']))
                                    <img src="{{ $sheet['image'] }}" alt="{{ $sheet['title'] }}" class="w-7 h-7 object-contain">
                                @else
                                    <div class="w-7 h-7 flex items-center justify-center">
                                        {!! $sheet['svg'] !!}
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="font-bold text-slate-800 text-sm group-hover:text-emerald-600 transition">{{ $sheet['title'] }}</h3>
                                <p class="text-xs text-slate-400 mt-0.5 line-clamp-2">{{ $sheet['description'] }}</p>
                            </div>
                        </div>

                        {{-- Tags --}}
                        <div class="flex flex-wrap gap-1.5 mt-3">
                            @foreach($sheet['tags'] as $tag)
                                <span class="text-[9px] font-semibold px-1.5 py-0.5 rounded" 
                                      style="background: {{ $sheet['bg'] }}; color: {{ $sheet['color'] }}">
                                    {{ $tag }}
                                </span>
                            @endforeach
                        </div>

                        {{-- Footer --}}
                        <div class="flex items-center justify-between mt-3 pt-3 border-t border-gray-100">
                            <span class="text-[10px] text-slate-400 flex items-center gap-1">
                                <svg class="w-2.5 h-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                                </svg>
                                {{ $sheet['topics'] }} topics
                            </span>
                            <span class="text-emerald-600 opacity-0 group-hover:opacity-100 transition">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </span>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </main>

    <x-footer-user></x-footer-user>

    <script>
        // Filter functionality
        const filterBtns = document.querySelectorAll('.filter-btn');
        const cards = document.querySelectorAll('.sheet-card');
        
        function filterSheets(tag) {
            cards.forEach(card => {
                const cardTags = card.dataset.tags || '';
                const show = tag === 'all' || cardTags.includes(tag);
                card.style.display = show ? 'flex' : 'none';
            });
        }
        
        filterBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                const tag = btn.dataset.tag;
                
                // Update active state
                filterBtns.forEach(b => {
                    b.classList.remove('active', 'bg-emerald-50', 'text-emerald-700');
                    b.classList.add('text-slate-500');
                });
                btn.classList.add('active', 'bg-emerald-50', 'text-emerald-700');
                btn.classList.remove('text-slate-500');
                
                // Filter cards
                filterSheets(tag);
            });
        });
        
        // Keyboard shortcut for search
        document.addEventListener('keydown', (e) => {
            if ((e.key === '/' || (e.key === 'k' && (e.metaKey || e.ctrlKey))) && 
                document.activeElement.tagName !== 'INPUT') {
                e.preventDefault();
                document.querySelector('input[name="q"]')?.focus();
            }
        });
    </script>
</body>
</html>