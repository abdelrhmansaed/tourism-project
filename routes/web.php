<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

//Route::get('/', function () {
//    return view('welcome');
//});
//

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('auth.register');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// تسجيل خروج لكل مستخدم (Admin, Provider, Agent)
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');
Route::post('/provider/logout', [AuthController::class, 'logout'])->name('provider.logout');
Route::post('/agent/logout', [AuthController::class, 'logout'])->name('agent.logout');

Route::middleware(['role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('Dashboard.admin.index');
    })->name('admin.dashboard');
});

Route::middleware(['role:provider'])->group(function () {
    Route::get('/provider/dashboard', function () {
        return view('Dashboard.provider.index');
    })->name('provider.dashboard');
});

Route::middleware(['role:agent'])->group(function () {
    Route::get('/agent/dashboard', function () {
        return view('Dashboard.agent.index');
    })->name('agent.dashboard');
});
