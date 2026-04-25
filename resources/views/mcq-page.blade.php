<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ str_replace('-', ' ', $quizName) }} — Question — Quiz System</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-[#f8faf8] min-h-screen flex flex-col">
    <x-user-navbar></x-user-navbar>

    @php
        $current       = session('currentQuiz')['currentMcq'];
        $total         = session('currentQuiz')['totalMcq'];
        $percent       = $total > 0 ? round(($current / $total) * 100) : 0;
        $isFirst       = $current <= 1;
        $isLast        = $current >= $total;
        $answered      = $previousAnswer ?? null;
        $answeredCount = session('currentQuiz')['answeredCount'] ?? 0;

        // A question is "skipped" only if it was previously visited AND has no answer
        $visitedMcqs  = session('currentQuiz')['visitedMcqs']  ?? [];
        $skippedMcqs  = session('currentQuiz')['skippedMcqs']  ?? [];
        $answeredMcqs = session('currentQuiz')['answeredMcqs'] ?? [];
        $wasVisited   = in_array($current, $visitedMcqs);
        $wasSkipped   = in_array($current, $skippedMcqs);
        $showSkippedNote = $wasVisited && $wasSkipped && $answered === null;

        if (!function_exists('superscript')) {
            function superscript(string $text): string {
                return preg_replace(
                    '/([A-Za-z0-9\)\]])\^([A-Za-z0-9\+\-]+)/',
                    '$1<sup>$2</sup>',
                    e($text)
                );
            }
        }

        $options = [
            'a' => ['id' => 'option_1', 'label' => 'A'],
            'b' => ['id' => 'option_2', 'label' => 'B'],
            'c' => ['id' => 'option_3', 'label' => 'C'],
            'd' => ['id' => 'option_4', 'label' => 'D'],
        ];
    @endphp

    <main class="flex-1 max-w-2xl mx-auto w-full px-4 py-8">

        {{-- ── Quiz header ── --}}
        <div class="text-center mb-6">

            <div class="inline-flex items-center gap-2 bg-emerald-50 text-emerald-700 text-[11px] font-bold px-3 py-1.5 rounded-full border border-emerald-100 mb-4 uppercase tracking-wider">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                {{ str_replace('-', ' ', $quizName) }}
            </div>

            <h1 class="text-emerald-950 text-[1.6rem] font-extrabold tracking-tight mb-1">
                Question <span class="text-emerald-600">{{ $current }}</span>
                <span class="text-gray-200 font-light mx-1">/</span>
                <span class="text-slate-400 font-medium text-xl">{{ $total }}</span>
            </h1>

            {{-- Progress bar --}}
            <div class="mt-3 max-w-xs mx-auto">
                <div class="w-full h-2 bg-gray-100 rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-emerald-500 to-emerald-400 rounded-full transition-all duration-500 ease-out"
                        style="width: {{ $percent }}%"></div>
                </div>
                <div class="flex items-center justify-between mt-1.5">
                    <span class="text-slate-400 text-[10.5px]">{{ $percent }}% complete</span>
                    <span class="text-slate-400 text-[10.5px]">{{ $answeredCount }} of {{ $total }} answered</span>
                </div>
            </div>
        </div>

        {{-- ── Question navigator ── --}}
        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden mb-4">
            <div class="px-4 py-3 border-b border-gray-100 flex items-center justify-between flex-wrap gap-2">
                <p class="text-[10.5px] font-bold text-slate-400 uppercase tracking-widest">Navigator</p>
                <div class="flex items-center gap-3 flex-wrap">
                    <span class="inline-flex items-center gap-1.5 text-[10px] font-medium text-emerald-700">
                        <span class="w-2.5 h-2.5 rounded-sm bg-emerald-500 inline-block"></span>Answered
                    </span>
                    <span class="inline-flex items-center gap-1.5 text-[10px] font-medium text-amber-600">
                        <span class="w-2.5 h-2.5 rounded-sm bg-amber-200 border border-amber-300 inline-block"></span>Skipped
                    </span>
                    <span class="inline-flex items-center gap-1.5 text-[10px] font-medium text-slate-400">
                        <span class="w-2.5 h-2.5 rounded-sm bg-slate-100 border border-gray-200 inline-block"></span>Not visited
                    </span>
                </div>
            </div>
            <div class="px-4 py-3 flex flex-wrap gap-1.5">
                @for($i = 1; $i <= $total; $i++)
                    @php
                        $isCurrent  = ($i === $current);
                        $isAnsweredQ = in_array($i, $answeredMcqs);
                        $isSkippedQ  = in_array($i, $skippedMcqs);
                    @endphp
                    <span title="Question {{ $i }}"
                        class="w-7 h-7 rounded-lg text-[10.5px] font-bold flex items-center justify-center border transition-all duration-150 select-none
                            @if($isCurrent)    bg-emerald-600 text-white border-emerald-600 shadow-sm scale-110
                            @elseif($isAnsweredQ) bg-emerald-50 text-emerald-700 border-emerald-200
                            @elseif($isSkippedQ)  bg-amber-50 text-amber-600 border-amber-200
                            @else                  bg-white text-slate-300 border-gray-100
                            @endif">
                        {{ $i }}
                    </span>
                @endfor
            </div>
        </div>

        {{-- ── MCQ card ── --}}
        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">

            {{-- Question section --}}
            <div class="px-6 py-5 border-b border-gray-100">
                <div class="flex items-center gap-2 mb-3">
                    <span class="text-[10.5px] font-bold text-slate-400 uppercase tracking-widest">Question</span>
                    <span class="text-[10px] font-bold bg-emerald-50 text-emerald-600 border border-emerald-100 px-2 py-0.5 rounded-md">
                        Q{{ $current }}
                    </span>
                </div>
                <h2 class="text-slate-800 text-[15px] font-medium leading-[1.75]">
                    {!! superscript($mcqData->question) !!}
                </h2>
            </div>

            {{-- Skipped notice — only shown when user previously visited AND skipped this question --}}
            @if($showSkippedNote)
                <div class="mx-5 mt-4 bg-amber-50 border border-amber-200 rounded-xl px-4 py-2.5 flex items-center gap-2.5">
                    <svg xmlns="http://www.w3.org/2000/svg" height="14px" viewBox="0 -960 960 960" width="14px" fill="#d97706" class="shrink-0">
                        <path d="M480-280q17 0 28.5-11.5T520-320q0-17-11.5-28.5T480-360q-17 0-28.5 11.5T440-320q0 17 11.5 28.5T480-280Zm-40-160h80v-240h-80v240Zm40 360q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Z"/>
                    </svg>
                    <p class="text-amber-700 text-[12px] font-medium">You skipped this question — you can still answer it now before submitting.</p>
                </div>
            @endif

            {{-- Options --}}
            <div class="px-5 py-5 space-y-2.5" id="options-wrapper">
                <input type="hidden" name="id" value="{{ $mcqData->id }}">

                @foreach($options as $val => $opt)
                    @php $isSelected = ($answered === $val); @endphp
                    <label for="{{ $opt['id'] }}"
                        class="option-label flex items-center gap-3.5 border px-4 py-3.5 rounded-xl cursor-pointer transition-all duration-150 group
                            {{ $isSelected ? 'border-emerald-400 bg-emerald-50/70' : 'border-gray-200 hover:border-emerald-200 hover:bg-emerald-50/20' }}"
                        data-value="{{ $val }}">

                        <input
                            id="{{ $opt['id'] }}"
                            type="radio"
                            name="option"
                            value="{{ $val }}"
                            {{ $isSelected ? 'checked' : '' }}
                            class="w-4 h-4 accent-emerald-600 cursor-pointer shrink-0">

                        <span class="option-letter w-7 h-7 rounded-lg text-[11px] font-extrabold flex items-center justify-center shrink-0 transition-colors duration-150
                            {{ $isSelected ? 'bg-emerald-500 text-white' : 'bg-slate-100 text-slate-500 group-hover:bg-emerald-100 group-hover:text-emerald-700' }}">
                            {{ $opt['label'] }}
                        </span>

                        <span class="text-slate-700 text-[13.5px] leading-relaxed flex-1">
                            {!! superscript($mcqData->$val) !!}
                        </span>

                        {{-- Selected checkmark --}}
                        @if($isSelected)
                            <svg xmlns="http://www.w3.org/2000/svg" height="16px" viewBox="0 -960 960 960" width="16px" fill="#059669" class="shrink-0 selected-check">
                                <path d="m424-296 282-282-56-56-226 226-114-114-56 56 170 170Zm56 216q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Z"/>
                            </svg>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" height="16px" viewBox="0 -960 960 960" width="16px" fill="#059669" class="shrink-0 selected-check hidden">
                                <path d="m424-296 282-282-56-56-226 226-114-114-56 56 170 170Zm56 216q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Z"/>
                            </svg>
                        @endif
                    </label>
                @endforeach
            </div>

            {{-- ── Footer ── --}}
            <div class="px-5 py-4 bg-slate-50 border-t border-gray-100 flex items-center justify-between gap-3">

                {{-- Previous --}}
                @if(!$isFirst)
                    <form action="/previous-mcq/{{ $mcqData->id }}" method="post" id="form-previous">
                        @csrf
                        <input type="hidden" name="option" id="hidden-option-prev" value="{{ $answered }}">
                        <button type="submit"
                            class="inline-flex items-center gap-1.5 border border-gray-200 hover:border-gray-300 hover:bg-white text-slate-600 text-[12.5px] font-semibold px-5 py-2.5 rounded-xl transition-all duration-150 cursor-pointer bg-white">
                            <svg xmlns="http://www.w3.org/2000/svg" height="13px" viewBox="0 -960 960 960" width="13px" fill="currentColor">
                                <path d="M456-480 640-664l-56-56-240 240 240 240 56-56-184-184Z"/>
                            </svg>
                            Previous
                        </button>
                    </form>
                @else
                    <span></span>
                @endif

                {{-- Middle: skip hint OR answered badge --}}
                <div class="flex-1 text-center">
                    @if($answered)
                        <span class="inline-flex items-center gap-1.5 text-[10.5px] font-semibold text-emerald-700 bg-emerald-50 border border-emerald-100 px-2.5 py-1 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" height="11px" viewBox="0 -960 960 960" width="11px" fill="currentColor">
                                <path d="m424-296 282-282-56-56-226 226-114-114-56 56 170 170Z"/>
                            </svg>
                            Answered
                        </span>
                    @elseif(!$isLast)
                        <form action="/submit-next/{{ $mcqData->id }}" method="post" id="form-skip" class="inline">
                            @csrf
                            <input type="hidden" name="option" value="">
                            <button type="submit" id="skip-btn"
                                class="text-slate-400 hover:text-amber-600 text-[12px] font-semibold transition-colors duration-150 cursor-pointer underline underline-offset-2 decoration-dashed">
                                Skip this question
                            </button>
                        </form>
                    @endif
                </div>

                {{-- Next / Submit --}}
                @if(!$isLast)
                    <form action="/submit-next/{{ $mcqData->id }}" method="post" id="form-next">
                        @csrf
                        <input type="hidden" name="option" id="hidden-option-next" value="{{ $answered }}">
                        <button type="submit"
                            class="inline-flex items-center gap-1.5 bg-emerald-600 hover:bg-emerald-700 text-white text-[13px] font-bold px-6 py-2.5 rounded-xl transition-all duration-150 cursor-pointer">
                            Next
                            <svg xmlns="http://www.w3.org/2000/svg" height="13px" viewBox="0 -960 960 960" width="13px" fill="currentColor">
                                <path d="M504-480 320-664l56-56 240 240-240 240-56-56 184-184Z"/>
                            </svg>
                        </button>
                    </form>
                @else
                    <form action="/submit-next/{{ $mcqData->id }}" method="post" id="form-next">
                        @csrf
                        <input type="hidden" name="option" id="hidden-option-next" value="{{ $answered }}">
                        <button type="submit"
                            class="inline-flex items-center gap-1.5 bg-emerald-700 hover:bg-emerald-800 text-white text-[13px] font-bold px-6 py-2.5 rounded-xl transition-all duration-150 cursor-pointer ring-2 ring-emerald-300 ring-offset-1">
                            <svg xmlns="http://www.w3.org/2000/svg" height="13px" viewBox="0 -960 960 960" width="13px" fill="currentColor">
                                <path d="m424-296 282-282-56-56-226 226-114-114-56 56 170 170Zm56 216q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Z"/>
                            </svg>
                            Submit Quiz
                        </button>
                    </form>
                @endif

            </div>
        </div>

    </main>

    <x-footer-user></x-footer-user>

    <script>
        const radios   = document.querySelectorAll('#options-wrapper input[type="radio"]');
        const hidPrev  = document.getElementById('hidden-option-prev');
        const hidNext  = document.getElementById('hidden-option-next');
        const skipBtn  = document.getElementById('skip-btn');
        const labels   = document.querySelectorAll('.option-label');

        function updateStyles(selectedValue) {
            labels.forEach(label => {
                const val    = label.dataset.value;
                const chosen = (val === selectedValue);
                const letter = label.querySelector('.option-letter');
                const check  = label.querySelector('.selected-check');

                // Border & background
                label.classList.toggle('border-emerald-400', chosen);
                label.classList.toggle('bg-emerald-50/70',   chosen);
                label.classList.toggle('border-gray-200',    !chosen);

                // Letter badge
                if (letter) {
                    letter.classList.toggle('bg-emerald-500', chosen);
                    letter.classList.toggle('text-white',     chosen);
                    letter.classList.toggle('bg-slate-100',   !chosen);
                    letter.classList.toggle('text-slate-500', !chosen);
                }

                // Checkmark icon
                if (check) {
                    check.classList.toggle('hidden', !chosen);
                }
            });
        }

        radios.forEach(radio => {
            radio.addEventListener('change', () => {
                const val = radio.value;

                if (hidPrev) hidPrev.value = val;
                if (hidNext) hidNext.value = val;

                // Hide skip, show answered badge
                if (skipBtn) skipBtn.closest('form').style.display = 'none';

                const midZone = skipBtn ? skipBtn.closest('form').parentElement : null;
                if (midZone) {
                    const badge = document.createElement('span');
                    badge.className = 'inline-flex items-center gap-1.5 text-[10.5px] font-semibold text-emerald-700 bg-emerald-50 border border-emerald-100 px-2.5 py-1 rounded-full';
                    badge.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" height="11px" viewBox="0 -960 960 960" width="11px" fill="currentColor"><path d="m424-296 282-282-56-56-226 226-114-114-56 56 170 170Z"/></svg> Answered`;
                    if (!midZone.querySelector('.answered-badge')) {
                        badge.classList.add('answered-badge');
                        midZone.appendChild(badge);
                    }
                }

                updateStyles(val);
            });
        });
    </script>
</body>
</html>