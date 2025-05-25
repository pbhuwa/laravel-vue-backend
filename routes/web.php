<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';

Route::get('/', fn () => redirect()->route('login'))
    ->name('home');

Route::group([ 'middleware' => ['authenticated']], function () {
    Route::get('dashboard', fn () => Inertia::render('Dashboard'))
        ->middleware(['auth', 'verified'])->name('dashboard');
});

Route::middleware(['authenticated'])->group(function () {
    Route::get('settings', [\App\Http\Controllers\Settings\ProfileController::class, 'settings'])
        ->name('profile.settings');

    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');
});

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');
});
