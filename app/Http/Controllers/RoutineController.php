<?php

namespace App\Http\Controllers;

use App\Models\Routine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreRoutineRequest;
use App\Http\Requests\UpdateRoutineRequest;
use Auth;
use Exception;

class RoutineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getAllRoutine()
    {
        $Routine = Routine::all(); // Fetch all Routine from the database

        return response()->json($Routine, 200);
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
                'message'=>'User created successfully',
                'routine' => $routine
            ], 201);

        }catch(\Throwable $th){
            return response()->json([
                'status'=> false,
                'message'=>$th->getMessage()
            ], 500);
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store2(StoreRoutineRequest $request)
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
     * Update the specified resource in storage.
     */
    public function update(UpdateRoutineRequest $request, Routine $Routine)
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

    public function updateRoutine(Request $request, $routineId)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'time' => 'nullable|string|date_format:H:i', // Assuming hh:mm format
            'days' => 'nullable|array', // Assuming JSON array of days (e.g., ["monday", "wednesday"])
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $routine = Routine::findOrFail($routineId);

        // Update fields using provided values or keep existing values if not provided
        $routine->name = $request->name ?? $routine->name;
        $routine->description = $request->description ?? $routine->description;
        $routine->time = $request->time ?? $routine->time;
        $routine->days = $request->days ?? $routine->days; // Assuming JSON array format

        $routine->save();

        return response()->json($routine, 200);
    }

}
