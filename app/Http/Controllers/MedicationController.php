<?php

namespace App\Http\Controllers;

use App\Models\Medication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

class MedicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($medicationId)
    {
        //
         // Get the authenticated user's ID
         $userId = auth()->id();

         // Find the medication by ID
         $medication = Medication::find($medicationId);
 
         // Check if the medication exists
         if (!$medication) {
             return response()->json([
                 'status'=> 404,
                 'message' => 'Medication not found'
             ]);
         }
 
         // Check if the medication belongs to the authenticated user
         if ($medication->user_id !== $userId) {
             return response()->json([
                 'status'=> 200,
                 'message' => 'Unauthorized'
             ]);
         }
 
         // Return the medication in a JSON response
         return response()->json([
             'status'=> 200,
             'body' => $medication
         ]);
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
    public function store(Request $request)
    {
        //
        try{
            $user = $request->user();

            if (!$user) {
                throw new Exception('Unauthorized access');
            }
            $validator = Validator::make($request->all(), [
                'medication_name' => 'required|string|max:255',
                'dosage' => 'required|string|max:255',
                'frequency' => 'required|string|max:255',
                'interval' => 'required|integer|min:1',
                'before_eat' => 'nullable|boolean',
                'is_active' => 'nullable|boolean',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status'=> false,
                    'message'=>'validation error',
                    'errors'=>$validator->errors()
                ], 422);
            }

            $medication = Medication::create([
                'user_id' => $request-> user()->id,
                'medication_name' => $request->medication_name,
                'dosage' => $request->dosage,
                'frequency' => $request->frequency,
                'interval' => $request->interval,
                'before_eat' => $request->before_eat,
                'is_active' => $request->is_active,
            ]);

            return response()->json([
                'status'=> true,
                'message'=>'Medication created successfully',
                'medication' => $medication
            ], 201);

        }catch(\Throwable $th){
            return response()->json([
                'status'=> false,
                'message'=>$th->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Medication $medication)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Medication $medication)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Medication $medication)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Medication $medication)
    {
        //
    }
}
