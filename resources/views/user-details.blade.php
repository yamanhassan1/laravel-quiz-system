<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Details — Test Your Knowledge</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">
    <x-user-navbar></x-user-navbar>

    {{-- Hero section --}}
    <section class="bg-white border-b border-gray-100">
        <div class="max-w-5xl mx-auto px-6 py-14 text-center">
            <h1 class="text-emerald-950 text-4xl font-bold tracking-tight leading-tight mb-4">
                Users History<br>
                <span class="text-emerald-600">Attempted Quizzes</span>
            </h1>
        </div>
    </section>
        <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-sm w-230 mx-auto my-10">
            <table class="w-full">
                <thead>
                    <tr class="bg-slate-50 border-b border-gray-100">
                        <th class="text-left text-slate-400 text-xs font-medium uppercase tracking-wide px-6 py-3 w-16">#</th>
                        <th class="text-left text-slate-400 text-xs font-medium uppercase tracking-wide px-6 py-3">Name</th>
                        <th class="text-left text-slate-400 text-xs font-medium uppercase tracking-wide px-6 py-3 w-42">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($quizRecords as $key => $record)
                    <tr class="border-b border-gray-50 hover:bg-emerald-50/30 transition-colors duration-100">
                        <td class="px-6 py-4 text-slate-400 text-sm">{{$key + 1}}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-xs font-bold shrink-0">
                                    {{strtoupper(substr($record->name, 0, 1))}}
                                </div>
                                <span class="text-slate-800 text-sm font-medium">{{$record->name}}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex">
                                @if($record->status == 2)
                                   <span class=' items-center gap-1 text-xs font-semibold px-2 bg-emerald-50 text-emerald-700 border border-emerald-100 5 py-1 rounded-lg'>Completed</span> 
                                @else
                                    <span class=' items-center gap-1 text-xs font-semibold px-2 bg-amber-50 text-amber-700 border border-amber-100 5 py-1 rounded-lg'>In Progress</span>
                                @endif
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @if(count($quizRecords) === 0)
                <div class="px-6 py-16 text-center">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-50 flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" height="22px" viewBox="0 -960 960 960" width="22px" fill="#059669"><path d="M200-280v-80h560v80H200Zm0-160v-80h560v80H200Zm0-160v-80h560v80H200Z"/></svg>
                    </div>
                    <p class="text-slate-500 text-sm font-medium">No Data Found!</p>
                    <p class="text-slate-400 text-xs mt-1">Check back after a quiz!</p>
                </div>
            @endif
        </div>
    </main>

    <x-footer-user></x-footer-user>
</body>
</html>