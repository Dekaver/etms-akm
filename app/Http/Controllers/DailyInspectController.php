<?php

namespace App\Http\Controllers;

use App\Models\DailyInspect;
use Illuminate\Http\Request;

class DailyInspectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("admin.history.dailyinspect");
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
    }

    /**
     * Display the specified resource.
     */
    public function show(DailyInspect $dailyInspect)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DailyInspect $dailyInspect)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DailyInspect $dailyInspect)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DailyInspect $dailyInspect)
    {
        //
    }
}
