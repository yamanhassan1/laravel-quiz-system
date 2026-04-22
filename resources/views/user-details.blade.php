<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Details — Quiz System</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">
    <x-user-navbar></x-user-navbar>

    {{-- Hero --}}
    <section class="bg-white border-b border-gray-100">
        <div class="max-w-5xl mx-auto px-6 py-14 text-center">
            <h1 class="text-emerald-950 text-4xl font-bold tracking-tight leading-tight mb-4">
                Quiz History<br>
                <span class="text-emerald-600">Your Attempted Quizzes</span>
            </h1>
            <p class="text-slate-400 text-sm">Review your past performance and revise any quiz</p>
        </div>
    </section>

    <main class="flex-1">
        <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-sm max-w-5xl mx-auto my-10">
            <table class="w-full">
                <thead>
                    <tr class="bg-slate-50 border-b border-gray-100">
                        <th class="text-left text-slate-400 text-xs font-medium uppercase tracking-wide px-6 py-3 w-12">#</th>
                        <th class="text-left text-slate-400 text-xs font-medium uppercase tracking-wide px-6 py-3">Quiz Name</th>
                        <th class="text-left text-slate-400 text-xs font-medium uppercase tracking-wide px-6 py-3">Score</th>
                        <th class="text-left text-slate-400 text-xs font-medium uppercase tracking-wide px-6 py-3">Progress</th>
                        <th class="text-left text-slate-400 text-xs font-medium uppercase tracking-wide px-6 py-3">Status</th>
                        <th class="text-left text-slate-400 text-xs font-medium uppercase tracking-wide px-6 py-3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($quizRecords as $key => $record)
                    @php
                        $percent = $record->total_mcq > 0 ? round(($record->correct / $record->total_mcq) * 100) : 0;
                        $scoreColor = $percent >= 80 ? 'text-emerald-700 bg-emerald-50 border-emerald-100'
                                    : ($percent >= 50 ? 'text-amber-700 bg-amber-50 border-amber-100'
                                    : 'text-red-700 bg-red-50 border-red-100');
                        $barColor = $percent >= 80 ? 'bg-emerald-500'
                                  : ($percent >= 50 ? 'bg-amber-400' : 'bg-red-400');
                    @endphp
                    <tr class="border-b border-gray-50 hover:bg-emerald-50/30 transition-colors duration-100">

                        {{-- # --}}
                        <td class="px-6 py-4 text-slate-400 text-sm">{{$key + 1}}</td>

                        {{-- Quiz Name --}}
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-xs font-bold shrink-0">
                                    {{strtoupper(substr($record->name, 0, 1))}}
                                </div>
                                <span class="text-slate-800 text-sm font-medium">{{$record->name}}</span>
                            </div>
                        </td>

                        {{-- Score --}}
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center text-xs font-semibold px-2.5 py-1 rounded-lg border"
                            style="
                                color: {{$percent >= 80 ? '#065f46' : ($percent >= 50 ? '#92400e' : '#991b1b')}};
                                background: {{$percent >= 80 ? '#ecfdf5' : ($percent >= 50 ? '#fffbeb' : '#fef2f2')}};
                                border-color: {{$percent >= 80 ? '#a7f3d0' : ($percent >= 50 ? '#fde68a' : '#fecaca')}};
                                ">
                                {{$record->correct}} / {{$record->total_mcq}}
                            </span>
                        </td>

                        {{-- Progress Bar --}}
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2 min-w-32">
                                <div class="flex-1 h-2 bg-gray-200 rounded-full overflow-hidden">
                                    <div class="h-full rounded-full transition-all duration-500"
                                        style="width: {{$percent}}%; background-color: {{
                                        $percent >= 80 ? '#10b981' :
                                        ($percent >= 50 ? '#f59e0b' : '#ef4444')
                                        }}">
                                    </div>
                                </div>
                                <span class="text-xs text-slate-400 font-medium w-9 text-right">{{$percent}}%</span>
                            </div>
                        </td>

                        {{-- Status --}}
                        <td class="px-6 py-4">
                            @if($record->status == 2)
                                <span class="inline-flex items-center gap-1 text-xs font-semibold px-2.5 py-1 rounded-lg bg-emerald-50 text-emerald-700 border border-emerald-100">
                                    ✓ Completed
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 text-xs font-semibold px-2.5 py-1 rounded-lg bg-amber-50 text-amber-700 border border-amber-100">
                                    ⏳ In Progress
                                </span>
                            @endif
                        </td>

                        {{-- Revise Button --}}
                        <td class="px-6 py-4">
                            <a href="/start-quiz/{{$record->quiz_id}}/{{$record->name}}"
                                class="inline-flex items-center gap-1.5 text-xs font-semibold px-3 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white transition-all duration-150">
                                <svg xmlns="http://www.w3.org/2000/svg" height="12px" viewBox="0 -960 960 960" width="12px" fill="currentColor"><path d="M160-160v-80h110l-16-14q-52-46-73-105t-21-119q0-111 66.5-197.5T400-790v84q-72 26-116 88.5T240-478q0 45 15 87t45 75l20 16v-120h80v240H160Zm400-10v-84q72-26 116-88.5T720-482q0-45-15-87t-45-75l-20-16v120h-80v-240h240v80H690l16 14q52 46 73 105t21 119q0 111-66.5 197.5T560-170Z"/></svg>
                                Revise
                            </a>
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Empty state --}}
            @if(count($quizRecords) === 0)
                <div class="px-6 py-16 text-center">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-50 flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" height="22px" viewBox="0 -960 960 960" width="22px" fill="#059669"><path d="M200-280v-80h560v80H200Zm0-160v-80h560v80H200Zm0-160v-80h560v80H200Z"/></svg>
                    </div>
                    <p class="text-slate-500 text-sm font-medium">No Quiz History Found!</p>
                    <p class="text-slate-400 text-xs mt-1">Attempt a quiz to see your history here.</p>
                    <a href="/" class="inline-flex mt-4 items-center gap-1.5 text-xs font-semibold px-4 py-2 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white transition-all duration-150">
                        Browse Quizzes
                    </a>
                </div>
            @endif
        </div>
    </main>

    <x-footer-user></x-footer-user>
</body>
</html>