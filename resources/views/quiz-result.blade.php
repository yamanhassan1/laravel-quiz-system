<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Result — {{ $quizName }} — Quiz System</title>
    @vite('resources/css/app.css')
    <style>
        @media print {
            .no-print { display: none !important; }
            body { background: white; }
            .print-shadow { box-shadow: none !important; }
        }
    </style>
</head>
<body class="bg-[#f8faf8] min-h-screen flex flex-col">
    <div class="no-print">
        <x-user-navbar></x-user-navbar>
    </div>

    @php
        $total      = count($resultData);
        $skipped    = $resultData->whereNull('select_answer')->count();
        $incorrect  = $total - $correctAnswers - $skipped;
        $percentage = $total > 0 ? round(($correctAnswers / $total) * 100) : 0;
        $passed     = $percentage >= 60;

        // SVG ring calculation (circumference = 2 * pi * 40 = ~251.2)
        $circumference = 251.2;
        $dashOffset    = $circumference - ($circumference * $percentage / 100);
    @endphp

    {{-- ── Hero / Score section ── --}}
    <section class="bg-white border-b border-gray-100 print-shadow">
        <div class="max-w-3xl mx-auto px-6 pt-10 pb-8 text-center">

            {{-- Status badge --}}
            <div class="inline-flex items-center gap-2 text-[11px] font-bold px-3 py-1.5 rounded-full border mb-5 uppercase tracking-wider
                {{ $passed ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-red-50 text-red-600 border-red-200' }}">
                <span class="w-1.5 h-1.5 rounded-full {{ $passed ? 'bg-emerald-500' : 'bg-red-400' }}"></span>
                Quiz Completed
            </div>

            <p class="text-slate-400 text-xs font-semibold uppercase tracking-widest mb-1">{{ $quizName }}</p>
            <h1 class="text-emerald-950 text-2xl font-extrabold tracking-tight mb-6">Here's how you did</h1>

            {{-- Score ring --}}
            <div class="relative w-28 h-28 mx-auto mb-5">
                <svg class="w-full h-full -rotate-90" viewBox="0 0 100 100">
                    <circle cx="50" cy="50" r="40" fill="none" stroke="#f1f5f1" stroke-width="10"/>
                    <circle cx="50" cy="50" r="40" fill="none"
                        stroke="{{ $passed ? '#059669' : '#ef4444' }}"
                        stroke-width="10"
                        stroke-linecap="round"
                        stroke-dasharray="{{ $circumference }}"
                        stroke-dashoffset="{{ $dashOffset }}"
                        style="transition: stroke-dashoffset 1s ease-out"/>
                </svg>
                <div class="absolute inset-0 flex flex-col items-center justify-center">
                    <span class="text-xl font-extrabold {{ $passed ? 'text-emerald-700' : 'text-red-500' }}">
                        {{ $percentage }}%
                    </span>
                    <span class="text-[9px] text-slate-400 font-bold uppercase tracking-wide">Score</span>
                </div>
            </div>

            {{-- Pass / Fail badge --}}
            <div class="inline-flex items-center gap-2 text-[13px] font-bold px-5 py-2 rounded-full mb-6
                {{ $passed
                    ? 'bg-emerald-100 text-emerald-800'
                    : 'bg-red-100 text-red-700' }}">
                @if($passed)
                    <svg xmlns="http://www.w3.org/2000/svg" height="15px" viewBox="0 -960 960 960" width="15px" fill="currentColor">
                        <path d="m424-296 282-282-56-56-226 226-114-114-56 56 170 170Z"/>
                    </svg>
                    Passed — Well done!
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" height="15px" viewBox="0 -960 960 960" width="15px" fill="currentColor">
                        <path d="M480-280q17 0 28.5-11.5T520-320q0-17-11.5-28.5T480-360q-17 0-28.5 11.5T440-320q0 17 11.5 28.5T480-280Zm-40-160h80v-240h-80v240Z"/>
                    </svg>
                    Not passed — Keep practising!
                @endif
            </div>

            {{-- Stat cards --}}
            <div class="flex justify-center gap-3 flex-wrap">
                @foreach([
                    ['num' => $correctAnswers, 'label' => 'Correct',   'color' => 'text-emerald-600'],
                    ['num' => $incorrect,      'label' => 'Incorrect',  'color' => 'text-red-500'],
                    ['num' => $skipped,        'label' => 'Skipped',    'color' => 'text-amber-500'],
                    ['num' => $total,          'label' => 'Total',      'color' => 'text-slate-600'],
                ] as $stat)
                <div class="bg-slate-50 border border-gray-200 rounded-2xl px-5 py-3 text-center min-w-[80px]">
                    <p class="text-xl font-extrabold {{ $stat['color'] }}">{{ $stat['num'] }}</p>
                    <p class="text-[10.5px] text-slate-400 mt-0.5">{{ $stat['label'] }}</p>
                </div>
                @endforeach
            </div>

        </div>
    </section>

    {{-- ── Detailed breakdown ── --}}
    <main class="flex-1 max-w-4xl mx-auto w-full px-6 py-8">

        <div class="flex items-center justify-between mb-4">
            <p class="text-slate-700 text-[13px] font-bold">Detailed breakdown</p>
            <span class="text-slate-400 text-xs bg-slate-100 px-3 py-1 rounded-full font-semibold">{{ $total }} questions</span>
        </div>

        <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-sm print-shadow">

            {{-- Table header --}}
            <div class="grid grid-cols-[36px_1fr_180px_100px] gap-2 bg-slate-50 border-b border-gray-100 px-5 py-3">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">#</span>
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Question</span>
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Your answer</span>
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Result</span>
            </div>

            {{-- Rows --}}
            @foreach($resultData as $key => $item)
            @php
                $isCorrect = (bool) $item->is_correct;
                $isSkipped = is_null($item->select_answer);
                $correctAns = $item->mcq->correct_ans ?? null;

                // Map a/b/c/d to the actual text of the correct option
                $correctText = match($correctAns) {
                    'a' => $item->mcq->a ?? null,
                    'b' => $item->mcq->b ?? null,
                    'c' => $item->mcq->c ?? null,
                    'd' => $item->mcq->d ?? null,
                    default => null,
                };

                // Map selected answer letter to text
                $selectedText = match($item->select_answer) {
                    'a' => $item->mcq->a ?? null,
                    'b' => $item->mcq->b ?? null,
                    'c' => $item->mcq->c ?? null,
                    'd' => $item->mcq->d ?? null,
                    default => null,
                };
            @endphp
            <div class="grid grid-cols-[36px_1fr_180px_100px] gap-2 px-5 py-4 items-start border-b border-gray-50 hover:bg-slate-50/60 transition-colors duration-100
                {{ $loop->last ? 'border-b-0' : '' }}
                {{ $isCorrect ? '' : ($isSkipped ? 'bg-amber-50/20' : 'bg-red-50/20') }}">

                {{-- # --}}
                <span class="text-[11px] font-semibold text-slate-300 mt-0.5">
                    {{ str_pad($key + 1, 2, '0', STR_PAD_LEFT) }}
                </span>

                {{-- Question + correct answer hint --}}
                <div>
                    <p class="text-slate-700 text-[13px] leading-relaxed">{{ $item->question }}</p>
                    @if(!$isCorrect && !$isSkipped && $correctText)
                        <p class="text-emerald-600 text-[11px] mt-1.5 flex items-center gap-1 font-medium">
                            <svg xmlns="http://www.w3.org/2000/svg" height="11px" viewBox="0 -960 960 960" width="11px" fill="currentColor">
                                <path d="m424-296 282-282-56-56-226 226-114-114-56 56 170 170Z"/>
                            </svg>
                            Correct: {{ $correctText }}
                        </p>
                    @endif
                    @if($isSkipped && $correctText)
                        <p class="text-slate-500 text-[11px] mt-1.5 flex items-center gap-1 font-medium">
                            <svg xmlns="http://www.w3.org/2000/svg" height="11px" viewBox="0 -960 960 960" width="11px" fill="currentColor">
                                <path d="m424-296 282-282-56-56-226 226-114-114-56 56 170 170Z"/>
                            </svg>
                            Answer: {{ $correctText }}
                        </p>
                    @endif
                </div>

                {{-- Selected answer text --}}
                <div class="mt-0.5">
                    @if($isSkipped)
                        <span class="text-amber-500 text-[12px] font-medium italic">Not answered</span>
                    @else
                        <span class="text-[12.5px] font-semibold {{ $isCorrect ? 'text-emerald-700' : 'text-red-500' }}">
                            {{ $selectedText ?? $item->select_answer }}
                        </span>
                    @endif
                </div>

                {{-- Result badge --}}
                <div class="mt-0.5">
                    @if($isSkipped)
                        <span class="inline-flex items-center gap-1 bg-amber-50 text-amber-600 border border-amber-100 text-[10.5px] font-bold px-2.5 py-1 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" height="10px" viewBox="0 -960 960 960" width="10px" fill="currentColor">
                                <path d="M504-480 320-664l56-56 240 240-240 240-56-56 184-184Z"/>
                            </svg>
                            Skipped
                        </span>
                    @elseif($isCorrect)
                        <span class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-700 border border-emerald-100 text-[10.5px] font-bold px-2.5 py-1 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" height="10px" viewBox="0 -960 960 960" width="10px" fill="currentColor">
                                <path d="m424-296 282-282-56-56-226 226-114-114-56 56 170 170Z"/>
                            </svg>
                            Correct
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1 bg-red-50 text-red-600 border border-red-100 text-[10.5px] font-bold px-2.5 py-1 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" height="10px" viewBox="0 -960 960 960" width="10px" fill="currentColor">
                                <path d="M480-280q17 0 28.5-11.5T520-320q0-17-11.5-28.5T480-360q-17 0-28.5 11.5T440-320q0 17 11.5 28.5T480-280Zm-40-160h80v-240h-80v240Z"/>
                            </svg>
                            Wrong
                        </span>
                    @endif
                </div>

            </div>
            @endforeach
        </div>

        {{-- ── Action buttons ── --}}
        <div class="flex items-center justify-center gap-3 mt-7 flex-wrap no-print">

            <a href="/"
                class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white text-[13px] font-bold px-6 py-2.5 rounded-xl transition-all duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" height="14px" viewBox="0 -960 960 960" width="14px" fill="currentColor">
                    <path d="M240-200h120v-240h240v240h120v-360L480-740 240-560v360Zm-80 80v-480l320-240 320 240v480H520v-240h-80v240H160Zm320-350Z"/>
                </svg>
                Back to Home
            </a>

            <button onclick="window.print()"
                class="inline-flex items-center gap-2 bg-white hover:bg-slate-50 border border-gray-200 hover:border-gray-300 text-slate-600 text-[13px] font-semibold px-6 py-2.5 rounded-xl transition-all duration-150 cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" height="14px" viewBox="0 -960 960 960" width="14px" fill="currentColor">
                    <path d="M640-640v-120H320v120h-80v-200h480v200h-80ZM160-560h640-640Zm480 100q17 0 28.5-11.5T680-500q0-17-11.5-28.5T640-540q-17 0-28.5 11.5T600-500q0 17 11.5 28.5T640-460Zm-80 260v-160H400v160h160Zm80 80H320v-160H160v-320h640v320H640v160Zm-480-240h480-480Z"/>
                </svg>
                Print Results
            </button>

            <a href="javascript:history.back()"
                class="inline-flex items-center gap-2 bg-white hover:bg-slate-50 border border-gray-200 hover:border-gray-300 text-slate-600 text-[13px] font-semibold px-6 py-2.5 rounded-xl transition-all duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" height="14px" viewBox="0 -960 960 960" width="14px" fill="currentColor">
                    <path d="M320-200v-560l440 280-440 280Z"/>
                </svg>
                Try Again
            </a>

        </div>
    </main>

    <div class="no-print">
        <x-footer-user></x-footer-user>
    </div>
</body>
</html>