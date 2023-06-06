<?php

namespace App\Http\Controllers;

use App\Models\UnitModel;
use Illuminate\Http\Request;

class UnitModelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("admin.data.unitmodel");
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
    public function show(UnitModel $unitModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UnitModel $unitModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UnitModel $unitModel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UnitModel $unitModel)
    {
        //
    }
}
