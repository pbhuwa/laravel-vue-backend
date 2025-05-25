<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;

Route::middleware('guest')->group(function ($router) {
    $router->post('register', [RegisteredUserController::class, 'store']);
    $router->post('login', [AuthenticatedSessionController::class, 'store']);
    $router->post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');
    $router->post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
});

Route::middleware('authenticated')->group(function ($router) {
    $router->post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');
    $router->post('confirm-password', [ConfirmablePasswordController::class, 'store']);
    $router->post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});
