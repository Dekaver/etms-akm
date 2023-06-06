<?php

namespace App\Http\Controllers;

use App\Models\TireMovement;
use Illuminate\Http\Request;

class TireMovementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("admin.data.tiremovement");
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
    public function show(TireMovement $tireMovement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TireMovement $tireMovement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TireMovement $tireMovement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TireMovement $tireMovement)
    {
        //
    }
}
