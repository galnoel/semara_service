<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoutinesController;
use App\Http\Controllers\RoutineCompletionsController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Route::post('storeRoutines', [RoutinesController::class, 'store']);
// Route::get('routines', [RoutinesController::class, 'getAllRoutines']);

Route::controller(RoutinesController::class)->group(function () {
    Route::get('routines', 'getAllRoutines');
    Route::post('routines', 'store');
});

Route::post('/routines/{routineId}/completions', [RoutineCompletionsController::class, 'markCompleted']);