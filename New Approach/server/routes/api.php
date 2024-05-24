<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;

Route::get('/hello', function () {
    return 'Hello, World!';
});

Route::post("register", [AuthController::class, "register"]);
Route::post("login", [AuthController::class, "login"]);

Route::group([
    "middleware" => ["auth:api"]
], function(){

    Route::get("profile", [AuthController::class, "profile"]);
    Route::get("refresh", [AuthController::class, "refreshToken"]);
    Route::get("logout", [AuthController::class, "logout"]);
    Route::get("users", [AuthController::class, "indexUsers"]);
});