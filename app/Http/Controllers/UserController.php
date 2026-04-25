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
    function welcome()
    {
        $categories = Category::withCount('quizzes')->orderByDesc('quizzes_count')->take(5)->get();
        $quizData = Quiz::withCount('Records')
        ->orderByDesc('records_count')
        ->take(5)
        ->get()
        ->map(function($quiz) {
            $quiz->mcqs_count = $quiz->mcqs()->count();
            $quiz->attempts_count = $quiz->Records()->count();
            return $quiz;
        });
        return view('welcome', ['categories' => $categories, 'quizData' => $quizData]);
    }

    function categories(){
        $categories = Category::withCount('quizzes')->orderByDesc('quizzes_count')->paginate(10);
        return view('categories-list', ['categories'=> $categories]);
    }

    function userQuizList($id, $category)
    {
        $quizCount = Quiz::where('category_id', $id)->count();
        $quizData = Quiz::where('category_id', $id)->paginate(10);
        return view('user-quiz-list', ["quizData" => $quizData, "category" => $category, "quizCount" => $quizCount]);
    }

    function userSignup(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        //
        $link = Crypt::encryptstring($user->email);
        $link = url('/verify-user/' . $link);
        Mail::to($user->email)->send(new VerifyUser($link));

        //

        if ($user) {
            Session::put('user', $user);
            if (Session::has('quiz-url')) {
                $url = Session::get('quiz-url');
                Session::forget('quiz-url');
                return redirect($url)->with('message-success', 'User Registered successfully! Please verify your email to continue.');
            } else {
                return redirect('/')->with('message-success', 'User Registered successfully! Please verify your email to continue.');
            }
        }
    }

    function userSignupStart(Request $request)
    {
        Session::put('quiz-url', url()->previous());
        return redirect('/user-signup');
    }

    function userLogout()
    {
        Session::forget('user');
        return redirect('/');
    }

    function startQuiz($id, $name)
    {
        $quizCount = Mcq::where('quiz_id', $id)->count();
        $mcqs = Mcq::where('quiz_id', $id)->get();
        Session::put('firstMCQ', $mcqs[0]);
        $quizName = $name;
        return view('start-quiz', ['quizCount' => $quizCount, 'quizName' => $quizName]);
    }

    function userLogin(Request $request)
    {
        $validate = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return redirect('/user-login')->withErrors(['user' => 'Invalid email or password! Please try again.']);
        }

        Session::put('user', [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ]);

        if (Session::has('quiz-url')) {
            $url = Session::get('quiz-url');
            Session::forget('quiz-url');
            return redirect($url)->with('message-success', 'User Login successfully!');
        }

        return redirect('/')->with('message-success', 'User Login successfully!');
    }

    function userLoginStart(Request $request)
    {
        Session::put('quiz-url', url()->previous());
        return redirect('/user-login')->with('message-success', 'Please login to continue.');
    }

    function mcq($id, $name)
    {
        $record = new Record();
        $record->user_id = Session::get('user')['id'];
        $record->quiz_id = Session::get('firstMCQ')->quiz_id;
        $record->status = 1;
        if ($record->save()) {
            $quizName = $name;
            $currentQuiz = [];
            $currentQuiz['totalMcq'] = Mcq::where('quiz_id', Session::get('firstMCQ')->quiz_id)->count();
            $currentQuiz['currentMcq'] = 1;
            $currentQuiz['quizName'] = $name;
            $currentQuiz['recordId'] = $record->id;
            $currentQuiz['quizId'] = Session::get('firstMCQ')->quiz_id;
            Session::put('currentQuiz', $currentQuiz);
            $mcqData = MCQ::find($id);
            return view('mcq-page', ['mcqData' => $mcqData, 'quizName' => $quizName]);
        } else {
            return back()->withErrors(['record' => 'Something went wrong! Please try again later.']);
        }
    }

    private function markVisited(array &$quiz, int $qNum): void
    {
        $visited = $quiz['visitedMcqs'] ?? [];
        if (!in_array($qNum, $visited)) {
            $visited[] = $qNum;
        }
        $quiz['visitedMcqs'] = $visited;
    }

    private function markAnswered(array &$quiz, int $qNum): void
    {
        $answered = $quiz['answeredMcqs'] ?? [];
        $skipped = $quiz['skippedMcqs'] ?? [];

        if (!in_array($qNum, $answered)) {
            $answered[] = $qNum;
        }

        // Remove from skipped if user came back and answered it
        $skipped = array_values(array_diff($skipped, [$qNum]));

        $quiz['answeredMcqs'] = $answered;
        $quiz['skippedMcqs'] = $skipped;
        $quiz['answeredCount'] = count($answered);
    }

    private function markSkipped(array &$quiz, int $qNum): void
    {
        $answered = $quiz['answeredMcqs'] ?? [];
        $skipped = $quiz['skippedMcqs'] ?? [];

        // Only mark skipped if not already answered
        if (!in_array($qNum, $answered) && !in_array($qNum, $skipped)) {
            $skipped[] = $qNum;
        }

        $quiz['skippedMcqs'] = $skipped;
    }

    private function saveRecord(array $quiz, int $mcqId, ?string $selectedOption): void
    {
        // Skip saving if no option selected (null = skipped question)
        if (is_null($selectedOption)) {
            return;
        }

        $correctAns = MCQ::find($mcqId)?->correct_ans;
        $isCorrect = ($selectedOption === $correctAns) ? 1 : 0;

        // updateOrCreate handles both first attempt and returning to change answer
        MCQ_Record::updateOrCreate(
            [
                'record_id' => $quiz['recordId'],
                'mcq_id' => $mcqId,
            ],
            [
                'user_id' => Session::get('user')['id'],
                'select_answer' => $selectedOption,
                'is_correct' => $isCorrect,
            ]
        );
    }

    private function getPreviousAnswer(array $quiz, int $mcqId): ?string
    {
        return MCQ_Record::where('record_id', $quiz['recordId'])
            ->where('mcq_id', $mcqId)
            ->value('select_answer');
    }


    // ─── SUBMIT & NEXT ────────────────────────────────────────────────────────────

    public function submitAndNext(Request $request, int $id)
    {
        $currentQuiz = Session::get('currentQuiz');
        if (!$currentQuiz || !is_array($currentQuiz)) {
            return redirect('/')->with('message-error', 'Quiz session expired. Please start a new quiz.');
        }

        // Validate required keys exist
        if (!isset($currentQuiz['currentMcq'])) {
            return redirect('/')->with('message-error', 'Invalid quiz session. Please try again.');
        }

        $leavingQNum = $currentQuiz['currentMcq'];
        $selectedOption = $request->option ?: null;

        // 1. Mark the question we are leaving as visited
        $this->markVisited($currentQuiz, $leavingQNum);

        // 2. Track answered / skipped state
        if ($selectedOption) {
            $this->markAnswered($currentQuiz, $leavingQNum);
        } else {
            $this->markSkipped($currentQuiz, $leavingQNum);
        }

        // 3. Save the record (skips automatically if null)
        $this->saveRecord($currentQuiz, $id, $selectedOption);

        // 4. Advance the counter
        $currentQuiz['currentMcq'] += 1;

        // 5. Load the next MCQ
        $mcqData = MCQ::where('id', '>', $id)
            ->where('quiz_id', $currentQuiz['quizId'])
            ->first();

        // 6. Mark the arriving question as visited
        if ($mcqData) {
            $this->markVisited($currentQuiz, $currentQuiz['currentMcq']);
        }

        Session::put('currentQuiz', $currentQuiz);

        // ── More questions remain ─────────────────────────────────────────────────
        if ($mcqData) {
            return view('mcq-page', [
                'mcqData' => $mcqData,
                'quizName' => $currentQuiz['quizName'],
                'previousAnswer' => $this->getPreviousAnswer($currentQuiz, $mcqData->id),
            ]);
        }

        // ── Last question submitted — build result ────────────────────────────────
        $resultData = MCQ_Record::with('mcq') // Make sure you have a 'mcq' relationship defined
            ->where('record_id', $currentQuiz['recordId'])
            ->get()
            ->map(function ($record) {
                return (object) [
                    'id' => $record->id,
                    'question' => $record->mcq->question ?? 'Question not available',
                    'select_answer' => $record->select_answer ?? 'Not answered',
                    'is_correct' => $record->is_correct ?? false,
                    'correct_answer' => $record->mcq->correct_answer ?? null, // Include correct answer for learning
                ];
            });

        $correctAnswers = MCQ_Record::where('record_id', $currentQuiz['recordId'])
            ->where('is_correct', 1)
            ->count();

        // Mark the quiz record as completed (status = 2)
        Record::where('id', $currentQuiz['recordId'])->update(['status' => 2]);

        // Clean up the quiz session
        Session::forget('currentQuiz');

        return view('quiz-result', [
            'resultData' => $resultData,
            'quizName' => $currentQuiz['quizName'],
            'correctAnswers' => $correctAnswers,
        ]);
    }


    // ─── PREVIOUS MCQ ─────────────────────────────────────────────────────────────

    public function previousMcq(Request $request, int $id)
    {
        $currentQuiz = Session::get('currentQuiz');
        $leavingQNum = $currentQuiz['currentMcq'];
        $selectedOption = $request->option ?: null;

        // Mark question we are leaving as visited
        $this->markVisited($currentQuiz, $leavingQNum);

        if ($selectedOption) {
            // User selected an answer before going back — save it
            $this->markAnswered($currentQuiz, $leavingQNum);
            $this->saveRecord($currentQuiz, $id, $selectedOption);
        } else {
            // Going back without selecting — only mark skipped if not already answered
            $alreadyAnswered = in_array($leavingQNum, $currentQuiz['answeredMcqs'] ?? []);
            if (!$alreadyAnswered) {
                $this->markSkipped($currentQuiz, $leavingQNum);
            }
            // DO NOT call saveRecord() here — nothing to save
        }

        // Decrement counter, floor at 1
        if ($currentQuiz['currentMcq'] > 1) {
            $currentQuiz['currentMcq'] -= 1;
        }

        // Load the previous MCQ
        $mcqData = MCQ::where('id', '<', $id)
            ->where('quiz_id', $currentQuiz['quizId'])
            ->orderBy('id', 'desc')
            ->first();

        // Fallback to first question if already at the beginning
        if (!$mcqData) {
            $mcqData = MCQ::where('quiz_id', $currentQuiz['quizId'])
                ->orderBy('id', 'asc')
                ->first();

            $currentQuiz['currentMcq'] = 1;
        }

        Session::put('currentQuiz', $currentQuiz);

        return view('mcq-page', [
            'mcqData' => $mcqData,
            'quizName' => $currentQuiz['quizName'],
            'previousAnswer' => $this->getPreviousAnswer($currentQuiz, $mcqData->id),
        ]);
    }

    function userDetails()
    {
        $quizRecords = Record::WithQuiz()->where('user_id', Session::get('user')['id'])->get();

        foreach ($quizRecords as $record) {
            $record->correct = MCQ_Record::where(['record_id' => $record->id, 'is_correct' => 1])->count();
            $record->total_mcq = MCQ_Record::where('record_id', $record->id)->count();
        }

        return view('user-details', ['quizRecords' => $quizRecords]);
    }

    function quizSearch(Request $request)
    {
        $quizData = Quiz::where('name', 'like', '%' . $request->search . '%')->get();
        return view('quiz-search', ['quizData' => $quizData, 'quiz' => $request->search]);
    }

    function verifyUser($email)
    {
        $orgEmail = Crypt::decryptString($email);
        $user = User::where('email', $orgEmail)->first();
        if ($user) {
            $user->active = 2;
            if ($user->save()) {
                return redirect('/')->with('message-success', 'Email verified successfully! Please login to continue.');
            }
        }
    }

    function userForgotPassword(Request $request)
    {
        $validate = $request->validate([
            'email' => 'required|email',
        ]);
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->withErrors(['user' => 'No user found with this email! Please check your email and try again.']);
        }
        $link = Crypt::encryptstring($user->email);
        $link = url('/user-forgot-password/' . $link);
        Mail::to($user->email)->send(new UserForgotPassword($link));

        //

        return redirect('/')->with('message-success', 'Please check email to set new password.');
    }

    function userResetForgotPassword($email)
    {
        $orgEmail = Crypt::decryptString($email);
        $user = User::where('email', $orgEmail)->first();
        if ($user) {
            return view('user-set-forgot-password', ['email' => $orgEmail]);
        } else {
            return redirect('/')->withErrors(['user' => 'Invalid link! Please try again.']);
        }
    }

    function userSetForgotPassword(Request $request)
    {
        $validate = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);
        $user = User::where('email', $request->email)->first();
        if ($user) {
            $user->password = Hash::make($request->password);
            if ($user->save()) {
                return redirect('/user-login')->with('message', 'Password updated successfully! Please login to continue with new password.');
            }
        } else {
            return redirect('/')->withErrors(['user' => 'No user found with this email! Please check your email and try again.']);
        }
    }

    function userProfile()
    {
        $user = User::find(Session::get('user')['id']);
        $totalQuizzes = Record::where('user_id', $user->id)->count();
        $completedQuizzes = Record::where(['user_id' => $user->id, 'status' => 2])->count();
        $totalCorrect = MCQ_Record::where('user_id', $user->id)->where('is_correct', 1)->count();
        $totalAnswered = MCQ_Record::where('user_id', $user->id)->count();
        $accuracy = $totalAnswered > 0 ? round(($totalCorrect / $totalAnswered) * 100) : 0;

        return view('user-profile', compact('user', 'totalQuizzes', 'completedQuizzes', 'totalCorrect', 'accuracy'));
    }

    function userProfileUpdate(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email,' . Session::get('user')['id'],
        ]);

        $user = User::find(Session::get('user')['id']);
        $user->name = $request->name;
        $user->email = $request->email;

        if ($user->save()) {
            // Update session too
            Session::put('user', [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ]);
            return redirect('/user-profile')->with('message-success', 'Profile updated successfully!');
        }

        return back()->withErrors(['update' => 'Something went wrong! Please try again.']);
    }

    function userPasswordUpdate(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::find(Session::get('user')['id']);

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect!']);
        }

        $user->password = Hash::make($request->password);

        if ($user->save()) {
            return redirect('/user-profile')->with('message-success', 'Password updated successfully!');
        }

        return back()->withErrors(['password' => 'Something went wrong! Please try again.']);
    }

}