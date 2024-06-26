<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', function () {
    return view('welcome');
});

// Handling unauthenticated routes // Testing
Route::get( '/unauthenticated', [AuthController::class, 'unauthenticated'])->name('login');
