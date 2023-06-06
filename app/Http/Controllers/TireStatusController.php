<?php

namespace App\Http\Controllers;

use App\Models\TireStatus;
use Illuminate\Http\Request;

class TireStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("admin.master.tirestatus");
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
    public function show(TireStatus $tireStatus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TireStatus $tireStatus)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TireStatus $tireStatus)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TireStatus $tireStatus)
    {
        //
    }
}
