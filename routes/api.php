<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\UI\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('users')->group(function () {
    Route::put('{id}', [UserController::class, 'update']);
    Route::post('{id}/deposit', [UserController::class, 'deposit']);
});

Route::post('users/transfer', [UserController::class, 'transfer']);