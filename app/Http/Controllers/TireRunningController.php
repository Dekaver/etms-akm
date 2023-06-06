<?php

namespace App\Http\Controllers;

use App\Models\TireRunning;
use Illuminate\Http\Request;

class TireRunningController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("admin.data.tirerunning");
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
    public function show(TireRunning $tireRunning)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TireRunning $tireRunning)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TireRunning $tireRunning)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TireRunning $tireRunning)
    {
        //
    }
}
