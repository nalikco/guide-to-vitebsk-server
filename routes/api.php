<?php

declare(strict_types=1);

use App\Http\Controllers\Authenticate\AuthenticateController;
use App\Http\Controllers\Users\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/login', AuthenticateController::class)->name('login');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', UserController::class)->name('user');
});
