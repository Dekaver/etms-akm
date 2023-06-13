<?php

namespace App\Http\Controllers;

use App\Models\HistoryTireMovement;
use App\Models\TireMaster;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class HistoryTireMovementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $data = TireMaster::has("history_tire_movement");
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn("size", function ($row) {
                    return $row->tire_size->size;
                })
                ->addColumn("site", function ($row) {
                    return $row->site->name;
                })
                ->addColumn("status", function ($row) {
                    return $row->tire_status->status;
                })
                ->addColumn("pattern", function ($row) {
                    return $row->tire_size->tire_pattern->pattern;
                })
                ->addColumn("compound", function ($row) {
                    return $row->tire_compound->compound;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = "
                        <a href='" . route('historytiremovement.tiremovement', $row->id) . "' class='btn btn-sm btn-primary text-white'>MOVEMENT</a>
                        <a href='" . route('historytiremovement.tireinspect', $row->id) . "' class='btn btn-sm btn-warning text-white'>INSPECT</a>
                    ";
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }


        return view("admin.history.historyTire");
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
    public function show(HistoryTireMovement $historyTireMovement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HistoryTireMovement $historyTireMovement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HistoryTireMovement $historyTireMovement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HistoryTireMovement $historyTireMovement)
    {
        //
    }

    public function tiremovement(Request $request, TireMaster $tire)
    {
        // dd($tire->history_tire_movement);
        if ($request->ajax()) {
            return DataTables::of($tire->history_tire_movement)
                ->addIndexColumn()
                ->addColumn("site", function ($row) {
                    return $row->site->name;
                })
                ->addColumn("rtd", function ($row) {
                    return $row->rtd;
                })
                ->addColumn("tire_hm", function ($row) {
                    return ($row->status == "RUNNING") ? $row->hm_tire_install : $row->hm_tire_remove;
                })
                ->addColumn("tire_km", function ($row) {
                    return ($row->status == "RUNNING") ? $row->km_tire_install : $row->km_tire_remove;
                })
                ->addColumn("unit_hm", function ($row) {
                    return ($row->status == "RUNNING") ? $row->hm_unit_install : $row->hm_unit_remove;
                })
                ->addColumn("unit_km", function ($row) {
                    return ($row->status == "RUNNING") ? $row->km_unit_install : $row->km_unit_remove;
                })
                ->make(true);
        }

        return view("admin.history.historyTireMovement", compact("tire"));
    }
    public function tireinspect(Request $request, TireMaster $tire)
    {
        if ($request->ajax()) {
            return DataTables::of($tire->daily_inspect)
                ->addIndexColumn()
                ->addColumn("tire", function ($row) {
                    return $row->tire->serial_number;
                })
                ->addColumn("unit", function ($row) {
                    return $row->unit->unit_number;
                })
                ->addColumn("site", function ($row) {
                    return $row->site->name;
                })
                ->make(true);
        }

        return view("admin.history.historyTireinspect", compact("tire"));


    }
}
