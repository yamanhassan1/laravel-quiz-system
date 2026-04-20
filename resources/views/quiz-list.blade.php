<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz List — {{$category}} — Admin</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-slate-50 min-h-screen">
    <x-navbar name={{$name}}></x-navbar>

    <main class="max-w-7xl mx-auto px-6 py-10">
        <div class="flex items-center gap-3 mb-8">
            <a href="/admin-categories"
                class="inline-flex items-center gap-1.5 text-xs text-slate-500 hover:text-slate-800 bg-white border border-gray-200 hover:border-gray-300 px-3 py-1.5 rounded-lg transition-all duration-150 font-medium">
                <svg xmlns="http://www.w3.org/2000/svg" height="13px" viewBox="0 -960 960 960" width="13px" fill="currentColor"><path d="M560-240 320-480l240-240 56 56-184 184 184 184-56 56Z"/></svg>
                Categories
            </a>
            <svg xmlns="http://www.w3.org/2000/svg" height="14px" viewBox="0 -960 960 960" width="14px" fill="#94a3b8"><path d="M504-480 320-664l56-56 240 240-240 240-56-56 184-184Z"/></svg>
            <div>
                <h1 class="text-slate-800 text-xl font-semibold tracking-tight">{{$category}}</h1>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-sm">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <h3 class="text-slate-700 text-sm font-semibold">Quizzes in this category</h3>
                <span class="text-slate-400 text-xs">{{count($quizData)}} quizzes</span>
            </div>
            <table class="w-full">
                <thead>
                    <tr class="bg-slate-50 border-b border-gray-100">
                        <th class="text-left text-slate-400 text-xs font-medium uppercase tracking-wide px-6 py-3 w-20">ID</th>
                        <th class="text-left text-slate-400 text-xs font-medium uppercase tracking-wide px-6 py-3">Quiz Name</th>
                        <th class="text-right text-slate-400 text-xs font-medium uppercase tracking-wide px-6 py-3 w-24">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($quizData as $item)
                    <tr class="border-b border-gray-50 hover:bg-slate-50/50 transition-colors duration-100">
                        <td class="px-6 py-4 text-slate-400 text-sm">{{$item->id}}</td>
                        <td class="px-6 py-4 text-slate-800 text-sm font-medium">{{$item->name}}</td>
                        <td class="px-6 py-4 text-right">
                            <a href="/show-quiz/{{$item->id}}/{{$item->name}}"
                                class="inline-flex items-center gap-1.5 text-xs text-slate-500 hover:text-slate-800 bg-slate-100 hover:bg-slate-200 px-2.5 py-1.5 rounded-lg transition-all duration-150 font-medium">
                                <svg xmlns="http://www.w3.org/2000/svg" height="13px" viewBox="0 -960 960 960" width="13px" fill="currentColor"><path d="M480-320q75 0 127.5-52.5T660-500q0-75-52.5-127.5T480-680q-75 0-127.5 52.5T300-500q0 75 52.5 127.5T480-320Zm0-72q-45 0-76.5-31.5T372-500q0-45 31.5-76.5T480-608q45 0 76.5 31.5T588-500q0 45-31.5 76.5T480-392Zm0 192q-146 0-266-81.5T40-500q54-137 174-218.5T480-800q146 0 266 81.5T920-500q-54 137-174 218.5T480-200Z"/></svg>
                                View MCQs
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @if(count($quizData) === 0)
                <div class="px-6 py-12 text-center">
                    <p class="text-slate-400 text-sm">No quizzes in this category yet.</p>
                    <a href="/add-quiz" class="inline-block mt-3 text-slate-600 hover:text-slate-900 text-sm font-medium underline underline-offset-2">Create one →</a>
                </div>
            @endif
        </div>
    </main>
</body>
</html>