<?php

namespace App\Http\Controllers;

use App\Models\Routine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
use Exception;

class RoutineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($routineId){
         // Get the authenticated user's ID
        $userId = auth()->id();

        // Find the routine by ID
        $routine = Routine::find($routineId);

        // Check if the routine exists
        if (!$routine) {
            return response()->json([
                'status'=> 404,
                'message' => 'Routine not found'
            ]);
        }

        // Check if the routine belongs to the authenticated user
        if ($routine->user_id !== $userId) {
            return response()->json([
                'status'=> 200,
                'message' => 'Unauthorized'
            ]);
        }

        // Return the routine in a JSON response
        return response()->json([
            'status'=> 200,
            'body' => $routine
        ]);
    }
    
    public function getAllRoutine()
    {
        $Routine = Routine::all(); // Fetch all Routine from the database

        return response()->json($Routine, 200);
    }
    public function userRoutines()
    {
         // Get the authenticated user's ID
        $userId = auth()->id();

        // Retrieve all routines for the authenticated user
        $routines = Routine::where('user_id', $userId)->get();

        // Return the routines in a JSON response
        return response()->json([
            'status'=> 200,
            'body' => $routines
        ]);
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        try{
            $user = $request->user();

            if (!$user) {
                throw new Exception('Unauthorized access');
            }
            $validator = Validator::make($request->all(), [
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                //'days' => 'required|array|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
                'start_time' => 'required|date_format:H:i',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status'=> false,
                    'message'=>'validation error',
                    'errors'=>$validator->errors()
                ], 422);
            }

            $routine = Routine::create([
                'user_id' => $request-> user()->id,
                'title' => $request->title,
                'description' => $request->description,
                //'days' => json_encode($request->days),
                'start_time' => $request->start_time,
            ]);

            return response()->json([
                'status'=> true,
                'message'=>'Routine created successfully',
                'routine' => $routine
            ], 201);

        }catch(\Throwable $th){
            return response()->json([
                'status'=> false,
                'message'=>$th->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $routineId)
    {
        
        $validator = Validator::make($request->all(), [
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'start_time' => 'nullable|string|date_format:H:i', // Assuming hh:mm format
            //'days' => 'nullable|array', // Assuming JSON array of days (e.g., ["monday", "wednesday"])
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'=> 422,
                'message'=>'validation error',
                'errors'=>$validator->errors()
            ]);
        }
        
        $routine = Routine::findOrFail($routineId);

        $user_id = $request->user()->id;
        if ($routine->user_id !== $user_id) {
            return response()->json([
                'status' =>403,
                'message' => 'Unauthorized',
                'body'=> $user_id
            ]);
        }

        // Update fields using provided values or keep existing values if not provided
        $routine->title = $request->title ?? $routine->title;
        $routine->description = $request->description ?? $routine->description;
        $routine->start_time = $request->start_time ?? $routine->start_time;
        //$routine->days = $request->days ?? $routine->days; // Assuming JSON array format

        $routine->save();

        return response()->json([
            'status'=> 200,
            'message'=>'Routine updated successfully',
            'routine' => $routine
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store2(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Routine $Routine)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Routine $Routine)
    {
        //
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Routine $Routine)
    {
        //
    }

    

}
