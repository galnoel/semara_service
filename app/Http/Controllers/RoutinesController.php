<?php

namespace App\Http\Controllers;

use App\Models\routines;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreroutinesRequest;
use App\Http\Requests\UpdateroutinesRequest;

class RoutinesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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
        $validator = Validator::make($request->all(), [
            //'user_id'=> 'required',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'days' => 'required|array|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'time' => 'required|date_format:H:i',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $routine = routines::create([
            //'user_id' => Auth::id(),
            //'user_id' => $request->user_id,
            'name' => $request->name,
            'description' => $request->description,
            'days' => json_encode($request->days),
            'time' => $request->time,
        ]);

        return response()->json($routine, 201);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store2(StoreroutinesRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(routines $routines)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(routines $routines)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateroutinesRequest $request, routines $routines)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(routines $routines)
    {
        //
    }
}
