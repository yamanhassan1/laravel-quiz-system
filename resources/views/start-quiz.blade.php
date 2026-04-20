<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Start Quiz — Quiz System</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">
    <x-user-navbar></x-user-navbar>

    <main class="flex-1 max-w-3xl mx-auto w-full px-6 py-10 items-center">

        <div class="flex-col items-center gap-3 mb-8">
            <h1 class="text-4xl text-center font-bold mb-6 text-slate-800">{{$quizName}}</h1>
            <h2 class="text-lg text-center font-bold mb-6 text-green-800">This Quiz contains {{$quizCount}} Questions and no limit to attempt this Quiz</h2>
            <h3 class="text-2xl text-center font-bold mb-8 text-green-800">Good Luck</h3>
            @if(session('user'))
            <a class="bg-green-800 hover:bg-green-900 text-white px-4 py-2 rounded-lg text-md font-medium transition-all mx-77 duration-150" href="/user-signup">Start Quiz</a>
            @else
            <a class="bg-green-800 hover:bg-green-900 text-white px-4 py-2 rounded-lg text-md font-medium transition-all mx-61 duration-150" href="/user-signup-start">SignUp/LogIn to Start Quiz</a>
            @endif
        </div>
    </main>

    <x-footer-user></x-footer-user>
</body>
</html>