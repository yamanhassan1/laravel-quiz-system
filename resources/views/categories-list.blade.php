<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Browse all quiz categories and test your knowledge">
    <title>All Categories — Quiz System</title>
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
        
        .category-row {
            transition: all 0.2s ease;
        }
        
        .pagination-btn {
            transition: all 0.2s ease;
        }
        
        .pagination-btn:hover:not(:disabled) {
            transform: translateY(-1px);
        }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-50 to-slate-50 min-h-screen flex flex-col">
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

    {{-- Hero Section with Stats --}}
    <section class="bg-white border-b border-gray-100">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 pt-12 sm:pt-14 pb-8 sm:pb-10 text-center">
            <div class="inline-flex items-center gap-2 bg-emerald-50 px-3 py-1 rounded-full mb-4">
                <svg class="w-3 h-3 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
                <span class="text-[10px] font-semibold text-emerald-700 uppercase tracking-wide">Explore Topics</span>
            </div>
            <h1 class="text-emerald-950 text-3xl sm:text-4xl font-extrabold tracking-tight mb-3">
                Browse All Categories
            </h1>
            <p class="text-slate-500 text-sm max-w-md mx-auto leading-relaxed">
                Discover quizzes by topic. Pick a category that interests you and start learning.
            </p>
        </div>
    </section>

    {{-- Main Content --}}
    <main class="flex-1 max-w-5xl mx-auto w-full px-4 sm:px-6 py-8 sm:py-10">
        
        {{-- Categories Section --}}
        <section aria-labelledby="categories-heading">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-5">
                <div>
                    <h2 id="categories-heading" class="text-emerald-950 text-base font-bold tracking-tight">All Categories</h2>
                    <p class="text-slate-400 text-xs mt-0.5">Pick a topic to explore its quizzes</p>
                </div>
                <div class="flex items-center gap-2">
                    <div class="flex items-center gap-1 text-xs text-slate-400 bg-slate-100 px-3 py-1.5 rounded-full">
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                        <span id="category-count">{{ $categories->total() }}</span>
                        <span>available</span>
                    </div>
                </div>
            </div>

            @if($categories->count() > 0)
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
                            <div class="category-row grid grid-cols-1 md:grid-cols-[40px_1fr_120px_110px] gap-3 md:gap-2 px-4 md:px-5 py-4 md:py-3.5 items-center border-b border-gray-50 hover:bg-emerald-50/30 transition-all group"
                                 data-category-id="{{ $category->id }}"
                                 style="animation-delay: {{ $index * 0.03 }}s">
                                
                                {{-- Index (visible on desktop only) --}}
                                <span class="hidden md:inline text-[11px] font-semibold text-slate-300">
                                    {{ str_pad($categories->firstItem() + $index, 2, '0', STR_PAD_LEFT) }}
                                </span>

                                {{-- Category Info --}}
                                <div class="flex items-center gap-3 min-w-0">
                                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-100 to-emerald-50 text-emerald-700 border border-emerald-100 flex items-center justify-center text-sm font-extrabold shrink-0 group-hover:scale-110 transition-transform">
                                        {{ strtoupper(substr($category->name, 0, 1)) }}
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <p class="text-slate-800 text-sm font-semibold truncate">{{ $category->name }}</p>
                                        <div class="flex items-center gap-2 mt-1">
                                            <span class="inline-flex items-center gap-1 text-[10px] text-slate-400 md:hidden">
                                                <svg class="w-2.5 h-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                                {{ $category->quizzes_count }} quizzes
                                            </span>
                                        </div>
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
                                    <a href="{{ route('user.quiz.list', ['category' => $category->id, 'name' => Str::slug($category->name)]) }}"
                                       class="inline-flex items-center gap-1.5 text-emerald-600 hover:text-white text-xs font-bold border border-emerald-200 hover:border-emerald-600 bg-emerald-50 hover:bg-emerald-600 px-3 py-1.5 rounded-lg transition-all group/btn">
                                        View
                                        <svg class="w-3 h-3 transition-transform group-hover/btn:translate-x-0.5" viewBox="0 -960 960 960" fill="currentColor">
                                            <path d="M504-480 320-664l56-56 240 240-240 240-56-56 184-184Z"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Pagination --}}
                @if($categories->hasPages())
                    <div class="mt-6 flex flex-col sm:flex-row items-center justify-between gap-4">
                        <div class="text-slate-400 text-xs">
                            Showing 
                            <span class="font-medium text-slate-600">{{ $categories->firstItem() }}</span> 
                            to 
                            <span class="font-medium text-slate-600">{{ $categories->lastItem() }}</span> 
                            of 
                            <span class="font-medium text-slate-600">{{ $categories->total() }}</span> 
                            categories
                        </div>
                        
                        <div class="flex items-center gap-2">
                            {{-- Previous Page Link --}}
                            @if($categories->onFirstPage())
                                <span class="pagination-btn inline-flex items-center gap-1 px-3 py-2 rounded-lg text-xs font-medium text-slate-300 bg-slate-50 border border-gray-200 cursor-not-allowed">
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                    </svg>
                                    Previous
                                </span>
                            @else
                                <a href="{{ $categories->previousPageUrl() }}" 
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
                                    $currentPage = $categories->currentPage();
                                    $lastPage = $categories->lastPage();
                                    $start = max(1, $currentPage - 2);
                                    $end = min($lastPage, $currentPage + 2);
                                    
                                    if ($start > 1) {
                                        echo '<a href="' . $categories->url(1) . '" class="pagination-btn w-8 h-8 flex items-center justify-center rounded-lg text-xs font-medium text-slate-600 bg-white border border-gray-200 hover:bg-emerald-50 hover:border-emerald-200 transition-all">1</a>';
                                        if ($start > 2) {
                                            echo '<span class="text-slate-300 text-xs px-1">...</span>';
                                        }
                                    }
                                @endphp
                                
                                @for($i = $start; $i <= $end; $i++)
                                    @if($i == $currentPage)
                                        <span class="w-8 h-8 flex items-center justify-center rounded-lg text-xs font-bold text-white bg-emerald-600 border border-emerald-600 shadow-sm">
                                            {{ $i }}
                                        </span>
                                    @else
                                        <a href="{{ $categories->url($i) }}" 
                                           class="pagination-btn w-8 h-8 flex items-center justify-center rounded-lg text-xs font-medium text-slate-600 bg-white border border-gray-200 hover:bg-emerald-50 hover:border-emerald-200 transition-all">
                                            {{ $i }}
                                        </a>
                                    @endif
                                @endfor
                                
                                @php
                                    if ($end < $lastPage) {
                                        if ($end < $lastPage - 1) {
                                            echo '<span class="text-slate-300 text-xs px-1">...</span>';
                                        }
                                        echo '<a href="' . $categories->url($lastPage) . '" class="pagination-btn w-8 h-8 flex items-center justify-center rounded-lg text-xs font-medium text-slate-600 bg-white border border-gray-200 hover:bg-emerald-50 hover:border-emerald-200 transition-all">' . $lastPage . '</a>';
                                    }
                                @endphp
                            </div>
                            
                            {{-- Next Page Link --}}
                            @if($categories->hasMorePages())
                                <a href="{{ $categories->nextPageUrl() }}" 
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
                @endif

            @else
                {{-- Empty State --}}
                <div class="bg-white border border-gray-200 rounded-2xl px-6 py-16 text-center shadow-sm">
                    <div class="w-16 h-16 rounded-2xl bg-emerald-50 border border-emerald-100 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                    </div>
                    <p class="text-slate-700 text-sm font-semibold mb-1">No categories yet</p>
                    <p class="text-slate-400 text-xs max-w-xs mx-auto">
                        Our team is adding quizzes. Check back soon — new categories are added regularly!
                    </p>
                    <a href="/"
                        class="inline-flex items-center gap-1.5 mt-5 text-xs font-semibold text-emerald-600 hover:text-emerald-700 border border-emerald-200 hover:border-emerald-400 bg-emerald-50 hover:bg-emerald-100 px-4 py-2 rounded-xl transition-all">
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        Back to Home
                    </a>
                </div>
            @endif
        </section>
    </main>

    <x-footer-user />

    <script>
        // Add fade-in animation to category rows
        document.addEventListener('DOMContentLoaded', () => {
            const rows = document.querySelectorAll('.category-row');
            rows.forEach((row, idx) => {
                row.style.opacity = '0';
                row.style.transform = 'translateY(10px)';
                setTimeout(() => {
                    row.style.transition = 'all 0.3s ease-out';
                    row.style.opacity = '1';
                    row.style.transform = 'translateY(0)';
                }, idx * 30);
            });
        });
        
        // Smooth scroll behavior
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
                if (href === '#') return;
                
                const target = document.querySelector(href);
                if (target) {
                    e.preventDefault();
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });
        
        // Add hover sound effect (optional - remove if not needed)
        const viewButtons = document.querySelectorAll('.category-row a');
        viewButtons.forEach(btn => {
            btn.addEventListener('mouseenter', () => {
                // Optional: add subtle feedback
                console.log('hover');
            });
        });
    </script>
</body>
</html>