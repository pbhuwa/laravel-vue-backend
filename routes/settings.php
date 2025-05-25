<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Settings\ProfileController;
use App\Http\Controllers\Settings\PasswordController;

Route::middleware('auth:api')->group(function ($router) {
    $router->patch('settings/profile', [ProfileController::class, 'update'])->name('profile.update');
    $router->delete('settings/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    $router->put('settings/password', [PasswordController::class, 'update'])->name('password.update');
});
