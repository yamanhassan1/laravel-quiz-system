<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Quiz;
use App\Models\Mcq;
use App\Models\User;

class userController extends Controller
{
    function welcome(){
        $categories = Category::withCount('quizzes')->get();
        return view('welcome', ['categories'=>$categories]);
    }

    function userQuizList($id, $category){
        $quizCount = Quiz::where('category_id', $id)->count();
        $quizData = Quiz::where('category_id', $id)->get();
        return view('user-quiz-list',["quizData"=>$quizData, "category"=>$category]);
    }

    function userSignup(Request $request){
        $validate = $request->validate([
            'name'=>'required|min:3',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:6|confirmed',
        ]);
        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
        ]);
        if($user){
            Session::put('user', $user);
            if(Session::has('quiz-url')){
                $url = Session::get('quiz-url');
                Session::forget('quiz-url');
                return redirect($url);
            }
            return redirect('/');
        }
    }

    function userSignupStart(Request $request){
        Session::put('quiz-url', url()->previous());
        return redirect('/user-signup');
    }

    function userLogout(){
        Session::forget('user');
        return redirect('/');
    }

    function startQuiz($id, $name){
        $quizCount = Mcq::where('quiz_id', $id)->count();
        $quizName = $name;
        return view('start-quiz', ['quizCount'=>$quizCount, 'quizName'=>$quizName]);
    }
}
