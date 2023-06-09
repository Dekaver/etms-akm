<?php

namespace App\Http\Controllers;

use App\Models\TireRunning;
use App\Models\Unit;
use App\Models\TireMovement;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TireMovementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $company = auth()->user()->company;
        $site = auth()->user()->site;

        if ($request->ajax()) {
            $data = Unit::where('company_id', $company->id)->where('site_id', $site->id);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn("unit_model", function ($row) {
                    return $row->unit_model->model;
                })
                ->addColumn("unit_status", function ($row) {
                    return $row->unit_status->status_code;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = "<a class='me-3 text-warning' href='" . route('tiremovement.edit', $row->id) . "'>
                                    <img src='assets/img/icons/edit.svg' alt='img'>
                                </a>";
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
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
    public function edit(string $tiremovement)
    {

        return view("admin.data.tiremovementedit", compact("tiremovement"));
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