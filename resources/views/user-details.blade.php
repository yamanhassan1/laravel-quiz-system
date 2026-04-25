<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz History — Quiz System</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-[#f8faf8] min-h-screen flex flex-col">
    <x-user-navbar></x-user-navbar>

    @php
        $totalAttempted = count($quizRecords);
        $passed  = $quizRecords->filter(fn($r) => $r->total_mcq > 0 && round(($r->correct / $r->total_mcq) * 100) >= 60)->count();
        $failed  = $quizRecords->filter(fn($r) => $r->total_mcq > 0 && round(($r->correct / $r->total_mcq) * 100) < 60 && $r->status == 2)->count();
        $avgScore = $totalAttempted > 0
            ? round($quizRecords->avg(fn($r) => $r->total_mcq > 0 ? ($r->correct / $r->total_mcq) * 100 : 0))
            : 0;
    @endphp

    {{-- ── Hero ── --}}
    <section class="bg-white border-b border-gray-100">
        <div class="max-w-5xl mx-auto px-6 pt-10 pb-8 text-center">

            <div class="inline-flex items-center gap-2 bg-emerald-50 text-emerald-700 text-[11px] font-bold px-3 py-1.5 rounded-full border border-emerald-100 mb-5 uppercase tracking-wider">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                Your Profile
            </div>

            <h1 class="text-emerald-950 text-[2rem] font-extrabold tracking-tight leading-tight mb-1">
                Quiz History
            </h1>
            <p class="text-slate-400 text-[13px] mb-7">Track your progress and revisit any quiz you've attempted</p>

            {{-- Summary stat cards --}}
            @if($totalAttempted > 0)
            <div class="flex justify-center gap-3 flex-wrap">
                @foreach([
                    ['num' => $totalAttempted, 'label' => 'Attempted', 'color' => 'text-emerald-600'],
                    ['num' => $passed,         'label' => 'Passed',    'color' => 'text-emerald-600'],
                    ['num' => $failed,         'label' => 'Failed',    'color' => 'text-red-500'],
                    ['num' => $avgScore.'%',   'label' => 'Avg Score', 'color' => $avgScore >= 60 ? 'text-emerald-600' : 'text-red-500'],
                ] as $stat)
                <div class="bg-slate-50 border border-gray-200 rounded-2xl px-5 py-3 text-center min-w-[85px]">
                    <p class="text-xl font-extrabold {{ $stat['color'] }}">{{ $stat['num'] }}</p>
                    <p class="text-[10.5px] text-slate-400 mt-0.5">{{ $stat['label'] }}</p>
                </div>
                @endforeach
            </div>
            @endif

        </div>
    </section>

    <main class="flex-1 max-w-5xl mx-auto w-full px-6 py-8">

        @if($totalAttempted > 0)

        <div class="flex items-center justify-between mb-4">
            <p class="text-slate-700 text-[13px] font-bold">All attempts</p>
            <span class="text-slate-400 text-xs bg-slate-100 px-3 py-1 rounded-full font-semibold">
                {{ $totalAttempted }} {{ Str::plural('record', $totalAttempted) }}
            </span>
        </div>

        <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-sm">

            {{-- Table header --}}
            <div class="grid grid-cols-[36px_1fr_110px_160px_110px_90px] gap-2 bg-slate-50 border-b border-gray-100 px-5 py-3">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">#</span>
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Quiz</span>
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Score</span>
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Progress</span>
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Status</span>
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Action</span>
            </div>

            {{-- Rows --}}
            @foreach($quizRecords as $key => $record)
            @php
                $percent    = $record->total_mcq > 0 ? round(($record->correct / $record->total_mcq) * 100) : 0;
                $isHigh     = $percent >= 80;
                $isMid      = $percent >= 60 && $percent < 80;
                $isLow      = $percent < 60;
                $barColor   = $isHigh ? '#10b981' : ($isMid ? '#f59e0b' : '#ef4444');
                $scoreColor = $isHigh ? ['text'=>'#065f46','bg'=>'#ecfdf5','border'=>'#a7f3d0']
                            : ($isMid  ? ['text'=>'#92400e','bg'=>'#fffbeb','border'=>'#fde68a']
                                       : ['text'=>'#991b1b','bg'=>'#fef2f2','border'=>'#fecaca']);
            @endphp
            <div class="grid grid-cols-[36px_1fr_110px_160px_110px_90px] gap-2 px-5 py-4 items-center border-b border-gray-50 hover:bg-emerald-50/20 transition-colors duration-100 group
                {{ $loop->last ? 'border-b-0' : '' }}">

                {{-- # --}}
                <span class="text-[11px] font-semibold text-slate-300">
                    {{ str_pad($key + 1, 2, '0', STR_PAD_LEFT) }}
                </span>

                {{-- Quiz name + meta --}}
                <div class="flex items-center gap-3 min-w-0">
                    <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-700 border border-emerald-100 flex items-center justify-center text-[12px] font-extrabold shrink-0 group-hover:bg-emerald-100 transition-colors duration-150">
                        {{ strtoupper(substr($record->name, 0, 1)) }}
                    </div>
                    <div class="min-w-0">
                        <p class="text-slate-800 text-[13.5px] font-semibold truncate">{{ $record->name }}</p>
                        <p class="text-slate-400 text-[11px] mt-0.5">
                            {{ $record->total_mcq }} questions
                            @if(isset($record->created_at))
                                · {{ \Carbon\Carbon::parse($record->created_at)->format('M d, Y') }}
                            @endif
                        </p>
                    </div>
                </div>

                {{-- Score badge --}}
                <div>
                    <span class="inline-flex items-center text-[11.5px] font-bold px-2.5 py-1 rounded-lg border"
                        style="color:{{ $scoreColor['text'] }};background:{{ $scoreColor['bg'] }};border-color:{{ $scoreColor['border'] }}">
                        {{ $record->correct }}/{{ $record->total_mcq }}
                    </span>
                </div>

                {{-- Progress bar --}}
                <div class="flex items-center gap-2">
                    <div class="flex-1 h-1.5 bg-gray-100 rounded-full overflow-hidden">
                        <div class="h-full rounded-full transition-all duration-500"
                            style="width: {{ $percent }}%; background-color: {{ $barColor }}">
                        </div>
                    </div>
                    <span class="text-[11px] font-semibold w-9 text-right shrink-0"
                        style="color: {{ $barColor }}">
                        {{ $percent }}%
                    </span>
                </div>

                {{-- Status --}}
                <div>
                    @if($record->status == 2)
                        <span class="inline-flex items-center gap-1.5 text-[10.5px] font-bold px-2.5 py-1 rounded-lg bg-emerald-50 text-emerald-700 border border-emerald-100">
                            <svg xmlns="http://www.w3.org/2000/svg" height="10px" viewBox="0 -960 960 960" width="10px" fill="currentColor">
                                <path d="m424-296 282-282-56-56-226 226-114-114-56 56 170 170Z"/>
                            </svg>
                            Completed
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 text-[10.5px] font-bold px-2.5 py-1 rounded-lg bg-amber-50 text-amber-700 border border-amber-100">
                            <svg xmlns="http://www.w3.org/2000/svg" height="10px" viewBox="0 -960 960 960" width="10px" fill="currentColor">
                                <path d="M480-80q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-400Zm-40 200h80v-240h-80v240Z"/>
                            </svg>
                            In Progress
                        </span>
                    @endif
                </div>

                {{-- Revise button --}}
                <div>
                    <a href="/start-quiz/{{ $record->quiz_id }}/{{ $record->name }}"
                        class="inline-flex items-center gap-1.5 text-[11.5px] font-bold px-3.5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white transition-all duration-150 group-hover:-translate-y-px">
                        Revise
                        <svg xmlns="http://www.w3.org/2000/svg" height="11px" viewBox="0 -960 960 960" width="11px" fill="currentColor">
                            <path d="M160-160v-80h110l-16-14q-52-46-73-105t-21-119q0-111 66.5-197.5T400-790v84q-72 26-116 88.5T240-478q0 45 15 87t45 75l20 16v-120h80v240H160Zm400-10v-84q72-26 116-88.5T720-482q0-45-15-87t-45-75l-20-16v120h-80v-240h240v80H690l16 14q52 46 73 105t21 119q0 111-66.5 197.5T560-170Z"/>
                        </svg>
                    </a>
                </div>

            </div>
            @endforeach
        </div>

        @else

        {{-- ── Empty state ── --}}
        <div class="bg-white border border-gray-200 rounded-2xl px-6 py-16 text-center shadow-sm">
            <div class="w-14 h-14 rounded-2xl bg-emerald-50 border border-emerald-100 flex items-center justify-center mx-auto mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#059669">
                    <path d="M160-400q-17 0-28.5-11.5T120-440v-80q0-17 11.5-28.5T160-560h640q17 0 28.5 11.5T840-520v80q0 17-11.5 28.5T800-400H160Zm0-240q-17 0-28.5-11.5T120-680v-80q0-17 11.5-28.5T160-800h640q17 0 28.5 11.5T840-760v80q0 17-11.5 28.5T800-640H160Zm0 480q-17 0-28.5-11.5T120-200v-80q0-17 11.5-28.5T160-320h640q17 0 28.5 11.5T840-280v80q0 17-11.5 28.5T800-160H160Z"/>
                </svg>
            </div>
            <p class="text-slate-700 text-sm font-semibold mb-1">No quiz history yet</p>
            <p class="text-slate-400 text-xs leading-relaxed max-w-xs mx-auto">
                You haven't attempted any quizzes yet. Start one to see your history here.
            </p>
            <a href="/"
                class="inline-flex items-center gap-2 mt-5 text-xs font-bold bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 rounded-xl transition-all duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" height="13px" viewBox="0 -960 960 960" width="13px" fill="currentColor">
                    <path d="M320-200v-560l440 280-440 280Z"/>
                </svg>
                Browse Quizzes
            </a>
        </div>

        @endif

    </main>

    <x-footer-user></x-footer-user>
</body>
</html>