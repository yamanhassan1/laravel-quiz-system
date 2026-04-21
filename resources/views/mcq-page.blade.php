<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MCQ Page — Quiz System</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">
    <x-user-navbar></x-user-navbar>

    <main class="flex-1 max-w-2xl mx-auto w-full px-6 py-10">

        {{-- Compute progress once --}}
        @php
            $current = session('currentQuiz')['currentMcq'];
            $total   = session('currentQuiz')['totalMcq'];
            $percent = $total > 0 ? round(($current / $total) * 100) : 0;
            $isFirst = $current <= 1;
            $isLast  = $current >= $total;
        @endphp

        {{-- Quiz header --}}
        <div class="mb-8 text-center">
            <div class="inline-flex items-center gap-2 bg-emerald-50 text-emerald-700 text-xs font-semibold px-3 py-1.5 rounded-full mb-4 border border-emerald-100">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                {{$quizName}}
            </div>
            <h1 class="text-emerald-950 text-2xl font-bold tracking-tight">
                Question <span class="text-emerald-600">{{$current}}</span>
                <span class="text-slate-300">/</span>
                <span class="text-slate-400 font-medium text-xl">{{$total}}</span>
            </h1>

            {{-- Progress bar --}}
            <div class="mt-4 max-w-xs mx-auto">
                <div class="w-full h-1.5 bg-gray-200 rounded-full overflow-hidden">
                    <div class="h-full bg-emerald-500 rounded-full transition-all duration-300"
                        style="width: {{$percent}}%"></div>
                </div>
                <p class="text-slate-400 text-xs mt-1.5">{{$percent}}% complete</p>
            </div>
        </div>

        {{-- MCQ card --}}
        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">

            {{-- Question --}}
            <div class="px-8 py-6 border-b border-gray-100">
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide mb-3">Question</p>
                <h2 class="text-slate-800 text-base font-medium leading-relaxed">
                    {{$mcqData->question}}
                </h2>
            </div>

            {{-- Options (shared — JS copies selected value to both forms on submit) --}}
            <div class="px-8 py-6 space-y-3" id="options-wrapper">
                    <input type="hidden", name='id' value="{{$mcqData->id}}">
                <label for="option_1"
                    class="flex items-center gap-4 border border-gray-200 hover:border-emerald-400 hover:bg-emerald-50/40 px-4 py-3.5 rounded-xl cursor-pointer transition-all duration-150 group">
                    <input id="option_1" type="radio" name="option" value="a"
                        class="w-4 h-4 accent-emerald-600 cursor-pointer shrink-0">
                    <span class="w-7 h-7 rounded-lg bg-emerald-50 text-emerald-700 text-xs font-bold flex items-center justify-center shrink-0 group-hover:bg-emerald-100 transition-colors duration-150">A</span>
                    <span class="text-slate-700 text-sm">{{$mcqData->a}}</span>
                </label>

                <label for="option_2"
                    class="flex items-center gap-4 border border-gray-200 hover:border-emerald-400 hover:bg-emerald-50/40 px-4 py-3.5 rounded-xl cursor-pointer transition-all duration-150 group">
                    <input id="option_2" type="radio" name="option" value="b"
                        class="w-4 h-4 accent-emerald-600 cursor-pointer shrink-0">
                    <span class="w-7 h-7 rounded-lg bg-emerald-50 text-emerald-700 text-xs font-bold flex items-center justify-center shrink-0 group-hover:bg-emerald-100 transition-colors duration-150">B</span>
                    <span class="text-slate-700 text-sm">{{$mcqData->b}}</span>
                </label>

                <label for="option_3"
                    class="flex items-center gap-4 border border-gray-200 hover:border-emerald-400 hover:bg-emerald-50/40 px-4 py-3.5 rounded-xl cursor-pointer transition-all duration-150 group">
                    <input id="option_3" type="radio" name="option" value="c"
                        class="w-4 h-4 accent-emerald-600 cursor-pointer shrink-0">
                    <span class="w-7 h-7 rounded-lg bg-emerald-50 text-emerald-700 text-xs font-bold flex items-center justify-center shrink-0 group-hover:bg-emerald-100 transition-colors duration-150">C</span>
                    <span class="text-slate-700 text-sm">{{$mcqData->c}}</span>
                </label>

                <label for="option_4"
                    class="flex items-center gap-4 border border-gray-200 hover:border-emerald-400 hover:bg-emerald-50/40 px-4 py-3.5 rounded-xl cursor-pointer transition-all duration-150 group">
                    <input id="option_4" type="radio" name="option" value="d"
                        class="w-4 h-4 accent-emerald-600 cursor-pointer shrink-0">
                    <span class="w-7 h-7 rounded-lg bg-emerald-50 text-emerald-700 text-xs font-bold flex items-center justify-center shrink-0 group-hover:bg-emerald-100 transition-colors duration-150">D</span>
                    <span class="text-slate-700 text-sm">{{$mcqData->d}}</span>
                </label>

            </div>

            {{-- Footer: two separate forms side by side --}}
            <div class="px-8 py-5 bg-slate-50 border-t border-gray-100 flex items-center justify-between gap-4">

                {{-- Previous form --}}
                @if(!$isFirst)
                    <form action="/previous-mcq/{{$mcqData->id}}" method="post" id="form-previous">
                        @csrf
                        <input type="hidden" name="option" id="hidden-option-prev">
                        <button type="submit"
                            class="inline-flex items-center gap-2 border border-gray-200 hover:border-gray-300 hover:bg-white text-slate-600 text-sm font-medium px-5 py-2.5 rounded-xl transition-all duration-150 cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" height="14px" viewBox="0 -960 960 960" width="14px" fill="currentColor"><path d="M456-480 640-664l-56-56-240 240 240 240 56-56-184-184Z"/></svg>
                            Previous
                        </button>
                    </form>
                @else
                    <span></span>
                @endif

                {{-- Next / Submit form --}}
                <form action="/submit-next/{{$mcqData->id}}" method="post" id="form-next">
                    @csrf
                    <input type="hidden" name="option" id="hidden-option-next">

                    @if(!$isLast)
                        <button type="submit"
                            class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold px-6 py-2.5 rounded-xl transition-all duration-150 cursor-pointer">
                            Next
                            <svg xmlns="http://www.w3.org/2000/svg" height="14px" viewBox="0 -960 960 960" width="14px" fill="currentColor"><path d="M504-480 320-664l56-56 240 240-240 240-56-56 184-184Z"/></svg>
                        </button>
                    @else
                        <button type="submit"
                            class="inline-flex items-center gap-2 bg-emerald-700 hover:bg-emerald-800 text-white text-sm font-semibold px-6 py-2.5 rounded-xl transition-all duration-150 cursor-pointer ring-2 ring-emerald-300">
                            <svg xmlns="http://www.w3.org/2000/svg" height="14px" viewBox="0 -960 960 960" width="14px" fill="currentColor"><path d="m424-296 282-282-56-56-226 226-114-114-56 56 170 170Zm56 216q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Z"/></svg>
                            Submit Quiz
                        </button>
                    @endif
                </form>

            </div>
        </div>

    </main>

    <x-footer-user></x-footer-user>

    {{-- Sync the selected radio into whichever form is submitted --}}
    <script>
        const radios  = document.querySelectorAll('#options-wrapper input[type="radio"]');
        const hidPrev = document.getElementById('hidden-option-prev');
        const hidNext = document.getElementById('hidden-option-next');

        radios.forEach(radio => {
            radio.addEventListener('change', () => {
                if (hidPrev) hidPrev.value = radio.value;
                if (hidNext) hidNext.value = radio.value;
            });
        });
    </script>
</body>
</html>