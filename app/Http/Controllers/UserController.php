<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Quiz;
use App\Models\Mcq;
use App\Models\User;
use App\Models\Record;
use App\Models\MCQ_Record;
use App\Mail\VerifyUser;
use App\Mail\UserForgotPassword;

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

        //
        $link = Crypt::encryptstring($user->email);
        $link = url('/verify-user/'.$link);
        Mail::to($user->email)->send(new VerifyUser($link));

        //

        if($user){
            Session::put('user', $user);
            if(Session::has('quiz-url')){
                $url = Session::get('quiz-url');
                Session::forget('quiz-url');
                return redirect($url)->with('message-success', 'User Registered successfully! Please verify your email to continue.');
            }else{
                return redirect('/')->with('message-success', 'User Registered successfully! Please verify your email to continue.');
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
        'email'    => 'required|email',
        'password' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if(!$user || !Hash::check($request->password, $user->password)){
        return redirect('/user-login')->withErrors(['user' => 'Invalid email or password! Please try again.']);
    }

    Session::put('user', [
        'id'    => $user->id,
        'name'  => $user->name,
        'email' => $user->email,
    ]);

    if(Session::has('quiz-url')){
        $url = Session::get('quiz-url');
        Session::forget('quiz-url');
        return redirect($url)->with('message-success', 'User Login successfully!');
    }

    return redirect('/')->with('message-success', 'User Login successfully!');
}

    function userLoginStart(Request $request){
        Session::put('quiz-url', url()->previous());
        return redirect('/user-login')->with('message-success', 'Please login to continue.');
    }

    function mcq($id, $name){
        $record = new Record();
        $record->user_id = Session::get('user')['id'];
        $record->quiz_id = Session::get('firstMCQ')->quiz_id;
        $record->status = 1;
        if($record->save()){
            $quizName = $name;
            $currentQuiz = [];
            $currentQuiz['totalMcq'] = Mcq::where('quiz_id', Session::get('firstMCQ')->quiz_id)->count();
            $currentQuiz['currentMcq'] = 1;
            $currentQuiz['quizName'] = $name;
            $currentQuiz['recordId'] = $record->id;
            $currentQuiz['quizId'] = Session::get('firstMCQ')->quiz_id;
            Session::put('currentQuiz', $currentQuiz);
            $mcqData = MCQ::find($id);
            return view('mcq-page', ['mcqData'=>$mcqData, 'quizName'=>$name]);
        }else{
            return back()->withErrors(['record'=>'Something went wrong! Please try again later.']);
        }
    }
    
    function submitAndNext(Request $request, $id){
    $currentQuiz = Session::get('currentQuiz');
    $currentQuiz['currentMcq'] += 1;

    $mcqData = MCQ::where([
        ['id', '>', $id],
        ['quiz_id', '=', $currentQuiz['quizId']]
    ])->first();

    $isExist = MCQ_Record::where([
        ['record_id', '=', $currentQuiz['recordId']],
        ['mcq_id', '=', $request->id]
    ])->count();

    if($isExist < 1){
        $mcq_record = new MCQ_Record();
        $mcq_record->record_id = $currentQuiz['recordId'];
        $mcq_record->user_id = Session::get('user')['id'];
        $mcq_record->mcq_id = $request->id;
        $mcq_record->select_answer = $request->option;

        if($request->option == MCQ::find($request->id)->correct_ans){
            $mcq_record->is_correct = 1;
        }else{
            $mcq_record->is_correct = 0;
        }

        if(!$mcq_record->save()){
            return back()->withErrors(['record'=>'Something went wrong! Please try again later.']);
        }
    }

    Session::put('currentQuiz', $currentQuiz);

    if($mcqData){
        return view('mcq-page', ['mcqData'=>$mcqData, 'quizName'=>$currentQuiz['quizName']]);
    }else{
        $resultData = MCQ_record::WithMCQ()->where('record_id', $currentQuiz['recordId'])->get();
        $correctAnswers = MCQ_record::where([
            ['record_id', '=', $currentQuiz['recordId']],
            ['is_correct', '=', 1]
        ])->count();

        $record = Record::find($currentQuiz['recordId']);
        if($record){
            $record->status = 2;
            $record->update();
        }

        return view('quiz-result', ['resultData'=>$resultData, 'quizName'=>$currentQuiz['quizName'], 'correctAnswers'=>$correctAnswers]);
    }
}

function previousMcq($id){
    $currentQuiz = Session::get('currentQuiz');
    if ($currentQuiz['currentMcq'] > 1) {
        $currentQuiz['currentMcq'] -= 1;
    }

    $mcqData = MCQ::where([
        ['id', '<', $id],
        ['quiz_id', '=', $currentQuiz['quizId']]
    ])->orderBy('id', 'desc')->first();

    Session::put('currentQuiz', $currentQuiz);

    if ($mcqData) {
        return view('mcq-page', [
            'mcqData'  => $mcqData,
            'quizName' => $currentQuiz['quizName']
        ]);
    } else {
        $firstMcq = MCQ::where('quiz_id', $currentQuiz['quizId'])->orderBy('id', 'asc')->first();
        return view('mcq-page', ['mcqData' => $firstMcq, 'quizName' => $currentQuiz['quizName']]);
    }
}

    function userDetails(){
    $quizRecords = Record::WithQuiz()->where('user_id', Session::get('user')['id'])->get();

    foreach($quizRecords as $record){
        $record->correct   = MCQ_Record::where(['record_id' => $record->id, 'is_correct' => 1])->count();
        $record->total_mcq = MCQ_Record::where('record_id', $record->id)->count();
    }
    
    return view('user-details', ['quizRecords' => $quizRecords]);
}

    function quizSearch(Request $request){
        $quizData = Quiz::where('name', 'like', '%'.$request->search.'%')->get();
        return view('quiz-search', ['quizData'=>$quizData, 'quiz'=>$request->search]);
    }

    function verifyUser($email){
        $orgEmail = Crypt::decryptString($email);
        $user = User::where('email', $orgEmail)->first();
        if($user){
            $user->active = 2;
            if($user->save()){
                return redirect('/')->with('message-success', 'Email verified successfully! Please login to continue.');
            }
        }
    }

    function userForgotPassword(Request $request){
        $validate = $request->validate([
            'email'=>'required|email',
        ]);
        $user = User::where('email', $request->email)->first();
        if(!$user){
            return back()->withErrors(['user'=>'No user found with this email! Please check your email and try again.']);
        }
        $link = Crypt::encryptstring($user->email);
        $link = url('/user-forgot-password/'.$link);
        Mail::to($user->email)->send(new UserForgotPassword($link));

        //

        return redirect('/');
    }

    function userResetForgotPassword($email){
        $orgEmail = Crypt::decryptString($email);
        $user = User::where('email', $orgEmail)->first();
        if($user){
            return view('user-set-forgot-password', ['email'=>$orgEmail]);
        }else{
            return redirect('/')->withErrors(['user'=>'Invalid link! Please try again.']);
        }
    }

    function userSetForgotPassword(Request $request){
        $validate = $request->validate([
            'email'=>'required|email',
            'password'=>'required|min:6|confirmed',
        ]);
        $user = User::where('email', $request->email)->first();
        if($user){
            $user->password = Hash::make($request->password);
            if($user->save()){
                return redirect('/user-login')->with('message', 'Password updated successfully! Please login to continue.');
            }
        }else{
            return redirect('/')->withErrors(['user'=>'No user found with this email! Please check your email and try again.']);
        }
    }

}
