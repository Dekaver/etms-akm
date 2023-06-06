<?php

namespace App\Http\Controllers;

use App\Models\TireSize;
use Illuminate\Http\Request;

class TireSizeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("admin.master.tiresize");
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
    public function show(TireSize $tireSize)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TireSize $tireSize)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TireSize $tireSize)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TireSize $tireSize)
    {
        //
    }
}
