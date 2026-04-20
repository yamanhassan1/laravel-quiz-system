<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard — Quiz System</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-slate-50 min-h-screen">
    <x-navbar name={{$name}}></x-navbar>

    <main class="max-w-7xl mx-auto px-6 py-10">
        <div class="mb-8">
            <h1 class="text-slate-800 text-2xl font-semibold tracking-tight">Dashboard</h1>
            <p class="text-slate-400 text-sm mt-1">Welcome back, {{$name}}</p>
        </div>

        {{-- Quick action cards --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="/admin-categories" class="bg-white border border-gray-200 rounded-2xl p-6 hover:border-slate-300 hover:shadow-sm transition-all duration-200 group">
                <div class="w-10 h-10 rounded-xl bg-slate-100 group-hover:bg-slate-200 flex items-center justify-center mb-4 transition-colors duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="text-slate-600" height="18px" viewBox="0 -960 960 960" width="18px" fill="currentColor"><path d="M200-280v-80h560v80H200Zm0-160v-80h560v80H200Zm0-160v-80h560v80H200Z"/></svg>
                </div>
                <p class="text-slate-800 text-sm font-semibold">Manage Categories</p>
                <p class="text-slate-400 text-xs mt-1">Add, view and delete quiz categories</p>
            </a>
            <a href="/add-quiz" class="bg-white border border-gray-200 rounded-2xl p-6 hover:border-slate-300 hover:shadow-sm transition-all duration-200 group">
                <div class="w-10 h-10 rounded-xl bg-slate-100 group-hover:bg-slate-200 flex items-center justify-center mb-4 transition-colors duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="text-slate-600" height="18px" viewBox="0 -960 960 960" width="18px" fill="currentColor"><path d="M440-440H200v-80h240v-240h80v240h240v80H520v240h-80v-240Z"/></svg>
                </div>
                <p class="text-slate-800 text-sm font-semibold">Create Quiz</p>
                <p class="text-slate-400 text-xs mt-1">Build new quizzes with MCQs</p>
            </a>
            <div class="bg-white border border-gray-200 rounded-2xl p-6">
                <div class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="text-slate-600" height="18px" viewBox="0 -960 960 960" width="18px" fill="currentColor"><path d="M480-280q17 0 28.5-11.5T520-320q0-17-11.5-28.5T480-360q-17 0-28.5 11.5T440-320q0 17 11.5 28.5T480-280Zm-40-160h80v-240h-80v240Zm40 360q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Z"/></svg>
                </div>
                <p class="text-slate-800 text-sm font-semibold">System Info</p>
                <p class="text-slate-400 text-xs mt-1">Quiz System v1.0 — All systems operational</p>
            </div>
        </div>
    </main>
</body>
</html>