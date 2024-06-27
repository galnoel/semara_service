<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use Illuminate\Support\Facades\Validator;
use Exception;

class AppointmentController extends Controller
{
    // Get all appointments
    public function index()
    {
        try {
            $userId = auth()->id();

            $appointments = Appointment::where('user_id', $userId)->get();
            return response()->json([
                'status' => 200,
                'appointments' => $appointments
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 500,
                'message' => $th->getMessage()
            ]);
        }
    }

    // Get a specific appointment by ID
    public function show($id)
    {
        try {
            $userId = auth()->id();

            $appointment = Appointment::find($id);

            if (!$appointment) {
                return response()->json([
                    'status'=> 404,
                    'message' => 'Appointment not found'
                ]);
            }

            if ($appointment->user_id !== $userId) {
                return response()->json([
                    'status'=> 200,
                    'message' => 'Unauthorized'
                ]);
            }

            return response()->json([
                'status' => true,
                'appointment' => $appointment
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    // Create a new appointment
    public function store(Request $request)
    {
        try {
            $user = $request->user();

            if (!$user) {
                throw new Exception('Unauthorized access');
            }

            $validator = Validator::make($request->all(), [
                'title' => 'required|string|max:255',
                'doctor_name' => 'required|string|max:255',
                'appointment_datetime' => 'required|date_format:Y-m-d H:i:s',
                // 'location' => 'required|string|max:255',
                'status' => 'nullable|string|in:scheduled,canceled,completed',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 422  );
            }

            $appointment = Appointment::create([
                'user_id' => $request->user()->id,
                'title' => $request->title,
                'doctor_name' => $request->doctor_name,
                'appointment_datetime' => $request->appointment_datetime,
                // // 'location'=>$request->location,
                'status' => $request->status ?? 'scheduled',
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Appointment created successfully',
                'appointment' => $appointment
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    // Update an existing appointment
    public function update(Request $request, $appointmentId)
    {
        try {
            $validator = Validator::make($request->all(), [
                'title' => 'sometimes|required|string|max:255',
                'doctor_name' => 'sometimes|required|string|max:255',
                'appointment_datetime' => 'sometimes|required|date_format:Y-m-d H:i:s',
                // 'location' => 'sometimes|string|max:255',
                'status' => 'nullable|string|in:scheduled,canceled,completed',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $appointment = Appointment::findOrFail($appointmentId);

            $user_id = $request->user()->id;
            if ($appointment->user_id !== $user_id) {
                return response()->json([
                    'status' =>403,
                    'message' => 'Unauthorized',
                    'body'=> $user_id
                ]);
            }
    
            // Update fields using provided values or keep existing values if not provided
            $appointment->title = $request->title ?? $appointment->title;
            $appointment->doctor_name = $request->doctor_name ?? $appointment->doctor_name;
            $appointment->appointment_datetime = $request->appointment_datetime ?? $appointment->appointment_datetime;
            // // // $appointment->location = $request->location ?? $appointment->location;
            $appointment->status = $request->status ?? $appointment->status;
            $appointment->save();

            return response()->json([
                'status' => true,
                'message' => 'Appointment updated successfully',
                'appointment' => $appointment
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    // Delete an appointment
    public function destroy($id)
    {
        try {
            $appointment = Appointment::findOrFail($id);

            $user_id = auth()->id();
            if ($appointment->user_id !== $user_id) {
                return response()->json([
                    'status' => 403,
                    'message' => 'Unauthorized',
                ]);
            }

            $appointment->delete();

            return response()->json([
                'status' => true,
                'message' => 'Appointment deleted successfully'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
