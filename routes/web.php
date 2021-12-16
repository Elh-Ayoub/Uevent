<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VerifyEmailController;
use App\Models\Event;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
    Route::get('/', function () {
        return view('welcome');
    });
    Route::get('/home', [EventController::class, 'index'])->name('dashboard');
///////////////////// ---- Authentication Module ---- /////////////////////////////////
Route::group([
    'middleware' => 'AuthCheck',
], function () {
    Route::get('auth/login', function(){
        return view('Auth.login');
    })->name('login');
    Route::get('auth/register', function(){
        return view('Auth.register');
    })->name('register');
    Route::post('auth/login', [AuthController::class, 'login'])->name('auth.login');
    Route::get('auth/logout', [AuthController::class, 'logout'])->name('auth.logout');
    Route::post('auth/register', [AuthController::class, 'register'])->name('auth.register');
});
Route::group([
    'middleware' => 'web',
], function () {
    //  ---------Email verification----------
    Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
    ->middleware(['signed', 'throttle:6,1'])
    ->name('verification.verify');
    Route::post('/email/verify/resend', [VerifyEmailController::class, 'resendVerification'])->name('verification.send');
    Route::get('/email/verify', function(){
        return view('Auth.verifyEmail');
    })->name('verification.resend');
    Route::get('/email/verify/success', function(){
        return redirect('auth/login')->with('success', 'Email verified successfully!');
    });
    Route::get('/email/verify/already-success', function(){
        return redirect('auth/login')->with('success', 'Email already verified! Thank you.');
    });
    // -------password reset --------------
    Route::get('auth/forgot-password', function(){
        return view('Auth.forgot-password');
    })->name('password.forgot');
    Route::get('/reset-password/{token}/{email}', function (Request $request, $token, $email) {
        return view('Auth.reset-password', ['token' => $token, 'email' => $email]);
    })->middleware('guest')->name('password.reset');
    Route::patch('auth/reset-password', [AuthController::class, 'resetPassword'])->middleware('guest')->name('password.update');
    Route::post('auth/forgot-password',[AuthController::class, 'sendResetLink'])->middleware('guest')->name('password.send');
});

///////////////////// ---- Events Module ---- /////////////////////////////////

Route::group([
    'middleware' => 'AuthCheck',
], function () {
    Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
    Route::post('/events/create', [EventController::class, 'store'])->name('events.store');
});

Route::get('/events/{id}', [EventController::class, 'show'])->name('event.details');

///////////////////// ---- Subscriptions/payment Module ---- /////////////////////////////////
Route::group([
    'middleware' => 'AuthCheck',
], function () {
    Route::get('/events/{id}/subscribe', [SubscriptionController::class, 'EventSubscriptionView'])->name('events.sub.view');
    Route::post('/events/{id}/subscribe', [SubscriptionController::class, 'paySubscription'])->name('events.subscribe');
    Route::post('/events/{id}/free-subscribe', [SubscriptionController::class, 'freeSub'])->name('events.free.subscribe');
});

///////////////////// ---- Comments Module ---- /////////////////////////////////
Route::group([
    'middleware' => 'AuthCheck',
], function () {
    Route::post('/events/{id}/comment', [CommentController::class, 'store'])->name('events.comment');
    Route::patch('/comment/{id}/', [CommentController::class, 'update'])->name('events.comment.update');
    Route::delete('/comment/{id}/', [CommentController::class, 'destroy'])->name('events.comment.delete');

///////////////////// ---- user account Module ---- /////////////////////////////////
    Route::get('/users/account/', [UserController::class, 'index'])->name('user.account');
});