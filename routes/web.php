<?php

use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('tasks.index');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return redirect()->route('tasks.index');
    })->name('dashboard');

    Route::post('tasks/{task}/refresh-ai', [TaskController::class, 'refreshAi'])->name('tasks.refresh-ai');
    Route::resource('tasks', TaskController::class);
    Route::resource('users', UserController::class);
});

require __DIR__ . '/auth.php';
