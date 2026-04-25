<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CheatSheetController;

// User Routes
Route::get('/', [UserController::class, 'welcome'])->name('welcome');
Route::get('user-quiz-list/{id}/{category}', [UserController::class,'userQuizList']);

Route::get('user-signup', function(){
    if(!session()->has('user')){
        return view('user-signup');
    }else{
        return redirect('/');
    }
});
// Route::view('user-signup', 'user-signup');
Route::post('user-signup', [UserController::class,'userSignup']);
Route::get('start-quiz/{id}/{name}', [UserController::class,'startQuiz']);
Route::get('user-logout', [UserController::class,'userLogout']);
Route::get('user-signup-start', [UserController::class,'userSignupStart']);

Route::get('user-login', function(){
    if(!session()->has('user')){
        return view('user-login');
    }else{
        return redirect('/');
    }
});
// Route::view('user-login', 'user-login');
Route::post('user-login', [UserController::class,'userLogin']);
Route::get('user-login-start', [UserController::class,'userLoginStart']);
Route::get('/quiz-search', [UserController::class, 'quizSearch'])->name('quiz.search');
Route::get('categories-list', [UserController::class,'categories']);

Route::get('verify-user/{email}', [UserController::class,'verifyUser']);
Route::view('user-forgot-password', 'user-forgot-password');
Route::post('user-forgot-password', [UserController::class,'userForgotPassword']);
Route::get('user-forgot-password/{email}', [UserController::class,'userResetForgotPassword']);
Route::post('user-set-forgot-password', [UserController::class,'userSetForgotPassword']);

Route::middleware('CheckUserAuth')->group(function(){
    Route::get('mcq/{id}/{name}', [UserController::class,'mcq']);
    Route::post('submit-next/{id}', [UserController::class,'submitAndNext']);
    Route::post('previous-mcq/{id}', [UserController::class, 'previousMcq']);
    Route::get('user-details', [UserController::class, 'userDetails']);
    Route::get('user-profile', [UserController::class, 'userProfile']);
    Route::post('user-profile-update', [UserController::class, 'userProfileUpdate']);
    Route::post('user-password-update', [UserController::class, 'userPasswordUpdate']);
});


Route::get('/user-quiz-list/{category}/{name}', [UserController::class, 'quizList'])->name('user.quiz.list');
Route::get('/start-quiz/{id}/{name}', [UserController::class, 'startQuiz'])->name('quiz.start');

// Admin Routes
Route::view('admin-login', 'admin-login');
Route::post('admin-login', [AdminController::class,'login']);

Route::middleware('CheckAdminAuth')->group(function(){
    Route::get('dashboard', [AdminController::class,'dashboard']);
    Route::get('admin-categories', [AdminController::class,'categories']);
    Route::get('admin-logout', [AdminController::class,'logout']);
    Route::post('add-category', [AdminController::class,'addCategory']);
    Route::get('category/delete/{id}', [AdminController::class,'deleteCategory']);
    Route::get('add-quiz', [AdminController::class,'addQuiz']);
    Route::post('add-mcq', [AdminController::class,'addMCQs']);
    Route::get('end-quiz', [AdminController::class,'endQuiz']);
    Route::get('show-quiz/{id}/{quizName}', [AdminController::class,'showQuiz']);
    Route::get('quiz-list/{id}/{category}', [AdminController::class,'quizList']);
});

// Cheat Sheets Routes
Route::prefix('cheat-sheets')->name('cheat-sheets.')->group(function () {
    Route::get('/', [CheatSheetController::class, 'index'])->name('index');
    Route::get('/search', [CheatSheetController::class, 'search'])->name('search');
    Route::get('/{slug}', [CheatSheetController::class, 'show'])->name('show');
    Route::get('/{slug}/download', [CheatSheetController::class, 'download'])->name('download');
    Route::get('/cheat-sheets/{slug}/download', [CheatSheetController::class, 'download'])->name('cheat-sheets.download');
});
