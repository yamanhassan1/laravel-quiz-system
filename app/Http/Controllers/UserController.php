<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Quiz;
use App\Models\Mcq;

class userController extends Controller
{
    function welcome(){
        $categories = Category::withCount('quizzes')->get();
        return view('welcome', ['categories'=>$categories]);
    }

    function userQuizList($id, $category){
        $quizData = Quiz::where('category_id', $id)->get();
        return view('user-quiz-list',["quizData"=>$quizData, "category"=>$category]);
    }

    function userSignup(Request $request){
        $validate = $request->validate([
            'name'=>'required|min:3',
            'email'=>'required|email|unique:users,email',
            'password'=>'required|min:6|confirmed',
        ]);

        $user = new \App\Models\User;
        $user->email = $request->email;
        $user->password = \Hash::make($request->password);
        $user->save();

        return redirect('/')->with('success', 'Account created successfully. Please login to continue.');
    }

    function startQuiz($id, $name){
        $quizCount = Mcq::withCount()->where('quiz_id', $id)->count();
        $quizName = $name;
        return view('start-quiz', ['quizCount'=>$quizCount, 'quizName'=>$quizName]);
    }
}
