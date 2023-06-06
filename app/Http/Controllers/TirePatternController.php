<?php

namespace App\Http\Controllers;

use App\Models\TirePattern;
use Illuminate\Http\Request;

class TirePatternController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("admin.master.tirepattern");
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
    public function show(TirePattern $tirePattern)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TirePattern $tirePattern)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TirePattern $tirePattern)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TirePattern $tirePattern)
    {
        //
    }
}
