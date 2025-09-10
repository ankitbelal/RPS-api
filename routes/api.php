<?php

use App\Http\Controllers\SubjectController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\auth\AuthController;
// user login routes

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    // Route::get('/user', function (Request $request) {
    //     return $request->user();
    // });

    Route::resource('/subjects',SubjectController::class);

    Route::post('/logout', [AuthController::class, 'logout']);


});