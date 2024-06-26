<?php

use App\Http\Controllers\AppointmentController;
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
        Route::get('/user/routines', 'index');
        Route::get('routines', 'getAllRoutine');
        Route::post('routines', 'store');
        Route::get('/routines/{routineId}', 'show');
        Route::patch('/routines/{routineId}', 'update'); 
        Route::delete('/routines/{routineId}', 'destroy');
    });
});

Route::middleware('auth:sanctum')->group(function(){
    Route::controller(MedicationController::class)->group(function(){
        Route::get('/user/medications', 'index');
        Route::post('medication', 'store');
        Route::get('/medication/{medication_id}', 'show');
        Route::patch('/medication/{medication_id}', 'update'); 
        Route::delete('/medication/{medicationId}', 'destroy');
    });
});


Route::middleware('auth:sanctum')->group(function(){
    Route::controller(AppointmentController::class)->group(function(){
        Route::get('/user/appointment', 'index');
        Route::post('appointment', 'store');
        Route::get('/appointment/{appointment_id}', 'show');
        Route::patch('/appointment/{appointment_id}', 'update'); 
        Route::delete('/appointment/{appointmentId}', 'destroy');
    });
});

Route::middleware('auth:sanctum')->group(function(){
    Route::post('/auth/logout', [AuthenticationController::class, 'destroy']);
});

Route::post('/routines/{routineId}/completions', [RoutineCompletionController::class, 'store']);


// Route::post('storeRoutines', [RoutinesController::class, 'store']);
// Route::get('routines', [RoutinesController::class, 'getAllRoutines']);







