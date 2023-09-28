<?php

namespace App\Http\Controllers;

use App\Models\HistoryTireMovement;
use App\Models\TireMaster;
use App\Models\TireSize;
use App\Models\TirePattern;
use App\Models\TireStatus;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class HistoryTireMovementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $tiresize_id = $request->query("tiresize");
        $tirepattern_id = $request->query("tirepattern");
        $tirestatus_id = $request->query("tirestatus");

        $company = auth()->user()->company;

        $tiresize = TireSize::where('company_id', $company->id)->get();
        $tirepattern = TirePattern::where('company_id', $company->id)->get();
        $tirestatus = TireStatus::all();

        if ($request->ajax()) {
            $data = TireMaster::select("tires.*", "tire_sizes.size", "sites.name as site", "tire_statuses.status", "tire_patterns.pattern", "tire_compounds.compound")
                ->leftJoin("sites", "tires.site_id", "=", "sites.id")
                ->leftJoin("tire_statuses", "tires.tire_status_id", "=", "tire_statuses.id")
                ->leftJoin("tire_sizes", "tires.tire_size_id", "=", "tire_sizes.id")
                ->leftJoin("tire_compounds", "tires.tire_compound_id", "=", "tire_compounds.id")
                ->leftJoin("tire_patterns", "tire_sizes.tire_pattern_id", "=", "tire_patterns.id")
                ->where("tires.company_id", $company->id)
                ->has("history_tire_movement");
            if ($tiresize_id) {
                $data = $data->where("tire_size_id", $tiresize_id);
            }
            if ($tirepattern_id) {
                $data = $data->where("tire_sizes.tire_pattern_id", $tirepattern_id);
            }
            if ($tirestatus_id) {
                $data = $data->where("tire_status_id", $tirestatus_id);
            }
            return DataTables::of($data)
                ->addIndexColumn()
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


        return view("admin.history.historyTire", compact('tiresize', 'tirepattern', 'tirestatus', 'tiresize_id', 'tirepattern_id', 'tirestatus_id'));
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
        $data = HistoryTireMovement::with(["site", "tire_damage"])->where("tire", $tire->serial_number);
        if ($request->ajax()) {
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn("site", function ($row) {
                    return $row->site->name;
                })
                ->addColumn("damage", function ($row) {
                    return $row->tire_damage->damage ?? null;
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
                ->addColumn("tPentil", function ($row) {
                    $a = "<input type='checkbox' " . ($row->t_pentil ? 'checked' : '') . "> ";
                    return $a;
                })
                ->rawColumns(['tPentil'])
                ->make(true);
        }

        return view("admin.history.historyTireInspect", compact("tire"));


    }
}