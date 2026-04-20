<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Quiz — Quiz System Admin</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-slate-50 min-h-screen">
    <x-navbar name={{$name}}></x-navbar>

    <main class="max-w-2xl mx-auto px-6 py-10">

        @if(!session('quizDetails'))
        {{-- Step 1: Create quiz --}}
        <div class="mb-8">
            <div class="flex items-center gap-2 mb-1">
                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wide">Step 1 of 2</span>
            </div>
            <h1 class="text-slate-800 text-2xl font-semibold tracking-tight">Create a Quiz</h1>
            <p class="text-slate-400 text-sm mt-1">Give your quiz a name and choose its category</p>
        </div>

        <div class="bg-white border border-gray-200 rounded-2xl p-8 shadow-sm">
            <form action="/add-quiz" method="get" class="space-y-4">
                <div>
                    <label class="block text-slate-600 text-xs font-medium mb-1.5 uppercase tracking-wide">Quiz Name</label>
                    <input type="text" name="quiz" required placeholder="e.g. World Geography Basics"
                        class="w-full px-3.5 py-2.5 border border-gray-200 rounded-xl text-sm text-slate-800 bg-slate-50 focus:bg-white focus:border-slate-400 focus:outline-none transition-all duration-150 placeholder:text-slate-300">
                </div>
                <div>
                    <label class="block text-slate-600 text-xs font-medium mb-1.5 uppercase tracking-wide">Category</label>
                    <select name="category_id"
                        class="w-full px-3.5 py-2.5 border border-gray-200 rounded-xl text-sm text-slate-700 bg-slate-50 focus:bg-white focus:border-slate-400 focus:outline-none transition-all duration-150">
                        @foreach($categories as $category)
                        <option value="{{$category->id}}">{{$category->name}}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit"
                    class="w-full py-2.5 bg-slate-800 hover:bg-slate-900 text-white text-sm font-medium rounded-xl transition-all duration-150 mt-2">
                    Create Quiz & Add MCQs →
                </button>
            </form>
        </div>

        @else
        {{-- Step 2: Add MCQs --}}
        <div class="mb-8">
            <div class="flex items-center gap-2 mb-1">
                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wide">Step 2 of 2</span>
            </div>
            <h1 class="text-slate-800 text-2xl font-semibold tracking-tight">Add MCQs</h1>
            <p class="text-slate-400 text-sm mt-1">Adding questions to your quiz</p>
        </div>

        {{-- Quiz info bar --}}
        <div class="bg-white border border-gray-200 rounded-2xl p-4 mb-5 flex items-center justify-between shadow-sm">
            <div>
                <p class="text-slate-500 text-xs uppercase tracking-wide font-medium">Quiz</p>
                <p class="text-slate-800 text-sm font-semibold mt-0.5">{{session('quizDetails')->name}}</p>
            </div>
            <div class="flex items-center gap-3">
                <div class="text-right">
                    <p class="text-slate-500 text-xs uppercase tracking-wide font-medium">MCQs added</p>
                    <p class="text-slate-800 text-sm font-semibold mt-0.5">{{$totalMCQs}}</p>
                </div>
                @if($totalMCQs > 0)
                <a class="inline-flex items-center gap-1.5 text-xs text-slate-500 hover:text-slate-800 bg-slate-100 hover:bg-slate-200 px-2.5 py-1.5 rounded-lg transition-all duration-150 font-medium"
                    href="/show-quiz/{{session('quizDetails')->id}}/{{session('quizDetails')->name}}">
                    <svg xmlns="http://www.w3.org/2000/svg" height="13px" viewBox="0 -960 960 960" width="13px" fill="currentColor"><path d="M480-320q75 0 127.5-52.5T660-500q0-75-52.5-127.5T480-680q-75 0-127.5 52.5T300-500q0 75 52.5 127.5T480-320Zm0-72q-45 0-76.5-31.5T372-500q0-45 31.5-76.5T480-608q45 0 76.5 31.5T588-500q0 45-31.5 76.5T480-392Zm0 192q-146 0-266-81.5T40-500q54-137 174-218.5T480-800q146 0 266 81.5T920-500q-54 137-174 218.5T480-200Z"/></svg>
                    Preview
                </a>
                @endif
            </div>
        </div>

        {{-- MCQ form --}}
        <div class="bg-white border border-gray-200 rounded-2xl p-8 shadow-sm">
            <form action="/add-mcq" method="post" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-slate-600 text-xs font-medium mb-1.5 uppercase tracking-wide">Question</label>
                    <textarea name="question" rows="3" placeholder="Enter your question here..."
                        class="w-full px-3.5 py-2.5 border border-gray-200 rounded-xl text-sm text-slate-800 bg-slate-50 focus:bg-white focus:border-slate-400 focus:outline-none transition-all duration-150 placeholder:text-slate-300 resize-none"></textarea>
                    @error('question')
                        <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-2 gap-3">
                    @foreach(['a' => 'Option A', 'b' => 'Option B', 'c' => 'Option C', 'd' => 'Option D'] as $key => $label)
                    <div>
                        <label class="block text-slate-500 text-xs font-medium mb-1.5">{{$label}}</label>
                        <input type="text" name="{{$key}}" placeholder="{{$label}}"
                            class="w-full px-3.5 py-2.5 border border-gray-200 rounded-xl text-sm text-slate-800 bg-slate-50 focus:bg-white focus:border-slate-400 focus:outline-none transition-all duration-150 placeholder:text-slate-300">
                        @error($key)
                            <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                        @enderror
                    </div>
                    @endforeach
                </div>

                <div>
                    <label class="block text-slate-600 text-xs font-medium mb-1.5 uppercase tracking-wide">Correct Answer</label>
                    <select name="correct_ans"
                        class="w-full px-3.5 py-2.5 border border-gray-200 rounded-xl text-sm text-slate-700 bg-slate-50 focus:bg-white focus:border-slate-400 focus:outline-none transition-all duration-150">
                        <option value="">Select correct answer</option>
                        <option value="a">A</option>
                        <option value="b">B</option>
                        <option value="c">C</option>
                        <option value="d">D</option>
                    </select>
                    @error('correct_ans')
                        <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                    @enderror
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="submit" name="submit" value="add-more"
                        class="flex-1 py-2.5 border border-slate-300 hover:border-slate-400 hover:bg-slate-50 text-slate-700 text-sm font-medium rounded-xl transition-all duration-150">
                        Save & Add More
                    </button>
                    <button type="submit" name="submit" value="done"
                        class="flex-1 py-2.5 bg-slate-800 hover:bg-slate-900 text-white text-sm font-medium rounded-xl transition-all duration-150">
                        Save & Finish
                    </button>
                </div>
                <a class="block w-full py-2.5 border border-red-200 hover:bg-red-50 text-red-500 hover:text-red-700 text-center text-sm font-medium rounded-xl transition-all duration-150"
                    href="\end-quiz">
                    Discard & Exit
                </a>
            </form>
        </div>
        @endif

    </main>
</body>
</html>