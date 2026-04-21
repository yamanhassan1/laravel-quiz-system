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
                return redirect($url)->with('message', 'User Registered successfully!');
            }else{
                return redirect('/')->with('message', 'User Registered successfully!');
            }
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
        $mcqs = Mcq::where('quiz_id', $id)->get();
        Session::put('firstMCQ', $mcqs[0]);
        $quizName = $name;
        return view('start-quiz', ['quizCount'=>$quizCount, 'quizName'=>$quizName]);
    }

    function userLogin(Request $request){
        $validate = $request->validate([
            'email'=>'required|email',
            'password'=>'required',
        ]);
        $user = User::where('email', $request->email)->first();
        if(!$user || !Hash::check($request->password, $user->password)){
            return back()->withErrors(['user'=>'Invalid credentials! Please check your email and password.']);
        }
        if($user){
            Session::put('user', $user);
            if(Session::has('quiz-url')){
                $url = Session::get('quiz-url');
                Session::forget('quiz-url');
                return redirect($url)->with('message', 'User Login successfully!');
            }else{
                return redirect('/')->with('message', 'User Login successfully!');
            }
        }
    }

    function userLoginStart(Request $request){
        Session::put('quiz-url', url()->previous());
        return redirect('/user-login');
    }

    function mcq($id, $name){
        $quizName = $name;
        $currentQuiz = [];
        $currentQuiz['totalMcq'] = Mcq::where('quiz_id', Session::get('firstMCQ')->quiz_id)->count();
        $currentQuiz['currentMcq'] = 1;
        $currentQuiz['quizName'] = $name;
        $currentQuiz['quizId'] = Session::get('firstMCQ')->quiz_id;
        Session::put('currentQuiz', $currentQuiz);
        $mcqData = MCQ::find($id);
        return view('mcq-page', ['mcqData'=>$mcqData, 'quizName'=>$name]);
    }

    function submitAndNext($id){
        $currentQuiz = Session::get('currentQuiz');
        $currentQuiz['currentMcq'] += 1;

        $mcqData = MCQ::where([
            ['id', '>', $id],
            ['quiz_id', '=', $currentQuiz['quizId']]
        ])->first();

        Session::put('currentQuiz', $currentQuiz);
        if($mcqData){
            return view('mcq-page', ['mcqData'=>$mcqData, 'quizName'=>$currentQuiz['quizName']]);
        }else{
            return 'result page';
        }
    }

    function previousMcq($id){
        $currentQuiz = Session::get('currentQuiz');
        if ($currentQuiz['currentMcq'] > 1) {
            $currentQuiz['currentMcq'] -= 1;
        }

        $mcqData = MCQ::where([
            ['id', '<',  $id],
            ['quiz_id', '=', $currentQuiz['quizId']]
        ])->orderBy('id', 'desc')->first();

        Session::put('currentQuiz', $currentQuiz);

        if ($mcqData) {
            return view('mcq-page', [
            'mcqData'  => $mcqData,
            'quizName' => $currentQuiz['quizName']
            ]);
        } else {
            $firstMcq = MCQ::where('quiz_id', $currentQuiz['quizId'])->orderBy('id', 'asc')->firs();
            return view('mcq-page', ['mcqData'  => $firstMcq,'quizName' => $currentQuiz['quizName']]);
        }
    }

}
