<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CompanyController;
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
    // ----------Social media Authentication----------
    //Google
    Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('auth.google');
    Route::get('/auth/google/callback', [AuthController::class, 'hundelGoogleCallback']);
    //Facebook
    Route::get('/auth/facebook', [AuthController::class, 'redirectToFacebook'])->name('auth.facebook');
    Route::get('/auth/facebook/callback', [AuthController::class, 'hundelFacebookCallback']);
    //github
    Route::get('/auth/github', [AuthController::class, 'redirectToGithub'])->name('auth.github');
    Route::get('/auth/github/callback', [AuthController::class, 'hundelGithubCallback']);

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
    Route::get('/events/{id}/edit', [EventController::class, 'edit'])->name('events.edit');
    Route::patch('/events/{id}/edit', [EventController::class, 'update'])->name('events.update');
    Route::post('/events/{id}/notify', [EventController::class, 'NotifyVisitors'])->name('events.notification');
    Route::delete('/events/{id}', [EventController::class, 'destroy'])->name('event.destroy');

});

Route::get('/events/{id}', [EventController::class, 'show'])->name('event.details');

///////////////////// ---- Subscriptions/payment Module ---- /////////////////////////////////
Route::group([
    'middleware' => 'AuthCheck',
], function () {
    Route::get('/events/{id}/subscribe', [SubscriptionController::class, 'EventSubscriptionView'])->name('events.sub.view');
    Route::get('/events/{id}/subscribe/notification', [SubscriptionController::class, 'subscribe2notif'])->name('events.sub.notif');
    Route::post('/events/{id}/subscribe', [SubscriptionController::class, 'paySubscription'])->name('events.subscribe');
    Route::post('/events/{id}/free-subscribe', [SubscriptionController::class, 'freeSub'])->name('events.free.subscribe');
    //ticket invoice
    Route::get('/ticket/{id}', [SubscriptionController::class, 'invoice'])->name('ticket.invoice');
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
    Route::patch('profile/update/{id}', [UserController::class, 'update'])->name('user.update');
    Route::patch('password/update/', [UserController::class, 'UpdatePassword'])->name('user.password.update');
    Route::patch('avatar/update', [UserController::class, 'UpdateAvatar'])->name('user.avatar.update');
    Route::delete('avatar/delete', [UserController::class, 'setDefaultAvatar'])->name('user.avatar.delete');    
    Route::delete('user/delete', [UserController::class, 'destroyAuthUser'])->name('user.delete');
    //--Company entity--
    Route::post('/users/company', [CompanyController::class, 'store'])->name('company.create');
    Route::patch('/users/company/{id}', [CompanyController::class, 'update'])->name('company.update');
    Route::delete('/users/company/{id}', [CompanyController::class, 'destroy'])->name('company.delete');
});
//--Contact us--
Route::get('/Contact-us/', [UserController::class, 'contactUsView'])->name('contact.view');
Route::post('/Contact-us/', [UserController::class, 'contactUs'])->name('contact.send');