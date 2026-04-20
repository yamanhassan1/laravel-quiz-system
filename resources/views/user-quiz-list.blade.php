<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$category}} Quizzes — Quiz System</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">
    <x-user-navbar></x-user-navbar>

    <main class="flex-1 max-w-3xl mx-auto w-full px-6 py-10">

        <div class="flex items-center gap-3 mb-8">
            <a href="/"
                class="inline-flex items-center gap-1.5 text-xs text-slate-500 hover:text-slate-800 bg-white border border-gray-200 hover:border-gray-300 px-3 py-1.5 rounded-lg transition-all duration-150 font-medium">
                <svg xmlns="http://www.w3.org/2000/svg" height="13px" viewBox="0 -960 960 960" width="13px" fill="currentColor"><path d="M560-240 320-480l240-240 56 56-184 184 184 184-56 56Z"/></svg>
                All Categories
            </a>
            <svg xmlns="http://www.w3.org/2000/svg" height="14px" viewBox="0 -960 960 960" width="14px" fill="#94a3b8"><path d="M504-480 320-664l56-56 240 240-240 240-56-56 184-184Z"/></svg>
            <div>
                <h1 class="text-emerald-900 text-xl font-semibold tracking-tight">{{$category}}</h1>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-sm">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <h3 class="text-slate-700 text-sm font-semibold">Available Quizzes</h3>
                <span class="text-slate-400 text-xs">{{count($quizData)}} quizzes</span>
            </div>
            <div class="divide-y divide-gray-50">
                @foreach($quizData as $index => $item)
                <div class="px-6 py-4 flex items-center justify-between hover:bg-emerald-50/30 transition-colors duration-100">
                    <div class="flex items-center gap-3">
                        <span class="shrink-0 w-8 h-8 rounded-xl bg-emerald-50 text-emerald-600 text-xs font-bold flex items-center justify-center">{{$index + 1}}</span>
                        <div>
                            <p class="text-slate-800 text-sm font-medium">{{$item->name}}</p>
                            <p class="text-slate-400 text-xs mt-0.5">Quiz #{{$item->id}}</p>
                        </div>
                    </div>
                    <a href="/"
                        class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold px-4 py-2 rounded-xl transition-all duration-150">
                        <svg xmlns="http://www.w3.org/2000/svg" height="13px" viewBox="0 -960 960 960" width="13px" fill="currentColor"><path d="M504-480 320-664l56-56 240 240-240 240-56-56 184-184Z"/></svg>
                        Attempt Quiz
                    </a>
                </div>
                @endforeach
            </div>
            @if(count($quizData) === 0)
                <div class="px-6 py-12 text-center">
                    <p class="text-slate-400 text-sm">No quizzes available in this category yet. Check back soon!</p>
                </div>
            @endif
        </div>
    </main>

    <x-footer-user></x-footer-user>
</body>
</html>