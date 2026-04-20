<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Categories Page</title>
    @vite('resources/css/app.css')
</head>
<body>
    <x-user-navbar></x-user-navbar>
    <div class=" bg-gray-100 flex flex-col items-center min-h-screen pt-5">
        <h1 class=" text-4xl text-green-900 font-bold">Welcome to Quiz System</h1>
        <p class=" text-lg text-gray-700 mt-3">Test your knowledge with our exciting quizzes!</p>
        <div class=" mt-5 w-full max-w-md">
            <div class=" relative">
                <input class=" w-full px-4 py-2 border border-gray-500 rounded-2xl shadow text-gray-700" type="text" placeholder="Search quiz...">
                <button class=" absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-600 px-3 py-1 rounded-full"><svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#434343"><path d="M765-144 526-383q-30 22-65.79 34.5-35.79 12.5-76.18 12.5Q284-336 214-406t-70-170q0-100 70-170t170-70q100 0 170 70t70 170.03q0 40.39-12.5 76.18Q599-464 577-434l239 239-51 51ZM384-408q70 0 119-49t49-119q0-70-49-119t-119-49q-70 0-119 49t-49 119q0 70 49 119t119 49Z"/></svg></button>
            </div>
        </div>
    <div class=" w-200">
        <h1 class=" text-2xl text-green-900 font-bold text-center my-5">Category List</h1>
        <ul class=" border border-gray-200">
            <li class=" p-2 font-bold">
                <ul class=" flex justify-between">
                    <li class=" w-30">S No.</li>
                    <li class=" w-140">Name</li>
                    <li class=" w-30">Action</li>
                </ul>
            </li>
            @foreach($categories as $key=>$category)
            <li class=" even:bg-gray-200 p-2">
                <ul class=" flex justify-between">
                    <li class=" w-30">{{$key + 1}}</li>
                    <li class=" w-140">{{$category->name}}</li>
                    <li class=" w-30">
                        <a href="/quiz-list/{{$category->id}}/{{$category->name}}"><svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#000000"><path d="M599-361q49-49 49-119t-49-119q-49-49-119-49t-119 49q-49 49-49 119t49 119q49 49 119 49t119-49Zm-187-51q-28-28-28-68t28-68q28-28 68-28t68 28q28 28 28 68t-28 68q-28 28-68 28t-68-28ZM220-270.5Q103-349 48-480q55-131 172-209.5T480-768q143 0 260 78.5T912-480q-55 131-172 209.5T480-192q-143 0-260-78.5ZM480-480Zm207 158q95-58 146-158-51-100-146-158t-207-58q-112 0-207 58T127-480q51 100 146 158t207 58q112 0 207-58Z"/></svg>
                        </a>
                    </li>
                </ul>
            </li>
            @endforeach
        </ul>
    </div>
    </div>
    <x-footer-user></x-footer-user>
</body>
</html>