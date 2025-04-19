<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::group([ 'middleware' => ['authenticated'], ], function () {
    Route::get('dashboard', function () {
        return Inertia::render('Dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');
});

Route::get('/', function () {
    return redirect()->route('login');
})->name('home');


require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
