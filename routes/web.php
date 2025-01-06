<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;

// Ensure the LoginController class exists in the specified namespace
// If it doesn't exist, create the class in the specified namespace
Route::get('/', function () {
    return view('welcome');
});



// // Login routes
// Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
// Route::post('/login', [LoginController::class, 'login']);
// Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// // Protected routes
// Route::middleware(['auth'])->group(function () {
//     Route::get('/', function () {
//         return view('dashboard');
//     })->name('home');
// });

// // Redirect unauthenticated users to login
// Route::get('/', function () {
//     return redirect('/login');
// })->middleware('guest');



// use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\Auth\LoginController;

// // Guest routes
// Route::middleware(['guest'])->group(function () {
//     Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
//     Route::post('/login', [LoginController::class, 'login']);
// });

// // Protected routes
// Route::middleware(['auth'])->group(function () {
//     Route::get('/', function () {
//         return view('dashboard');
//     })->name('home');
    
//     Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
// });

// // Redirect root to dashboard if authenticated, otherwise to login
// Route::get('/', function () {
//     return redirect('/');
// });