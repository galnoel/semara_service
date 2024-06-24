<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\MedicationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoutineController;
use App\Http\Controllers\RoutineCompletionController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::controller(AuthenticationController::class)->group(function(){
    Route::post('/auth/register', 'store');
    Route::post('/auth/login', 'login');
});

Route::middleware('auth:sanctum')->group(function(){
    Route::controller(RoutineController::class)->group(function () {
        Route::get('/user/routines', 'userRoutines');
        Route::get('routines', 'getAllRoutine');
        Route::post('routines', 'store');
        Route::get('/routines/{routineId}', 'index');
        Route::patch('/routines/{routineId}', 'update'); 
        Route::delete('/routines/{routineId}', 'destroy');
    });
});

Route::middleware('auth:sanctum')->group(function(){
    Route::controller(MedicationController::class)->group(function(){
        Route::get('/medication/{medication_id}', 'index');
        Route::post('medication', 'store');
        Route::get('/user/medications', 'userMedications');
        Route::patch('/medication/{medication_id}', 'update'); 
        Route::delete('/medication/{medicationId}', 'destroy');
    });
});

Route::middleware('auth:sanctum')->group(function(){
    Route::post('/auth/logout', [AuthenticationController::class, 'logout']);
});

Route::post('/routines/{routineId}/completions', [RoutineCompletionController::class, 'create']);


// Route::post('storeRoutines', [RoutinesController::class, 'store']);
// Route::get('routines', [RoutinesController::class, 'getAllRoutines']);







