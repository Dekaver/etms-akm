<?php

namespace App\Http\Controllers;

use App\Models\HistoryTire;
use Illuminate\Http\Request;

class HistoryTireController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("admin.history.historytire");
        //
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
    public function show(HistoryTire $historyTire)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HistoryTire $historyTire)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HistoryTire $historyTire)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HistoryTire $historyTire)
    {
        //
    }
}
