<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Quiz Page</title>
    @vite('resources/css/app.css')
</head>
<body>
    <x-navbar name={{$name}}></x-navbar>
     <div class=" bg-gray-100 flex flex-col items-center min-h-screen pt-5">
        <div class="bg-white p-8 rounded-2xl shadow-lg w-full max-w-md">
            @if(!session('quizDetails'))
            <h2 class=" text-2xl text-center text-gray-800 mb-6">Add Quiz</h2>
            <form action="/add-quiz" method="get" class="space-y-4">
                <div>
                    <input type="text" name="quiz" id="" placeholder="Enter quiz name" class=" w-full px-4 py-1.5 border border-gray-300 rounded-xl focus:outline-none">
                </div>
                <div>
                    <select type="text" name="category_id" id="" class=" w-full px-4 py-1.5 border border-gray-300 rounded-xl focus:outline-none">
                    @foreach($categories as $category)
                    <option value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
                    </select>
                </div>
                <button type="submit" class="w-full py-1.5 bg-blue-700 rounded-xl text-gray-100">Add</button>
            </form>
            @else
            <span class=" text-green-500 font-bold">Quiz: {{session('quizDetails')->name}}</span>
            <h2 class=" text-2xl text-center text-gray-800 mb-6">Add MCQs</h2>
            <form action="/add-mcq" method="post" class="space-y-4">
                <div>
                    @csrf
                    <textarea type="text" name="question" id="" placeholder="Enter your question" class=" w-full px-4 py-1.5 border border-gray-300 rounded-xl focus:outline-none">
                    </textarea>
                </div>
                <div>
                    <input type="text" name="a" id="" placeholder="Enter first option" class=" w-full px-4 py-1.5 border border-gray-300 rounded-xl focus:outline-none">
                </div>
                <div>
                    <input type="text" name="b" id="" placeholder="Enter second option" class=" w-full px-4 py-1.5 border border-gray-300 rounded-xl focus:outline-none">
                </div>
                <div>
                    <input type="text" name="c" id="" placeholder="Enter third option" class=" w-full px-4 py-1.5 border border-gray-300 rounded-xl focus:outline-none">
                </div>
                <div>
                    <input type="text" name="d" id="" placeholder="Enter forth option" class=" w-full px-4 py-1.5 border border-gray-300 rounded-xl focus:outline-none">
                </div>
                <div>
                    <select name="correct_ans" class=" w-full px-4 py-1.5 border border-gray-300 rounded-xl focus:outline-none">
                        <option>Select Right Answer</option>
                        <option value="a">A</option>
                        <option value="b">B</option>
                        <option value="c">C</option>
                        <option value="d">D</option>
                    </select>
                </div>
                <button type="submit" name="submit" value="add-more" class="w-full py-1.5 bg-blue-700 rounded-xl text-gray-100">Add More</button>
                <button type="submit" name="submit" value="done" class="w-full py-1.5 bg-green-700 rounded-xl text-gray-100">Add and Submit</button>
                </form>
            @endif
        </div>
        </div>
</body>
</html>