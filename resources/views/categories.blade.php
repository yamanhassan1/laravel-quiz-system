<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories — Quiz System Admin</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-slate-50 min-h-screen">
    <x-navbar name={{$name}}></x-navbar>

    @if(Session('category'))
        <div class="bg-emerald-50 border-b border-emerald-200 px-6 py-3">
            <div class="max-w-7xl mx-auto flex items-center gap-2 text-emerald-700 text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" height="16px" viewBox="0 -960 960 960" width="16px" fill="currentColor"><path d="m424-296 282-282-56-56-226 226-114-114-56 56 170 170Zm56 216q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Z"/></svg>
                {{Session('category')}}
            </div>
        </div>
    @endif

    <main class="max-w-7xl mx-auto px-6 py-10">
        <div class="flex items-start justify-between mb-8 gap-8">

            {{-- Page title --}}
            <div>
                <h1 class="text-slate-800 text-2xl font-semibold tracking-tight">Categories</h1>
                <p class="text-slate-400 text-sm mt-1">Manage quiz categories</p>
            </div>

            {{-- Add category form --}}
            <div class="bg-white border border-gray-200 rounded-2xl p-6 w-full max-w-xs shadow-sm shrink-0">
                <h2 class="text-slate-700 text-sm font-semibold mb-4">Add New Category</h2>
                <form action="/add-category" method="post" class="space-y-3">
                    @csrf
                    <div>
                        <input type="text" name="category" required placeholder="Category name"
                            class="w-full px-3.5 py-2.5 border border-gray-200 rounded-xl text-sm text-slate-800 bg-slate-50 focus:bg-white focus:border-slate-400 focus:outline-none transition-all duration-150 placeholder:text-slate-300">
                        @error('category')
                            <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                        @enderror
                    </div>
                    <button type="submit"
                        class="w-full py-2.5 bg-slate-800 hover:bg-slate-900 text-white text-sm font-medium rounded-xl transition-all duration-150 cursor-pointer">
                        Add Category
                    </button>
                </form>
            </div>
        </div>

        {{-- Category table --}}
        <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-sm">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <h3 class="text-slate-700 text-sm font-semibold">All Categories</h3>
                <span class="text-slate-400 text-xs">{{count($categories)}} total</span>
            </div>
            <table class="w-full">
                <thead>
                    <tr class="bg-slate-50 border-b border-gray-100">
                        <th class="text-left text-slate-400 text-xs font-medium uppercase tracking-wide px-6 py-3 w-16">#</th>
                        <th class="text-left text-slate-400 text-xs font-medium uppercase tracking-wide px-6 py-3">Name</th>
                        <th class="text-left text-slate-400 text-xs font-medium uppercase tracking-wide px-6 py-3">Quizzes</th>
                        <th class="text-left text-slate-400 text-xs font-medium uppercase tracking-wide px-6 py-3">Created by</th>
                        <th class="text-right text-slate-400 text-xs font-medium uppercase tracking-wide px-6 py-3 w-28">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                    <tr class="border-b border-gray-50 hover:bg-slate-50/50 transition-colors duration-100">
                        <td class="px-6 py-4 text-slate-400 text-sm">{{$category->id}}</td>
                        <td class="px-6 py-4 text-slate-800 text-sm font-medium">{{$category->name}}</td>
                        <td class="px-6 py-4 text-slate-500 text-sm">{{$category->quizzes->count()}}</td>
                        <td class="px-6 py-4 text-slate-500 text-sm">{{$category->creator}}</td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="/quiz-list/{{$category->id}}/{{$category->name}}"
                                    class="inline-flex items-center gap-1.5 text-xs text-slate-500 hover:text-slate-800 bg-slate-100 hover:bg-slate-200 px-2.5 py-1.5 rounded-lg transition-all duration-150 font-medium">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="13px" viewBox="0 -960 960 960" width="13px" fill="currentColor"><path d="M480-320q75 0 127.5-52.5T660-500q0-75-52.5-127.5T480-680q-75 0-127.5 52.5T300-500q0 75 52.5 127.5T480-320Zm0-72q-45 0-76.5-31.5T372-500q0-45 31.5-76.5T480-608q45 0 76.5 31.5T588-500q0 45-31.5 76.5T480-392Zm0 192q-146 0-266-81.5T40-500q54-137 174-218.5T480-800q146 0 266 81.5T920-500q-54 137-174 218.5T480-200Z"/></svg>
                                    View
                                </a>
                                <a href="/category/delete/{{$category->id}}"
                                    class="inline-flex items-center gap-1.5 text-xs text-red-500 hover:text-red-700 bg-red-50 hover:bg-red-100 px-2.5 py-1.5 rounded-lg transition-all duration-150 font-medium"
                                    onclick="return confirm('Delete this category?')">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="13px" viewBox="0 -960 960 960" width="13px" fill="currentColor"><path d="M312-144q-29.7 0-50.85-21.15Q240-186.3 240-216v-480h-48v-72h192v-48h192v48h192v72h-48v479.57Q720-186 698.85-165T648-144H312Zm336-552H312v480h336v-480ZM384-288h72v-336h-72v336Zm120 0h72v-336h-72v336ZM312-696v480-480Z"/></svg>
                                    Delete
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @if(count($categories) === 0)
                <div class="px-6 py-12 text-center">
                    <p class="text-slate-400 text-sm">No categories yet. Add your first one above.</p>
                </div>
            @endif
        </div>
    </main>
</body>
</html>