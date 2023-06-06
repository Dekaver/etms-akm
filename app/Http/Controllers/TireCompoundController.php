<?php

namespace App\Http\Controllers;

use App\Models\TireCompound;
use Illuminate\Http\Request;

class TireCompoundController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("admin.master.tirecompound");
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
    public function show(TireCompound $tireCompound)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TireCompound $tireCompound)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TireCompound $tireCompound)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TireCompound $tireCompound)
    {
        //
    }
}
