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
        

        Route::post('/profile', [CandidateProfileController::class, 'store']);
        Route::get('/profile', [CandidateProfileController::class, 'show']);
        Route::put('/profile', [CandidateProfileController::class, 'update']);
        Route::post('/resume', [CandidateProfileController::class, 'uploadResume']);
        Route::post('/avatar', [CandidateProfileController::class, 'uploadAvatar']);
        Route::get('/education', [CandidateProfileController::class, 'indexEducation']);
        Route::post('/education', [CandidateProfileController::class, 'storeEducation']);
        Route::put('/education/{id}', [CandidateProfileController::class, 'updateEducation']);
        Route::delete('/education/{id}', [CandidateProfileController::class, 'deleteEducation']);
        Route::post('/experience', [CandidateProfileController::class, 'storeExperience']);
        Route::get('/experience', [CandidateProfileController::class, 'indexExperience']);
        Route::put('/experience/{id}', [CandidateProfileController::class, 'updateExperience']);
        Route::delete('/experience/{id}', [CandidateProfileController::class, 'deleteExperience']);
        Route::get('/skills', [CandidateProfileController::class, 'indexSkills']);
        Route::post('/skills', [CandidateProfileController::class, 'storeSkills']);
        Route::put('/skills', [CandidateProfileController::class, 'updateSkills']);
        Route::delete('/skills/{skillId}', [CandidateProfileController::class, 'deleteSkill']);
        Route::get('/dashboard', [CandidateProfileController::class, 'dashboard']);
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
