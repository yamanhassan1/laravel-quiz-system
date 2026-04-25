<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Browse and attempt quizzes in {{ ucwords(str_replace('-', ' ', $category)) }} category">
    <title>{{ ucwords(str_replace('-', ' ', $category)) }} Quizzes — Quiz System</title>
    @vite('resources/css/app.css')
    <style>
        .quiz-item {
            transition: all 0.2s ease;
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .fade-in {
            animation: fadeIn 0.4s ease-out;
        }
        
        .pagination-btn {
            transition: all 0.2s ease;
        }
        
        .pagination-btn:hover:not(:disabled) {
            transform: translateY(-1px);
        }
        
        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-50 to-slate-50 min-h-screen flex flex-col">
    <x-user-navbar></x-user-navbar>

    <main class="flex-1 max-w-4xl mx-auto w-full px-4 sm:px-6 py-8 sm:py-10">

        {{-- Breadcrumb + title --}}
        <div class="flex flex-wrap items-center gap-2 mb-6">
            <a href="/"
                class="inline-flex items-center gap-1 text-xs text-slate-500 hover:text-emerald-600 bg-white border border-gray-200 hover:border-emerald-300 px-3 py-1.5 rounded-lg transition-all font-medium">
                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Home
            </a>
            <svg class="w-3 h-3 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-emerald-900 text-sm font-semibold">{{ ucwords(str_replace('-', ' ', $category)) }}</span>
        </div>

        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-emerald-900 text-2xl sm:text-3xl font-extrabold tracking-tight">
                {{ ucwords(str_replace('-', ' ', $category)) }}
            </h1>
            <p class="text-slate-500 text-sm mt-1">
                {{ $quizData->total() }} {{ Str::plural('quiz', $quizData->total()) }} available in this category
            </p>
        </div>

        @if($quizData->count() > 0)

            {{-- Controls row --}}
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 mb-5">
                <div class="flex items-center gap-2">
                    <div class="w-1 h-5 bg-emerald-500 rounded-full"></div>
                    <p class="text-slate-700 text-sm font-bold">Available Quizzes</p>
                </div>

                {{-- Search input --}}
                <div class="relative w-full sm:w-64">
                    <input type="text" 
                           id="searchQuiz" 
                           placeholder="Search quizzes..." 
                           class="w-full pl-9 pr-3 py-2 border border-gray-200 rounded-lg text-sm focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 transition">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
            </div>

            {{-- Quiz list --}}
            <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-sm" id="quiz-list">
                @foreach($quizData as $index => $item)
                <div class="quiz-item flex flex-col sm:flex-row sm:items-center gap-3 sm:gap-4 px-4 sm:px-5 py-4 border-b border-gray-50 hover:bg-emerald-50/30 transition-all group"
                     data-name="{{ strtolower($item->name) }}">
                    
                    {{-- Number and icon --}}
                    <div class="flex items-center gap-3">
                        <span class="w-8 h-8 rounded-xl bg-emerald-50 text-emerald-600 border border-emerald-100 text-xs font-extrabold flex items-center justify-center shrink-0 group-hover:bg-emerald-100 transition-colors">
                            {{ str_pad($quizData->firstItem() + $index, 2, '0', STR_PAD_LEFT) }}
                        </span>
                        <div class="sm:hidden">
                            <span class="inline-flex items-center gap-1 text-[10px] text-slate-400">
                                <svg class="w-2.5 h-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                {{ $item->mcqs->count() }} questions
                            </span>
                        </div>
                    </div>

                    {{-- Quiz info --}}
                    <div class="flex-1 min-w-0">
                        <p class="text-slate-800 text-sm font-semibold truncate">{{ $item->name }}</p>
                        <div class="hidden sm:flex items-center gap-2 mt-1">
                            <span class="inline-flex items-center gap-1 text-[10px] text-slate-400">
                                <svg class="w-2.5 h-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                {{ $item->mcqs->count() }} questions
                            </span>
                            <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                            <span class="text-[10px] text-slate-400">ID: #{{ $item->id }}</span>
                            
                            @if(isset($item->difficulty))
                                <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                                <span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-[9px] font-medium
                                    {{ $item->difficulty == 'easy' ? 'bg-green-100 text-green-700' : 
                                       ($item->difficulty == 'hard' ? 'bg-red-100 text-red-700' : 
                                       'bg-yellow-100 text-yellow-700') }}">
                                    {{ ucfirst($item->difficulty ?? 'Medium') }}
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- Attempt button --}}
                    <a href="/start-quiz/{{ $item->id }}/{{ Str::slug($item->name) }}"
                       class="inline-flex items-center justify-center gap-1.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold px-4 py-2 rounded-xl transition-all hover:shadow-md active:scale-95 shrink-0 w-full sm:w-auto">
                        Start Quiz
                        <svg class="w-3 h-3 group-hover:translate-x-0.5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </a>
                </div>
                @endforeach
            </div>

            {{-- No results message (for search) --}}
            <div id="no-results" class="hidden bg-white border border-gray-200 rounded-2xl px-6 py-12 text-center">
                <svg class="w-12 h-12 text-slate-300 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <p class="text-slate-500 text-sm">No quizzes match your search</p>
                <button onclick="clearSearch()" class="mt-3 text-emerald-600 text-xs font-medium hover:underline">Clear search</button>
            </div>

            {{-- Pagination --}}
            <div class="mt-6 flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="text-slate-400 text-xs">
                    Showing 
                    <span class="font-medium text-slate-600">{{ $quizData->firstItem() }}</span> 
                    to 
                    <span class="font-medium text-slate-600">{{ $quizData->lastItem() }}</span> 
                    of 
                    <span class="font-medium text-slate-600">{{ $quizData->total() }}</span> 
                    quizzes
                </div>
                
                <div class="flex items-center gap-2">
                    {{-- Previous Page Link --}}
                    @if($quizData->onFirstPage())
                        <span class="pagination-btn inline-flex items-center gap-1 px-3 py-2 rounded-lg text-xs font-medium text-slate-300 bg-slate-50 border border-gray-200 cursor-not-allowed">
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                            Previous
                        </span>
                    @else
                        <a href="{{ $quizData->previousPageUrl() }}" 
                           class="pagination-btn inline-flex items-center gap-1 px-3 py-2 rounded-lg text-xs font-medium text-emerald-600 bg-white border border-emerald-200 hover:bg-emerald-50 hover:border-emerald-300 transition-all">
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                            Previous
                        </a>
                    @endif
                    
                    {{-- Page Numbers --}}
                    <div class="flex items-center gap-1">
                        @php
                            $currentPage = $quizData->currentPage();
                            $lastPage = $quizData->lastPage();
                            $start = max(1, $currentPage - 2);
                            $end = min($lastPage, $currentPage + 2);
                            
                            if ($start > 1) {
                                echo '<a href="' . $quizData->url(1) . '" class="pagination-btn w-8 h-8 flex items-center justify-center rounded-lg text-xs font-medium text-slate-600 bg-white border border-gray-200 hover:bg-emerald-50 hover:border-emerald-200 transition-all">1</a>';
                                if ($start > 2) {
                                    echo '<span class="text-slate-300 text-xs">...</span>';
                                }
                            }
                        @endphp
                        
                        @for($i = $start; $i <= $end; $i++)
                            @if($i == $currentPage)
                                <span class="w-8 h-8 flex items-center justify-center rounded-lg text-xs font-bold text-white bg-emerald-600 border border-emerald-600">
                                    {{ $i }}
                                </span>
                            @else
                                <a href="{{ $quizData->url($i) }}" 
                                   class="pagination-btn w-8 h-8 flex items-center justify-center rounded-lg text-xs font-medium text-slate-600 bg-white border border-gray-200 hover:bg-emerald-50 hover:border-emerald-200 transition-all">
                                    {{ $i }}
                                </a>
                            @endif
                        @endfor
                        
                        @php
                            if ($end < $lastPage) {
                                if ($end < $lastPage - 1) {
                                    echo '<span class="text-slate-300 text-xs">...</span>';
                                }
                                echo '<a href="' . $quizData->url($lastPage) . '" class="pagination-btn w-8 h-8 flex items-center justify-center rounded-lg text-xs font-medium text-slate-600 bg-white border border-gray-200 hover:bg-emerald-50 hover:border-emerald-200 transition-all">' . $lastPage . '</a>';
                            }
                        @endphp
                    </div>
                    
                    {{-- Next Page Link --}}
                    @if($quizData->hasMorePages())
                        <a href="{{ $quizData->nextPageUrl() }}" 
                           class="pagination-btn inline-flex items-center gap-1 px-3 py-2 rounded-lg text-xs font-medium text-emerald-600 bg-white border border-emerald-200 hover:bg-emerald-50 hover:border-emerald-300 transition-all">
                            Next
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    @else
                        <span class="pagination-btn inline-flex items-center gap-1 px-3 py-2 rounded-lg text-xs font-medium text-slate-300 bg-slate-50 border border-gray-200 cursor-not-allowed">
                            Next
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </span>
                    @endif
                </div>
            </div>

        @else
            {{-- Empty state --}}
            <div class="bg-white border border-gray-200 rounded-2xl px-6 py-16 text-center shadow-sm">
                <div class="w-16 h-16 rounded-2xl bg-emerald-50 border border-emerald-100 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <p class="text-slate-700 text-sm font-semibold mb-1">No quizzes available</p>
                <p class="text-slate-400 text-xs max-w-xs mx-auto">
                    No quizzes have been added to <span class="font-medium text-slate-500">{{ ucwords(str_replace('-', ' ', $category)) }}</span> yet.
                    Check back soon!
                </p>
                <a href="/"
                    class="inline-flex items-center gap-1.5 mt-5 text-xs font-semibold text-emerald-600 hover:text-emerald-700 border border-emerald-200 hover:border-emerald-400 bg-emerald-50 hover:bg-emerald-100 px-4 py-2 rounded-xl transition-all">
                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Browse other categories
                </a>
            </div>
        @endif

    </main>

    <x-footer-user></x-footer-user>

    <script>
        // Search functionality for current page only (client-side)
        const searchInput = document.getElementById('searchQuiz');
        const quizItems = document.querySelectorAll('.quiz-item');
        const noResultsDiv = document.getElementById('no-results');
        const quizListDiv = document.getElementById('quiz-list');
        
        function filterQuizzes() {
            const searchTerm = searchInput.value.toLowerCase();
            let visibleCount = 0;
            
            quizItems.forEach(item => {
                const quizName = item.dataset.name || '';
                const matches = searchTerm === '' || quizName.includes(searchTerm);
                
                if (matches) {
                    item.style.display = 'flex';
                    visibleCount++;
                } else {
                    item.style.display = 'none';
                }
            });
            
            // Show/hide no results message
            if (quizListDiv && noResultsDiv) {
                if (visibleCount === 0 && searchTerm !== '') {
                    quizListDiv.style.display = 'none';
                    noResultsDiv.classList.remove('hidden');
                } else {
                    quizListDiv.style.display = 'block';
                    noResultsDiv.classList.add('hidden');
                }
            }
        }
        
        function clearSearch() {
            if (searchInput) {
                searchInput.value = '';
                filterQuizzes();
            }
        }
        
        if (searchInput) {
            searchInput.addEventListener('input', filterQuizzes);
        }
        
        // Add fade-in animation to items
        quizItems.forEach(item => {
            item.classList.add('fade-in');
        });
    </script>
</body>
</html>