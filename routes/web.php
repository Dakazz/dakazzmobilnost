<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $user = Auth::user();

    if (!$user) {
        return redirect()->route('login');
    }

    return match ((int)$user->type) {
        0 => redirect()->route('adminDashboardShow'),
        1 => redirect()->route('profesorDashboardShow'),
    };
})->middleware(['auth', 'verified']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('adminAuth')->prefix('admin')->group(function(){
    Route::get('/dashboard', [DashboardController::class, 'adminDashboard'])->name('adminDashboardShow');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
});

Route::middleware('profesorAuth')->prefix('profesor')->group(function(){
    Route::get('/dashboard', [DashboardController::class, 'profesorDashboard'])->name('profesorDashboardShow');
});

require __DIR__.'/auth.php';
