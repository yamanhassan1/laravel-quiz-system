<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$quizName}} — MCQs — Admin</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-slate-50 min-h-screen">
    <x-navbar name={{$name}}></x-navbar>

    <main class="max-w-7xl mx-auto px-6 py-10">
        <div class="flex items-center gap-3 mb-8">
            <a href="/add-quiz"
                class="inline-flex items-center gap-1.5 text-xs text-slate-500 hover:text-slate-800 bg-white border border-gray-200 hover:border-gray-300 px-3 py-1.5 rounded-lg transition-all duration-150 font-medium">
                <svg xmlns="http://www.w3.org/2000/svg" height="13px" viewBox="0 -960 960 960" width="13px" fill="currentColor"><path d="M560-240 320-480l240-240 56 56-184 184 184 184-56 56Z"/></svg>
                Back
            </a>
            <svg xmlns="http://www.w3.org/2000/svg" height="14px" viewBox="0 -960 960 960" width="14px" fill="#94a3b8"><path d="M504-480 320-664l56-56 240 240-240 240-56-56 184-184Z"/></svg>
            <h1 class="text-slate-800 text-xl font-semibold tracking-tight">{{$quizName}}</h1>
        </div>

        <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-sm">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <h3 class="text-slate-700 text-sm font-semibold">Questions</h3>
                <span class="text-slate-400 text-xs">{{count($mcqs)}} MCQs</span>
            </div>
            <div class="divide-y divide-gray-50">
                @foreach($mcqs as $index => $mcq)
                <div class="px-6 py-4 flex gap-4 hover:bg-slate-50/50 transition-colors duration-100">
                    <span class="shrink-0 w-7 h-7 rounded-lg bg-slate-100 text-slate-500 text-xs font-semibold flex items-center justify-center">{{$index + 1}}</span>
                    <div>
                        <p class="text-slate-800 text-sm leading-relaxed">{{$mcq->question}}</p>
                        <span class="inline-block mt-1 text-slate-400 text-xs">ID: {{$mcq->id}}</span>
                    </div>
                </div>
                @endforeach
            </div>
            @if(count($mcqs) === 0)
                <div class="px-6 py-12 text-center">
                    <p class="text-slate-400 text-sm">No questions added yet.</p>
                </div>
            @endif
        </div>
    </main>
</body>
</html>