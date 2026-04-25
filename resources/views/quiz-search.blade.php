<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Search results for quizzes matching your query">
    <title>Search Results — Quiz System</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gradient-to-br from-gray-50 to-slate-50 min-h-screen flex flex-col">
    <x-user-navbar></x-user-navbar>

    <main class="flex-1 max-w-4xl mx-auto w-full px-4 sm:px-6 py-8 sm:py-10">

        {{-- Header with back button --}}
        <div class="mb-6">
            <a href="/" 
               class="inline-flex items-center gap-1 text-xs text-slate-500 hover:text-emerald-600 transition-colors mb-3 group">
                <svg class="w-3 h-3 group-hover:-translate-x-0.5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Home
            </a>
            
            <div class="flex items-center gap-3">
                <div class="w-1 h-8 bg-emerald-500 rounded-full"></div>
                <div>
                    <h1 class="text-emerald-900 text-xl font-bold tracking-tight">
                        Search Results
                    </h1>
                    <p class="text-slate-500 text-sm mt-0.5">
                        Showing results for: <span class="font-semibold text-emerald-700">"{{ $quiz }}"</span>
                    </p>
                </div>
            </div>
        </div>

        @if(count($quizData) > 0)
            {{-- Results summary --}}
            <div class="bg-emerald-50 border border-emerald-100 rounded-xl px-4 py-2.5 mb-5 flex items-center justify-between flex-wrap gap-2">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <span class="text-sm text-emerald-800">
                        Found <span class="font-bold">{{ count($quizData) }}</span> {{ Str::plural('quiz', count($quizData)) }}
                    </span>
                </div>
            </div>

            {{-- Quiz list --}}
            <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-sm" id="quiz-list">
                @foreach($quizData as $index => $item)
                <div class="quiz-item flex flex-col sm:flex-row sm:items-center gap-3 sm:gap-4 px-4 sm:px-5 py-4 border-b border-gray-50 hover:bg-emerald-50/30 transition-all group"
                     data-index="{{ $index }}">
                    
                    {{-- Number --}}
                    <div class="flex items-center gap-3">
                        <span class="w-8 h-8 rounded-xl bg-emerald-50 text-emerald-600 border border-emerald-100 text-xs font-extrabold flex items-center justify-center shrink-0 group-hover:bg-emerald-100 transition-colors">
                            {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                        </span>
                    </div>

                    {{-- Quiz info --}}
                    <div class="flex-1 min-w-0">
                        <p class="text-slate-800 text-sm font-semibold">{{ $item->name }}</p>
                        <div class="flex items-center gap-2 mt-1 flex-wrap">
                            <span class="inline-flex items-center gap-1 text-[10px] text-slate-400">
                                <svg class="w-2.5 h-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                {{ $item->mcqs->count() }} questions
                            </span>
                            
                            @if(isset($item->category))
                                <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                                <span class="inline-flex items-center gap-1 text-[10px] text-slate-400">
                                    <svg class="w-2.5 h-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                    </svg>
                                    {{ $item->category->name ?? 'Uncategorized' }}
                                </span>
                            @endif
                            
                            @if(isset($item->difficulty))
                                <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                                <span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-[9px] font-medium
                                    {{ $item->difficulty == 'easy' ? 'bg-green-100 text-green-700' : 
                                       ($item->difficulty == 'hard' ? 'bg-red-100 text-red-700' : 
                                       'bg-yellow-100 text-yellow-700') }}">
                                    {{ ucfirst($item->difficulty) }}
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- Start button --}}
                    <a href="/start-quiz/{{ $item->id }}/{{ Str::slug($item->name) }}"
                       class="inline-flex items-center justify-center gap-1.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold px-5 py-2 rounded-xl transition-all hover:shadow-md active:scale-95 shrink-0 w-full sm:w-auto">
                        Start Quiz
                        <svg class="w-3 h-3 group-hover:translate-x-0.5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </a>
                </div>
                @endforeach
            </div>

            {{-- Results count --}}
            <div class="mt-5 text-center">
                <p class="text-xs text-slate-400">
                    {{ count($quizData) }} {{ Str::plural('quiz', count($quizData)) }} found
                </p>
            </div>

        @else
            {{-- No results state --}}
            <div class="bg-white border border-gray-200 rounded-2xl px-6 py-16 text-center shadow-sm">
                <div class="w-16 h-16 rounded-2xl bg-amber-50 border border-amber-100 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <p class="text-slate-700 text-sm font-semibold mb-1">No quizzes found</p>
                <p class="text-slate-400 text-sm max-w-xs mx-auto">
                    We couldn't find any quizzes matching <span class="font-medium text-slate-500">"{{ $quiz }}"</span>
                </p>
                <div class="flex flex-col sm:flex-row gap-3 justify-center mt-6">
                    <button onclick="history.back()" 
                            class="inline-flex items-center justify-center gap-1.5 text-sm font-semibold text-slate-600 bg-gray-100 border border-gray-200 hover:bg-gray-200 px-5 py-2 rounded-xl transition-all">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Go Back
                    </button>
                </div>
            </div>
        @endif

        {{-- Search tips --}}
        <div class="mt-6 text-center">
            <div class="inline-flex items-center gap-2 text-[10px] text-slate-400">
                <svg class="w-3 h-3 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>Tip: Try using fewer words or check your spelling</span>
            </div>
        </div>

    </main>

    <x-footer-user></x-footer-user>
</body>
</html>