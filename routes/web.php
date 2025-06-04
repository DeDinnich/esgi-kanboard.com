<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\ContactController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LandingController;

Route::view('/', 'pages.landing.index')->name('home');
Route::view('/about', 'pages.landing.about')->name('about');
Route::get('/prices', [LandingController::class, 'prices'])->name('prices');

Route::post('/contact/send', [ContactController::class, 'send'])->name('contact.send');

Route::post('/stripe/pay', [PaymentController::class, 'pay'])->name('stripe.pay');
Route::post('/stripe/confirm', [PaymentController::class, 'confirm'])->name('stripe.confirm');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect()->route('login');
})->name('logout');

Route::get('/email/verify-purchase/{user}', [AuthController::class, 'verify'])->name('verify-purchase-email');

Route::get('/password/ask-email', [AuthController::class, 'showAskEmail'])->name('password.ask');
Route::post('/password/email', [AuthController::class, 'sendResetLink'])->name('password.email');

Route::get('/password/reset/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
Route::post('/password/reset', [AuthController::class, 'resetPassword'])->name('password.update');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', fn () => view('pages.dashboard.home'))->name('dashboard');
    Route::get('/profile', fn () => view('pages.dashboard.profile'))->name('profile');
    Route::put('/profile/update', [AuthController::class, 'updateProfile'])->name('profile.update');
});
