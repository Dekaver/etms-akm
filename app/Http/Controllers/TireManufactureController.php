<?php

namespace App\Http\Controllers;

use App\Models\TireManufacture;
use Illuminate\Http\Request;

class TireManufactureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("admin.master.tiremanufacture");
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
    public function show(TireManufacture $tireManufacture)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TireManufacture $tireManufacture)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TireManufacture $tireManufacture)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TireManufacture $tireManufacture)
    {
        //
    }
}
