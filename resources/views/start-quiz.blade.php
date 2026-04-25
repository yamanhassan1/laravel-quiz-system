<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$quizName}} — Quiz System</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-[#f8faf8] min-h-screen flex flex-col">
    <x-user-navbar></x-user-navbar>

    {{-- ── Success flash ── --}}
    @if(session('message-success'))
        <div class="w-full bg-emerald-50 border-b border-emerald-200 px-6 py-3">
            <div class="max-w-5xl mx-auto flex items-center gap-2 text-emerald-700 text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" height="15px" viewBox="0 -960 960 960" width="15px" fill="currentColor">
                    <path d="m424-296 282-282-56-56-226 226-114-114-56 56 170 170Zm56 216q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Z"/>
                </svg>
                {{ session('message-success') }}
            </div>
        </div>
    @endif

    <main class="flex-1 flex items-center justify-center px-4 py-12">
        <div class="w-full max-w-120">

            <div class="bg-white border border-gray-200 rounded-[20px] overflow-hidden shadow-sm">

                {{-- ── Card header ── --}}
                <div class="bg-emerald-50 border-b border-emerald-100 px-8 pt-7 pb-6 text-center">

                    {{-- Logo --}}
                    <div class="flex items-center justify-center gap-2 mb-5">
                        <div class="w-7 h-7 rounded-lg bg-emerald-600 flex items-center justify-center shrink-0">
                            <svg width="13" height="13" viewBox="0 0 14 14" fill="none">
                                <path d="M7 1L9.5 5.5H12.5L10 8.5L11 12.5L7 10.5L3 12.5L4 8.5L1.5 5.5H4.5L7 1Z" fill="white"/>
                            </svg>
                        </div>
                        <span class="text-emerald-900 font-semibold text-[15px] tracking-tight">Quiz System</span>
                    </div>

                    {{-- Quiz icon --}}
                    <div class="w-13 h-13 rounded-2xl bg-white border border-emerald-200 flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#059669">
                            <path d="M160-400q-17 0-28.5-11.5T120-440v-80q0-17 11.5-28.5T160-560h640q17 0 28.5 11.5T840-520v80q0 17-11.5 28.5T800-400H160Zm0-240q-17 0-28.5-11.5T120-680v-80q0-17 11.5-28.5T160-800h640q17 0 28.5 11.5T840-760v80q0 17-11.5 28.5T800-640H160Zm0 480q-17 0-28.5-11.5T120-200v-80q0-17 11.5-28.5T160-320h640q17 0 28.5 11.5T840-280v80q0 17-11.5 28.5T800-160H160Z"/>
                        </svg>
                    </div>

                    <h1 class="text-emerald-950 text-[19px] font-extrabold tracking-tight mb-1.5 leading-tight">{{ str_replace('-', ' ', $quizName) }}</h1>
                    <p class="text-emerald-800/70 text-[13px] leading-relaxed">
                        Attempt all questions at your own pace.<br>No time limit — take as long as you need.
                    </p>

                    {{-- Stats --}}
                    <div class="flex justify-center gap-3 mt-5">
                        <div class="text-center bg-white border border-emerald-100 rounded-xl px-4 py-2.5">
                            <p class="text-emerald-700 text-lg font-extrabold">{{ $quizCount }}</p>
                            <p class="text-slate-400 text-[10.5px] mt-0.5">Questions</p>
                        </div>
                        <div class="text-center bg-white border border-emerald-100 rounded-xl px-4 py-2.5">
                            <p class="text-emerald-700 text-lg font-extrabold">∞</p>
                            <p class="text-slate-400 text-[10.5px] mt-0.5">Time limit</p>
                        </div>
                        <div class="text-center bg-white border border-emerald-100 rounded-xl px-4 py-2.5">
                            <p class="text-emerald-700 text-lg font-extrabold">4</p>
                            <p class="text-slate-400 text-[10.5px] mt-0.5">Options each</p>
                        </div>
                    </div>
                </div>

                {{-- ── Body ── --}}
                <div class="px-7 py-6">

                    {{-- Rules --}}
                    <div class="bg-slate-50 border border-gray-100 rounded-xl px-4 py-3.5 mb-5">
                        <p class="text-slate-500 text-[10.5px] font-bold uppercase tracking-widest mb-3">Before you start</p>
                        <ul class="space-y-2">
                            @foreach([
                                'Read each question carefully before selecting an answer.',
                                'You can go back to previous questions and change your answer.',
                                'Skipped questions can still be answered before final submission.',
                                'Your score is shown immediately after you submit.',
                            ] as $rule)
                            <li class="flex items-start gap-2.5 text-slate-500 text-[12.5px] leading-relaxed">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 mt-1.5 shrink-0"></span>
                                {{ $rule }}
                            </li>
                            @endforeach
                        </ul>
                    </div>

                    {{-- ── Logged-in: Start button ── --}}
                    @if(session('user'))
                        <a href="/mcq/{{ session('firstMCQ')->id }}/{{ str_replace(' ', '-', $quizName) }}"
                            class="w-full py-3 bg-emerald-600 hover:bg-emerald-700 text-white text-[14px] font-bold rounded-xl flex items-center justify-center gap-2 transition-all duration-150 cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" height="16px" viewBox="0 -960 960 960" width="16px" fill="white">
                                <path d="M320-200v-560l440 280-440 280Z"/>
                            </svg>
                            Start Quiz
                        </a>

                    {{-- ── Guest: Register or Login ── --}}
                    @else
                        <p class="text-slate-500 text-[12.5px] text-center mb-4 leading-relaxed">
                            You need an account to attempt quizzes and track your scores.
                        </p>

                        <a href="/user-signup-start"
                            class="w-full py-3 bg-emerald-600 hover:bg-emerald-700 text-white text-[13.5px] font-bold rounded-xl flex items-center justify-center gap-2 transition-all duration-150 mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" height="15px" viewBox="0 -960 960 960" width="15px" fill="white">
                                <path d="M720-400v-120H600v-80h120v-120h80v120h120v80H800v120h-80Zm-360-80q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47ZM40-160v-112q0-34 17.5-62.5T104-378q62-31 126-46.5T360-440q66 0 130 15.5T616-378q29 15 46.5 43.5T680-272v112H40Z"/>
                            </svg>
                            Create a free account
                        </a>

                        <div class="flex items-center gap-3 my-1">
                            <div class="flex-1 h-px bg-gray-100"></div>
                            <span class="text-slate-400 text-[11px] font-semibold">or</span>
                            <div class="flex-1 h-px bg-gray-100"></div>
                        </div>

                        <a href="/user-login-start"
                            class="w-full py-3 bg-white hover:bg-slate-50 text-slate-700 text-[13.5px] font-bold rounded-xl flex items-center justify-center gap-2 border border-gray-200 hover:border-gray-300 transition-all duration-150 mt-3">
                            <svg xmlns="http://www.w3.org/2000/svg" height="15px" viewBox="0 -960 960 960" width="15px" fill="currentColor">
                                <path d="M480-120v-80h280v-560H480v-80h280q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H480Zm-80-160-55-58 102-102H120v-80h327L345-622l55-58 200 200-200 200Z"/>
                            </svg>
                            Sign in to your account
                        </a>
                    @endif

                </div>

                {{-- ── Footer ── --}}
                <div class="border-t border-gray-100 bg-slate-50 px-7 py-3.5 flex items-center justify-between">
                    @if(session('user'))
                        <p class="text-slate-400 text-[11.5px]">
                            Signed in as
                            <span class="font-semibold text-slate-600">{{ session('user')['name'] }}</span>
                        </p>
                    @else
                        <p class="text-slate-400 text-[11.5px]">Browsing as guest</p>
                        <span class="text-[10.5px] font-semibold bg-amber-50 text-amber-600 border border-amber-200 px-2 py-0.5 rounded-full">Login required</span>
                    @endif
                </div>

            </div>

            {{-- Back link below card --}}
            <p class="text-center mt-5">
                <a href="javascript:history.back()"
                    class="inline-flex items-center gap-1.5 text-slate-400 hover:text-slate-700 text-xs font-medium transition-colors duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" height="12px" viewBox="0 -960 960 960" width="12px" fill="currentColor">
                        <path d="M560-240 320-480l240-240 56 56-184 184 184 184-56 56Z"/>
                    </svg>
                    Back to quiz list
                </a>
            </p>

        </div>
    </main>

    <x-footer-user></x-footer-user>
</body>
</html>