<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\auth\AuthController;
// user login routes
use App\Http\Controllers\programs\ProgramController;

Route::post('/login', [AuthController::class, 'login'])->name("login");

Route::middleware('auth:sanctum')->group(function () {
Route::post('/logout', [AuthController::class, 'logout']);

    // Program routes
      Route::group(['prefix' => 'programs'], function () {
        Route::post('/bulk-register', [ProgramController::class, 'bulkRegisterProgram']);
        Route::get('/download-sample', [ProgramController::class, 'downloadSampleProgram']);
        Route::post('/register', [ProgramController::class, 'store']);
        Route::get('/list', [ProgramController::class, 'index']);
        Route::get('/details', [ProgramController::class, 'show']);
        Route::put('/update', [ProgramController::class, 'update']);
        Route::delete('/delete', [ProgramController::class, 'destroy']);
       
    });


});
Route::middleware('auth:sanctum')->get('/debug-user', function (Request $request) {
    return $request->user(); // should return user object
});

