<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Result — Quiz System</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">
    <x-user-navbar></x-user-navbar>

    {{-- Hero section --}}
    <section class="bg-white border-b border-gray-100">
        <div class="max-w-5xl mx-auto px-6 py-14 text-center">
            <h1 class="text-emerald-900 text-4xl font-bold tracking-tight leading-tight mb-4">
                Result of Quiz: {{$quizName}}<br>
                <h1 class="text-green-800 text-2xl font-bold tracking-tight">
                Total Marks: <span class="text-emerald-600">{{$correctAnswers}}</span>
                <span class="text-emarld-300">/</span>
                <span class="text-slate-400 font-medium text-xl">{{count($resultData)}}</span>
            </h1>
            </h1>
        </div>
    </section>

    <main class="flex-1 max-w-5xl mx-auto w-full px-6 py-10">
        <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-sm">
            <table class="w-full">
                <thead>
                    <tr class="bg-slate-50 border-b border-gray-100">
                        <th class="text-left text-slate-400 text-xs font-medium uppercase tracking-wide px-6 py-3 w-16">#</th>
                        <th class="text-left text-slate-400 text-xs font-medium uppercase tracking-wide px-6 py-3">Question</th>
                        <th class="text-left text-slate-400 text-xs font-medium uppercase tracking-wide px-6 py-3 w-45">Result</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($resultData as $key => $item)
                    <tr class="border-b border-gray-50 hover:bg-emerald-50/30 transition-colors duration-100">
                        <td class="px-6 py-4 text-slate-400 text-sm">{{$key + 1}}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <span class="text-slate-800 text-sm font-medium">{{$item->question}}</span>
                            </div>
                        </td>
                        @if($item->is_correct)
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-700 border border-emerald-100 text-xs font-semibold px-2.5 py-1 rounded-lg">
                                Correct ({{$item->select_answer}})
                            </span>
                        </td>
                        @else
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1 bg-red-50 text-red-700 border border-red-100 text-xs font-semibold px-2.5 py-1 rounded-lg">
                                Incorrect ({{$item->select_answer}})
                            </span>
                        </td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </main>

    <x-footer-user></x-footer-user>
</body>
</html>