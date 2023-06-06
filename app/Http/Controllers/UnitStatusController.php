<?php

namespace App\Http\Controllers;

use App\Models\UnitStatus;
use Illuminate\Http\Request;

class UnitStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("admin.data.unitstatus");
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
    public function show(UnitStatus $unitStatus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UnitStatus $unitStatus)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UnitStatus $unitStatus)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UnitStatus $unitStatus)
    {
        //
    }
}
