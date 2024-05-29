<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\routine_completions;
use App\Models\routines;
use App\Http\Requests\Storeroutine_completionsRequest;
use App\Http\Requests\Updateroutine_completionsRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RoutineCompletionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    //  public function markCompleted(Request $request, $routineId)
    //  {
    //     $validator = Validator::make($request->all(), [
    //         'completed_at' => 'nullable|date_format:Y-m-d\TH:i', // Optional for marking past completions
    //     ]);
 
    //     if ($validator->fails()) {
    //         return response()->json($validator->errors(), 422);
    //     }
        
    //     $routine = routines::findOrFail($routineId);
    
    //      // Define a threshold (e.g., 30 minutes) for allowed time difference
    //     $allowedTimeDifference = now()->subMinutes(60);
    //      // Check if routine time allows marking as completed based on current time and threshold
    //     $routineTimeString = $routine->time; // Assuming hh:mm format

    //     // Assuming routines and current time are in the same timezone
    //     $routineTime = Carbon::parse($routineTimeString); 
    //     $routineTime->setTimezone(now()->timezone); // Set the same timezone as current time

    //     $currentTime = Carbon::parse(now()->format('Y-m-d') . ' ' . $routineTimeString); // Combine current date with routine time

    //     if ($currentTime > $allowedTimeDifference) {
    //         return response()->json(['error' => 'Routine time has passed. Cannot mark complete.'], 422);
    //     }

    //     $completion = routine_completions::create([
    //         'routine_id' => $routineId,
    //         'completed_at' => $request->completed_at ?? now(), // Use current time if not provided
    //     ]);
 
    //     return response()->json($completion, 201);
    //  }

    public function markCompleted(Request $request, $routineId)
    {
        $validator = Validator::make($request->all(), [
            'completed_at' => 'nullable|date_format:Y-m-d\TH:i', // Optional for marking past completions
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $completion = routine_completions::create([
            'routine_id' => $routineId,
            'completed_at' => $request->completed_at ?? now(), // Use current time if not provided
        ]);

        return response()->json($completion, 201);
    }
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Storeroutine_completionsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(routine_completions $routine_completions)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(routine_completions $routine_completions)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Updateroutine_completionsRequest $request, routine_completions $routine_completions)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(routine_completions $routine_completions)
    {
        //
    }
}
