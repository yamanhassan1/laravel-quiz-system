<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    @vite('resources/css/app.css')
</head>
<body class=" bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-2xl shadow-lg w-full max-w-sm">
        <h2 class=" text-2xl text-center text-gray-800 mb-6">Admin Login</h2>
        @error('user')
            <div class="text-red-500">{{$message}}</div>
        @enderror
        <form action="/admin-login" method="post" class="space-y-4">
            @csrf
            <div>
                <label for="" class=" text-gray-600 mb-1">Admin name</label>
                <input type="text" name="name" id="" placeholder="Enter Admin name" class=" w-full px-4 py-1.5 border border-gray-300 rounded-xl focus:outline-none">
                @error('name')
                    <div class="text-red-500">{{$message}}</div>
                @enderror
            </div>
            <div>
                <label for="" class=" text-gray-600 mb-1">Password</label>
                <input type="password" name="password" id="" placeholder="Enter Admin password" class=" w-full px-4 py-1.5 border border-gray-300 rounded-xl focus:outline-none">
                @error('password')
                    <div class="text-red-500">{{$message}}</div>
                @enderror
            </div>
            <button type="submit" class="w-full py-1.5 bg-blue-700 rounded-xl text-gray-100">Login</button>
        </form>
    </div>
</body>
</html>