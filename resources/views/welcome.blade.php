<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Test your knowledge with hundreds of quizzes across every topic. Challenge yourself daily with our interactive quiz system.">
    <title>Quiz System — Test Your Knowledge</title>
    @vite('resources/css/app.css')
    <style>
        @keyframes countUp {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .count-animation {
            animation: countUp 0.5s ease-out;
        }
        
        .stat-value {
            transition: all 0.3s ease;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .animate-fade-in {
            animation: fadeIn 0.3s ease-out;
        }
    </style>
</head>
<body class="bg-[#f8faf8] min-h-screen flex flex-col">
    <x-user-navbar />

    {{-- Success Alert with auto-dismiss --}}
    @if(session('message-success'))
        <div id="success-alert" 
             class="fixed top-20 left-1/2 -translate-x-1/2 z-50 w-full max-w-md px-4 animate-in slide-in-from-top-2 duration-300"
             role="alert">
            <div class="bg-emerald-50 border-l-4 border-emerald-600 rounded-r-lg shadow-lg px-4 py-3">
                <div class="flex items-center gap-3">
                    <div class="shrink-0">
                        <svg class="h-5 w-5 text-emerald-600" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <p class="text-emerald-800 text-sm font-medium">{{ session('message-success') }}</p>
                    <button onclick="this.closest('#success-alert').remove()" 
                            class="ml-auto text-emerald-600 hover:text-emerald-800">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        
        <script>
            setTimeout(() => {
                const alert = document.getElementById('success-alert');
                if (alert) alert.style.display = 'none';
            }, 5000);
        </script>
    @endif

    {{-- Hero Section --}}
    <section class="bg-white border-b border-gray-100">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 pt-12 sm:pt-14 pb-8 sm:pb-10 text-center">
            <h1 class="text-emerald-950 text-3xl sm:text-[2.4rem] font-extrabold tracking-tight leading-tight sm:leading-[1.15] mb-3">
                Test your knowledge.<br>
                <span class="text-emerald-600">Challenge yourself daily.</span>
            </h1>
            <p class="text-slate-500 text-sm sm:text-[15px] max-w-md mx-auto leading-relaxed mb-8">
                Hundreds of quizzes across every topic. Pick a category, attempt a quiz, and see how you score.
            </p>

            {{-- Search Form --}}
            <form action="{{ route('quiz.search') }}" method="GET" class="relative max-w-md mx-auto">
                <input
                    type="text"
                    name="search"
                    id="searchInput"
                    value="{{ request('search') }}"
                    placeholder="Search quizzes or categories…"
                    aria-label="Search quizzes"
                    class="w-full px-5 py-3.5 pr-14 border border-gray-200 rounded-2xl text-sm text-slate-800 bg-white shadow-sm focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 focus:outline-none transition-all placeholder:text-slate-300">
                <button type="submit"
                    aria-label="Search"
                    class="absolute right-2 top-1/2 -translate-y-1/2 w-9 h-9 rounded-xl bg-emerald-600 hover:bg-emerald-700 focus:ring-2 focus:ring-emerald-300 flex items-center justify-center transition-colors">
                    <svg class="w-4 h-4 text-white" viewBox="0 -960 960 960" fill="currentColor">
                        <path d="M765-144 526-383q-30 22-65.79 34.5-35.79 12.5-76.18 12.5Q284-336 214-406t-70-170q0-100 70-170t170-70q100 0 170 70t70 170.03q0 40.39-12.5 76.18Q599-464 577-434l239 239-51 51ZM384-408q70 0 119-49t49-119q0-70-49-119t-119-49q-70 0-119 49t-49 119q0 70 49 119t119 49Z"/>
                    </svg>
                </button>
            </form>

            {{-- Stats Row with Dynamic Counters --}}
            <div class="flex flex-wrap items-center justify-center gap-6 sm:gap-8 mt-8 pt-8 border-t border-gray-100">
                @php
                    // Use total counts from controller, not limited values
                    $totalCategoriesCount = $totalCategories ?? count($categories);
                    $totalQuizzesCount = $totalQuizzes ?? \App\Models\Quiz::count();
                    $totalQuestionsCount = $totalMcqs ?? \App\Models\MCQ::count();
                    
                    $stats = [
                        'categories' => ['label' => 'Categories', 'value' => $totalCategoriesCount, 'icon' => 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10'],
                        'quizzes' => ['label' => 'Quizzes', 'value' => $totalQuizzesCount, 'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
                        'questions' => ['label' => 'Questions', 'value' => $totalQuestionsCount, 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'],
                    ];
                    
                    // Auto-detect if values should be formatted with + for large numbers
                    foreach($stats as $key => $stat) {
                        if(is_numeric($stat['value']) && $stat['value'] > 1000) {
                            $stats[$key]['display'] = round($stat['value'] / 1000, 1) . 'K+';
                        } else {
                            $stats[$key]['display'] = $stat['value'];
                        }
                    }
                @endphp
                @foreach($stats as $stat)
                    <div class="text-center group cursor-pointer">
                        <div class="flex items-center justify-center mb-2">
                            <div class="w-10 h-10 rounded-full bg-emerald-50 group-hover:bg-emerald-100 flex items-center justify-center transition-colors">
                                <svg class="w-5 h-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $stat['icon'] }}"/>
                                </svg>
                            </div>
                        </div>
                        <p class="text-emerald-950 text-2xl sm:text-3xl font-extrabold tracking-tight stat-value" data-target="{{ $stat['value'] }}">
                            {{ $stat['display'] }}
                        </p>
                        <p class="text-slate-400 text-xs sm:text-[11.5px] mt-0.5">{{ $stat['label'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Main Content --}}
    <main class="flex-1 max-w-5xl mx-auto w-full px-4 sm:px-6 py-8 sm:py-10">
        
        {{-- Categories Section --}}
        <section aria-labelledby="categories-heading">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-5">
                <div>
                    <h2 id="categories-heading" class="text-emerald-950 text-base font-bold tracking-tight">Top categories</h2>
                    <p class="text-slate-400 text-xs mt-0.5">Pick a topic to explore its quizzes</p>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-slate-400 text-xs bg-slate-100 px-3 py-1.5 rounded-full font-medium" id="category-count">
                        {{ count($categories) }} available
                    </span>
                </div>
            </div>

            @if(count($categories) > 0)
                <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-sm">
                    {{-- Table Header (hidden on mobile) --}}
                    <div class="hidden md:grid grid-cols-[40px_1fr_120px_110px] gap-2 bg-slate-50 border-b border-gray-100 px-5 py-3">
                        <span class="text-slate-400 text-[10.5px] font-bold uppercase tracking-wider">#</span>
                        <span class="text-slate-400 text-[10.5px] font-bold uppercase tracking-wider">Category</span>
                        <span class="text-slate-400 text-[10.5px] font-bold uppercase tracking-wider">Quizzes</span>
                        <span class="text-slate-400 text-[10.5px] font-bold uppercase tracking-wider text-right">Explore</span>
                    </div>

                    {{-- Category Rows --}}
                    <div id="categories-list">
                        @foreach($categories as $index => $category)
                            <div class="category-row grid grid-cols-1 md:grid-cols-[40px_1fr_120px_110px] gap-3 md:gap-2 px-4 md:px-5 py-4 md:py-3.5 items-center border-b border-gray-50 hover:bg-emerald-50/30 transition-colors group"
                                 data-category-id="{{ $category->id }}">
                                
                                {{-- Index (visible on desktop only) --}}
                                <span class="hidden md:inline text-[11px] font-semibold text-slate-300">
                                    {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                                </span>

                                {{-- Category Info --}}
                                <div class="flex items-center gap-3 min-w-0">
                                    <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-700 border border-emerald-100 flex items-center justify-center text-sm font-extrabold shrink-0 group-hover:bg-emerald-100 transition-colors">
                                        {{ strtoupper(substr($category->name, 0, 1)) }}
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <p class="text-slate-800 text-sm font-semibold truncate">{{ $category->name }}</p>
                                        <p class="text-slate-400 text-xs md:hidden mt-1">
                                            {{ $category->quizzes_count }} quizzes
                                        </p>
                                    </div>
                                </div>

                                {{-- Quiz Count (visible on desktop) --}}
                                <div class="hidden md:block">
                                    <span class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-700 border border-emerald-100 text-[11px] font-bold px-2.5 py-1 rounded-lg">
                                        <svg class="w-3 h-3" viewBox="0 -960 960 960" fill="currentColor">
                                            <path d="M160-400q-17 0-28.5-11.5T120-440v-80q0-17 11.5-28.5T160-560h640q17 0 28.5 11.5T840-520v80q0 17-11.5 28.5T800-400H160Zm0-240q-17 0-28.5-11.5T120-680v-80q0-17 11.5-28.5T160-800h640q17 0 28.5 11.5T840-760v80q0 17-11.5 28.5T800-640H160Zm0 480q-17 0-28.5-11.5T120-200v-80q0-17 11.5-28.5T160-320h640q17 0 28.5 11.5T840-280v80q0 17-11.5 28.5T800-160H160Z"/>
                                        </svg>
                                        <span class="quiz-count">{{ $category->quizzes_count }}</span> quizzes
                                    </span>
                                </div>

                                {{-- Explore Button --}}
                                <div class="flex justify-start md:justify-end mt-2 md:mt-0">
                                    <a href="user-quiz-list/{{ $category->id }}/{{ Str::slug($category->name) }}"
                                       class="inline-flex items-center gap-1.5 text-emerald-600 hover:text-white text-xs font-bold border border-emerald-200 hover:border-emerald-600 bg-emerald-50 hover:bg-emerald-600 px-3 py-1.5 rounded-lg transition-all">
                                        View
                                        <svg class="w-3 h-3" viewBox="0 -960 960 960" fill="currentColor">
                                            <path d="M504-480 320-664l56-56 240 240-240 240-56-56 184-184Z"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                {{-- Empty State --}}
                <div class="bg-white border border-gray-200 rounded-2xl px-6 py-16 text-center">
                    <div class="w-14 h-14 rounded-2xl bg-emerald-50 border border-emerald-100 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6 text-emerald-600" viewBox="0 -960 960 960" fill="currentColor">
                            <path d="M480-280q17 0 28.5-11.5T520-320q0-17-11.5-28.5T480-360q-17 0-28.5 11.5T440-320q0 17 11.5 28.5T480-280Zm-40-160h80v-240h-80v240Zm40 360q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Z"/>
                        </svg>
                    </div>
                    <p class="text-slate-700 text-sm font-semibold mb-1">No categories yet</p>
                    <p class="text-slate-400 text-xs max-w-xs mx-auto">
                        Our team is adding quizzes. Check back soon — new categories are added regularly!
                    </p>
                </div>
            @endif
        </section>

        {{-- Top Quizzes Section --}}
        <section class="mt-12 sm:mt-16" aria-labelledby="quizzes-heading">
            <div class="flex items-center justify-between mb-5 gap-3 flex-wrap">
                <div>
                    <h2 id="quizzes-heading" class="text-emerald-950 text-base font-bold tracking-tight">Top quizzes</h2>
                    <p class="text-slate-400 text-xs mt-0.5">Challenge yourself with popular quizzes</p>
                </div>
                
                <div class="flex gap-2">
                    <button id="sort-popular" class="sort-btn text-emerald-600 text-xs font-medium px-2 py-1 rounded-lg hover:bg-emerald-50 transition-colors">
                        Most Attempted
                    </button>
                    <button id="sort-recent" class="sort-btn text-slate-500 text-xs font-medium px-2 py-1 rounded-lg hover:bg-emerald-50 transition-colors">
                        Newest
                    </button>
                    
                    @if(isset($quizData) && count($quizData) > 5)
                        <button id="show-more-btn" 
                                class="text-emerald-600 hover:text-emerald-700 text-xs font-semibold flex items-center gap-1 transition-colors">
                            Show more
                            <svg class="w-3 h-3 transition-transform duration-200" viewBox="0 -960 960 960" fill="currentColor">
                                <path d="M480-344 240-584l56-56 184 184 184-184 56 56-240 240Z"/>
                            </svg>
                        </button>
                    @endif
                </div>
            </div>

            @if(isset($quizData) && count($quizData) > 0)
                <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-sm divide-y divide-gray-50" id="quiz-list-container">
                    @foreach($quizData as $index => $item)
                        @php
                            // Safely get questions count
                            $questionsCount = 0;
                            if(isset($item->mcqs) && $item->mcqs instanceof \Illuminate\Database\Eloquent\Collection) {
                                $questionsCount = $item->mcqs->count();
                            } elseif(isset($item->mcqs_count)) {
                                $questionsCount = $item->mcqs_count;
                            } elseif(isset($item->questions_count)) {
                                $questionsCount = $item->questions_count;
                            } elseif(method_exists($item, 'mcqs')) {
                                $questionsCount = $item->mcqs()->count();
                            }
                            
                            // Safely get attempts count
                            $attemptsCount = $item->attempts_count ?? 0;
                        @endphp
                        
                        <div class="quiz-item flex flex-col sm:flex-row sm:items-center gap-3 sm:gap-4 px-4 sm:px-5 py-4 hover:bg-emerald-50/30 transition-colors group"
                             data-id="{{ $item->id }}"
                             data-attempts="{{ $attemptsCount }}"
                             data-created="{{ $item->created_at ?? '' }}"
                             data-index="{{ $index }}"
                             @if($index >= 5) style="display: none;" @endif>
                            
                            {{-- Icon & Number --}}
                            <div class="flex items-center gap-3">
                                <span class="w-8 h-8 rounded-xl bg-emerald-50 text-emerald-600 border border-emerald-100 text-xs font-extrabold flex items-center justify-center shrink-0 group-hover:bg-emerald-100 transition-colors">
                                    {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                                </span>
                                
                                <div class="flex sm:hidden items-center gap-2">
                                    <span class="inline-flex items-center gap-1 text-[10.5px] text-slate-400">
                                        <svg class="w-2.5 h-2.5" viewBox="0 -960 960 960" fill="currentColor">
                                            <path d="M160-400q-17 0-28.5-11.5T120-440v-80q0-17 11.5-28.5T160-560h640q17 0 28.5 11.5T840-520v80q0 17-11.5 28.5T800-400H160Z"/>
                                        </svg>
                                        {{ $questionsCount }}
                                    </span>
                                </div>
                            </div>

                            {{-- Quiz Info --}}
                            <div class="flex-1 min-w-0">
                                <p class="text-slate-800 text-sm font-semibold truncate">{{ $item->name }}</p>
                                <div class="hidden sm:flex items-center gap-2 mt-1 flex-wrap">
                                    <span class="inline-flex items-center gap-1 text-[10.5px] text-slate-400">
                                        <svg class="w-2.5 h-2.5" viewBox="0 -960 960 960" fill="currentColor">
                                            <path d="M160-400q-17 0-28.5-11.5T120-440v-80q0-17 11.5-28.5T160-560h640q17 0 28.5 11.5T840-520v80q0 17-11.5 28.5T800-400H160Z"/>
                                        </svg>
                                        {{ $questionsCount }} {{ Str::plural('question', $questionsCount) }}
                                    </span>
                                    <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                                    <span class="text-[10.5px] text-slate-400">Quiz #{{ $item->id }}</span>
                                    
                                    @if($attemptsCount > 0)
                                        <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                                        <span class="inline-flex items-center gap-1 text-[10.5px] text-emerald-600">
                                            <svg class="w-2.5 h-2.5" viewBox="0 -960 960 960" fill="currentColor">
                                                <path d="M480-80q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z"/>
                                            </svg>
                                            {{ $attemptsCount }} {{ Str::plural('attempt', $attemptsCount) }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            {{-- Attempt Button --}}
                            <a href="/start-quiz/{{ $item->id }}/{{ Str::slug($item->name) }}"
                               class="inline-flex items-center justify-center gap-1.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold px-5 py-2 rounded-xl transition-all hover:shadow-md active:scale-95 shrink-0 w-full sm:w-auto">
                                Attempt
                                <svg class="w-3 h-3 group-hover:translate-x-0.5 transition-transform" viewBox="0 -960 960 960" fill="currentColor">
                                    <path d="M504-480 320-664l56-56 240 240-240 240-56-56 184-184Z"/>
                                </svg>
                            </a>
                        </div>
                    @endforeach
                </div>

                @if(isset($quizData) && count($quizData) > 5)
                    <script>
                        document.getElementById('show-more-btn')?.addEventListener('click', function() {
                            const hiddenItems = document.querySelectorAll('.quiz-item[style*="display: none"]');
                            hiddenItems.forEach(item => item.style.display = 'flex');
                            this.style.display = 'none';
                        });
                    </script>
                @endif
            @else
                <div class="bg-white border border-gray-200 rounded-2xl px-6 py-12 text-center">
                    <p class="text-slate-500 text-sm">No quizzes available at the moment.</p>
                </div>
            @endif
        </section>
    </main>

    <x-footer-user />

    <script>
        // Animated counter for stats
        function animateCounter(element, target) {
            let current = 0;
            const increment = target / 50;
            const timer = setInterval(() => {
                current += increment;
                if (current >= target) {
                    clearInterval(timer);
                    if(target > 1000) {
                        element.textContent = Math.round(target / 1000) + 'K+';
                    } else {
                        element.textContent = target;
                    }
                } else {
                    if(target > 1000) {
                        element.textContent = Math.round(current / 1000) + 'K+';
                    } else {
                        element.textContent = Math.round(current);
                    }
                }
            }, 20);
        }
        
        // Start counters when page loads
        document.addEventListener('DOMContentLoaded', () => {
            const statValues = document.querySelectorAll('.stat-value');
            statValues.forEach(stat => {
                const target = parseInt(stat.dataset.target);
                if(target && target > 0) {
                    animateCounter(stat, target);
                }
            });
        });
        
        // Sorting functionality for quizzes
        const sortPopularBtn = document.getElementById('sort-popular');
        const sortRecentBtn = document.getElementById('sort-recent');
        
        function updateActiveButton(activeId) {
            const btns = document.querySelectorAll('.sort-btn');
            btns.forEach(btn => {
                if(btn.id === activeId) {
                    btn.classList.add('text-emerald-600', 'bg-emerald-50');
                    btn.classList.remove('text-slate-500');
                } else {
                    btn.classList.remove('text-emerald-600', 'bg-emerald-50');
                    btn.classList.add('text-slate-500');
                }
            });
        }
        
        if(sortPopularBtn) {
            sortPopularBtn.addEventListener('click', () => {
                const container = document.getElementById('quiz-list-container');
                const items = Array.from(container.querySelectorAll('.quiz-item'));
                
                items.sort((a, b) => {
                    const attemptsA = parseInt(a.dataset.attempts) || 0;
                    const attemptsB = parseInt(b.dataset.attempts) || 0;
                    return attemptsB - attemptsA;
                });
                
                items.forEach((item, idx) => {
                    item.style.display = idx < 5 ? 'flex' : 'none';
                    const numberSpan = item.querySelector('.w-8.h-8');
                    if(numberSpan) {
                        numberSpan.textContent = String(idx + 1).padStart(2, '0');
                    }
                    container.appendChild(item);
                });
                
                updateActiveButton('sort-popular');
                
                const showMoreBtn = document.getElementById('show-more-btn');
                if(showMoreBtn && items.length > 5) {
                    showMoreBtn.style.display = '';
                }
            });
        }
        
        if(sortRecentBtn) {
            sortRecentBtn.addEventListener('click', () => {
                const container = document.getElementById('quiz-list-container');
                const items = Array.from(container.querySelectorAll('.quiz-item'));
                
                items.sort((a, b) => {
                    const dateA = new Date(a.dataset.created) || 0;
                    const dateB = new Date(b.dataset.created) || 0;
                    return dateB - dateA;
                });
                
                items.forEach((item, idx) => {
                    item.style.display = idx < 5 ? 'flex' : 'none';
                    const numberSpan = item.querySelector('.w-8.h-8');
                    if(numberSpan) {
                        numberSpan.textContent = String(idx + 1).padStart(2, '0');
                    }
                    container.appendChild(item);
                });
                
                updateActiveButton('sort-recent');
            });
        }
        
        // Smooth scroll behavior
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
                if (href === '#') return;
                
                const target = document.querySelector(href);
                if (target) {
                    e.preventDefault();
                    target.scrollIntoView({ behavior: 'smooth' });
                }
            });
        });
    </script>
</body>
</html>