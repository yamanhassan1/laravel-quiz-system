<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz System — Test Your Knowledge</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">
    <x-user-navbar></x-user-navbar>

    {{-- Hero section --}}
    <section class="bg-white border-b border-gray-100">
        <div class="max-w-5xl mx-auto px-6 py-14 text-center">
            <h1 class="text-emerald-950 text-4xl font-bold tracking-tight leading-tight mb-4">
                Test your knowledge.<br>
                <span class="text-emerald-600">Challenge yourself daily.</span>
            </h1>
            <p class="text-slate-500 text-base max-w-md mx-auto leading-relaxed mb-8">
                Hundreds of quizzes across every topic. Pick a category, attempt a quiz, and see how you score.
            </p>

            {{-- Search --}}
            <div class="relative max-w-md mx-auto">
                <input type="text"
                    class="w-full px-5 py-3 pr-12 border border-gray-200 rounded-2xl text-sm text-slate-800 bg-white shadow-sm focus:border-emerald-400 focus:outline-none transition-all duration-150 placeholder:text-slate-300"
                    placeholder="Search quizzes or categories...">
                <button class="absolute right-3 top-1/2 -translate-y-1/2 w-8 h-8 rounded-xl bg-emerald-600 hover:bg-emerald-700 flex items-center justify-center transition-colors duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" height="15px" viewBox="0 -960 960 960" width="15px" fill="white"><path d="M765-144 526-383q-30 22-65.79 34.5-35.79 12.5-76.18 12.5Q284-336 214-406t-70-170q0-100 70-170t170-70q100 0 170 70t70 170.03q0 40.39-12.5 76.18Q599-464 577-434l239 239-51 51ZM384-408q70 0 119-49t49-119q0-70-49-119t-119-49q-70 0-119 49t-49 119q0 70 49 119t119 49Z"/></svg>
                </button>
            </div>
        </div>
    </section>

    {{-- Categories --}}
    <main class="flex-1 max-w-5xl mx-auto w-full px-6 py-10">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-emerald-900 text-lg font-semibold tracking-tight">Browse Categories</h2>
            <span class="text-slate-400 text-sm">{{count($categories)}} available</span>
        </div>

        <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-sm">
            <table class="w-full">
                <thead>
                    <tr class="bg-slate-50 border-b border-gray-100">
                        <th class="text-left text-slate-400 text-xs font-medium uppercase tracking-wide px-6 py-3 w-16">#</th>
                        <th class="text-left text-slate-400 text-xs font-medium uppercase tracking-wide px-6 py-3">Category</th>
                        <th class="text-left text-slate-400 text-xs font-medium uppercase tracking-wide px-6 py-3 w-32">Quizzes</th>
                        <th class="text-right text-slate-400 text-xs font-medium uppercase tracking-wide px-6 py-3 w-28">Explore</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $key => $category)
                    <tr class="border-b border-gray-50 hover:bg-emerald-50/30 transition-colors duration-100">
                        <td class="px-6 py-4 text-slate-400 text-sm">{{$key + 1}}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-xs font-bold shrink-0">
                                    {{strtoupper(substr($category->name, 0, 1))}}
                                </div>
                                <span class="text-slate-800 text-sm font-medium">{{$category->name}}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-700 border border-emerald-100 text-xs font-semibold px-2.5 py-1 rounded-lg">
                                {{$category->quizzes_count}} quizzes
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="/user-quiz-list/{{$category->id}}/{{$category->name}}"
                                class="inline-flex items-center gap-1.5 text-emerald-600 hover:text-emerald-800 text-xs font-semibold hover:bg-emerald-50 px-3 py-1.5 rounded-lg transition-all duration-150">
                                View Quizzes
                                <svg xmlns="http://www.w3.org/2000/svg" height="13px" viewBox="0 -960 960 960" width="13px" fill="currentColor"><path d="M504-480 320-664l56-56 240 240-240 240-56-56 184-184Z"/></svg>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @if(count($categories) === 0)
                <div class="px-6 py-16 text-center">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-50 flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" height="22px" viewBox="0 -960 960 960" width="22px" fill="#059669"><path d="M200-280v-80h560v80H200Zm0-160v-80h560v80H200Zm0-160v-80h560v80H200Z"/></svg>
                    </div>
                    <p class="text-slate-500 text-sm font-medium">No categories yet</p>
                    <p class="text-slate-400 text-xs mt-1">Check back soon for new quizzes!</p>
                </div>
            @endif
        </div>
    </main>

    <x-footer-user></x-footer-user>
</body>
</html>