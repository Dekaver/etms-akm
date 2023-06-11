<?php

namespace App\Http\Controllers;

use App\Models\DailyInspect;
use App\Models\HistoryTire;
use App\Models\HistoryTireMovement;
use App\Models\Unit;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use DB;
use Illuminate\Http\Request;

class HistoryTireController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $month = Carbon::now();
        $start = Carbon::parse($month)->startOfMonth();
        $end = Carbon::parse($month)->endOfMonth();
        $period = CarbonPeriod::create($start, $end);
        $total_hari = $period->count();
        $tire_inspect = DailyInspect::select("unit_id", "date")->with("unit")->whereBetween("date", [$start, $end])->groupBy("unit_id", "date")->get();

        $tire_movement = HistoryTireMovement::select("unit", "status", DB::raw('DATE(created_at) as date'))->whereBetween("start_date", [$start, $end])->groupBy("unit", "date", "status")->get();
        foreach ($period as $date) {
            foreach ($tire_movement as $key => $unit) {
                $data[$unit->unit][$date->format('d')] = $unit->date == $date->format("Y-m-d") ?
                    ($unit->status == "RUNNING" ? "I" : "R") : "-";

            }

            foreach ($tire_inspect as $key => $unit) {
                $data[$unit->unit->unit_number][$date->format('d')] = $unit->date == $date ? "V" : "-";
            }
        }
        return view("admin.history.historydailyInspect", compact("data", "total_hari"));
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
