<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Your Email — Quiz System</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-[#f8faf8] min-h-screen flex items-center justify-center px-4 py-12">

    @php
        $user    = session('user');
        $initials = collect(explode(' ', $user->name ?? 'U'))
                    ->map(fn($w) => strtoupper($w[0]))
                    ->take(2)
                    ->join('');
    @endphp

    <div class="w-full max-w-120">
        <div class="bg-white border border-gray-200 rounded-[20px] overflow-hidden shadow-sm">

            {{-- ── Header ── --}}
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

                {{-- Envelope icon --}}
                <div class="w-13 h-13 rounded-2xl bg-white border border-emerald-200 flex items-center justify-center mx-auto mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#059669">
                        <path d="M160-160q-33 0-56.5-23.5T80-240v-480q0-33 23.5-56.5T160-800h640q33 0 56.5 23.5T880-720v480q0 33-23.5 56.5T800-160H160Zm320-280L160-640v400h640v-400L480-440Zm0-80 320-200H160l320 200ZM160-640v-80 480-400Z"/>
                    </svg>
                </div>

                <h1 class="text-emerald-950 text-[17px] font-bold tracking-tight mb-1.5">Verify it's you</h1>
                <p class="text-emerald-800/70 text-[13px] leading-relaxed">
                    A verification link was sent to your email.<br>Confirm your identity to access Quiz System.
                </p>
            </div>

            {{-- ── Alerts ── --}}
            @if(session('resent'))
                <div class="mx-5 mt-4 bg-emerald-50 border border-emerald-200 text-emerald-700 text-[13px] rounded-xl px-4 py-3 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" height="14px" viewBox="0 -960 960 960" width="14px" fill="currentColor">
                        <path d="m424-296 282-282-56-56-226 226-114-114-56 56 170 170Zm56 216q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Z"/>
                    </svg>
                    A fresh verification link has been sent to your email.
                </div>
            @endif

            @if($errors->any())
                <div class="mx-5 mt-4 bg-red-50 border border-red-200 text-red-600 text-[13px] rounded-xl px-4 py-3 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" height="14px" viewBox="0 -960 960 960" width="14px" fill="currentColor">
                        <path d="M480-280q17 0 28.5-11.5T520-320q0-17-11.5-28.5T480-360q-17 0-28.5 11.5T440-320q0 17 11.5 28.5T480-280Zm-40-160h80v-240h-80v240Zm40 360q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Z"/>
                    </svg>
                    {{ $errors->first() }}
                </div>
            @endif

            {{-- ── Identity card ── --}}
            <div class="mx-5 mt-5 bg-slate-50 border border-gray-100 rounded-2xl px-4 py-3.5 flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-700 text-sm font-bold flex items-center justify-center shrink-0">
                    {{ $initials }}
                </div>
                <div class="min-w-0">
                    <p class="text-slate-800 text-[13.5px] font-semibold truncate">{{ $user->name ?? 'User' }}</p>
                    <p class="text-slate-400 text-[11.5px] truncate">{{ $user->email ?? '' }}</p>
                </div>
                <span class="ml-auto shrink-0 text-[10px] font-semibold bg-amber-50 text-amber-700 border border-amber-200 px-2.5 py-1 rounded-full">
                    Pending
                </span>
            </div>

            {{-- ── Steps ── --}}
            <div class="mx-5 mt-4 space-y-2">
                @foreach([
                    ['n'=>'1', 'text'=> 'Open the email from <strong class="text-slate-700">noreply@quizsystem.com</strong>'],
                    ['n'=>'2', 'text'=> 'Click the <strong class="text-slate-700">"Go to Login"</strong> button inside it'],
                    ['n'=>'3', 'text'=> 'You\'ll be redirected back to Login page and can access your account!'],
                ] as $step)
                <div class="flex items-center gap-3 bg-slate-50 border border-gray-100 rounded-xl px-4 py-2.5">
                    <span class="w-5 h-5 rounded-lg bg-emerald-100 text-emerald-700 text-[11px] font-bold flex items-center justify-center shrink-0">{{ $step['n'] }}</span>
                    <p class="text-slate-500 text-[12.5px]">{!! $step['text'] !!}</p>
                </div>
                @endforeach
            </div>

            {{-- ── Go to Login ── --}}
            <div class="px-5 pt-4">
                <p class="text-center text-green-900 text-[11.5px] mt-2.5">
                    Already verified?
                    <a href="{{$link}}" class="text-emerald-600 hover:text-emerald-800 font-semibold transition-colors duration-150">Go to login →</a>
                </p>
            </div>

            {{-- ── Security reminders ── --}}
            <div class="mx-5 mt-4 mb-5 bg-amber-50 border border-amber-200 rounded-xl px-4 py-3.5">
                <p class="text-amber-800 text-[11px] font-bold uppercase tracking-wide flex items-center gap-1.5 mb-2.5">
                    <svg xmlns="http://www.w3.org/2000/svg" height="13px" viewBox="0 -960 960 960" width="13px" fill="currentColor">
                        <path d="M480-280q17 0 28.5-11.5T520-320q0-17-11.5-28.5T480-360q-17 0-28.5 11.5T440-320q0 17 11.5 28.5T480-280Zm-40-160h80v-240h-80v240Zm40 360q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Z"/>
                    </svg>
                    Security reminders
                </p>
                <ul class="space-y-1.5">
                    @foreach([
                        'Quiz System will never ask for your password by email.',
                        'The verification link expires in 24 hours — request a new one if needed.',
                        'If you did not create this account, ignore the email. It will expire safely.',
                        'Can\'t find the email? Check your spam or promotions folder.',
                    ] as $note)
                    <li class="flex items-start gap-2 text-amber-900 text-[12px] leading-relaxed">
                        <span class="w-1 h-1 rounded-full bg-amber-500 mt-1.5 shrink-0"></span>
                        {{ $note }}
                    </li>
                    @endforeach
                </ul>
            </div>

            {{-- ── Footer ── --}}
            <div class="border-t border-gray-100 bg-slate-50 px-6 py-3.5 flex items-center justify-between">
                <p class="text-slate-400 text-[11.5px]">Wrong account?</p>
                <a href="/logout" class="text-[11.5px] font-semibold text-emerald-600 hover:text-emerald-800 transition-colors duration-150">
                    Sign out →
                </a>
            </div>

        </div>

        <p class="text-center text-slate-400 text-[11px] mt-4">
            Having trouble? Contact us at
            <a href="mailto:support@quizsystem.com" class="text-emerald-600 hover:underline">support@quizsystem.com</a>
        </p>
    </div>

</body>
</html>