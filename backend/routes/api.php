<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CandidateProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->get('/profile', function(Request $request){
    return response()->json([
        'user' => $request->user(),
    ]);
});

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

});

//Candidate Routes
Route::prefix('candidate')->
    middleware(['auth:sanctum', 'role:candidate'])->
    group(function(){
        Route::get('/dashboard', function(){return response()->json([
                    'message' => 'Welcome Candidate!'
                ]); });

        Route::post('/profile', [CandidateProfileController::class, 'store']);
        Route::get('/profile', [CandidateProfileController::class, 'show']);
        Route::put('/profile', [CandidateProfileController::class, 'update']);

});

//Employer Routes
Route:: middleware(['auth:sanctum', 'role:employer'])->group(function(){
    Route::get('/employer/dashboard', function(){
          return response()->json([
                'message' => 'Welcome Employer!'
            ]);
    });
});

//Admin Routes
Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {

        Route::get('/admin/dashboard', function () {

            return response()->json([
                'message' => 'Welcome Admin!'
            ]);

        });

    });
