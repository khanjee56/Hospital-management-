<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;



Auth::routes();

// Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, ''])
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
