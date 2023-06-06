<?php

namespace App\Http\Controllers;

use App\Models\TireDamage;
use Illuminate\Http\Request;

class TireDamageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("admin.master.tiredamage");
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
    public function show(TireDamage $tireDamage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TireDamage $tireDamage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TireDamage $tireDamage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TireDamage $tireDamage)
    {
        //
    }
}
