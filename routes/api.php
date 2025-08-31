<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\auth\AuthController;
// user login routes
use App\Http\Controllers\programs\ProgramController;

Route::post('/login', [AuthController::class, 'login'])->name("login");

// Route::middleware('auth:sanctum')->group(function () {
Route::post('/logout', [AuthController::class, 'logout']);

    // Program routes
      Route::group(['prefix' => 'programs'], function () {
        Route::get('/list', [ProgramController::class, 'index']);
        Route::get('/{id}', [ProgramController::class, 'show']);
        Route::post('/register', [ProgramController::class, 'store']);
        Route::put('/{id}', [ProgramController::class, 'update']);
        Route::delete('/{id}', [ProgramController::class, 'destroy']);
        Route::post('/bulk-register', [ProgramController::class, 'bulkRegisterProgram']);
         Route::get('/download-sample', [ProgramController::class, 'downloadSampleProgram']);


    });


// });
Route::middleware('auth:sanctum')->get('/debug-user', function (Request $request) {
    return $request->user(); // should return user object
});

