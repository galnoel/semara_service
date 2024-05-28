<?php

namespace App\Http\Controllers;

use App\Models\routine_completions;
use App\Http\Requests\Storeroutine_completionsRequest;
use App\Http\Requests\Updateroutine_completionsRequest;

class RoutineCompletionsController extends Controller
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
