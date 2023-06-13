<?php

namespace App\Http\Controllers;

use App\Models\DailyInspect;
use App\Models\HistoryTire;
use App\Models\HistoryTireMovement;
use App\Models\Site;
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
    public function index(Request $request)
    {
        $site = $request->query("site");
        $year = $request->query("year");
        $month = $request->query("month");

        $company = auth()->user()->company;
        if ($month && $year) {
            $date = "$year-$month-1";
            $start = Carbon::parse($date)->startOfMonth();
            $end = Carbon::parse($date)->endOfMonth();
            # code...
        } else {
            $start = Carbon::now()->startOfMonth();
            $end = Carbon::now()->endOfMonth();
        }

        $period = CarbonPeriod::create($start, $end);
        $total_hari = $period->count();
        $tire_inspect = DailyInspect::select("unit_id", "date")->with("unit")->whereBetween("date", [$start, $end])->groupBy("unit_id", "date")->get();

        $sites = Site::where("company_id", $company->id)->get();

        $tire_movement = HistoryTireMovement::select("unit", "status", DB::raw('DATE(created_at) as date'))
            ->where("company_id", $company->id)
            ->whereBetween("start_date", [$start, $end])
            ->groupBy("unit", "date", "status")->get();
        $data = [];
        foreach ($period as $date) {
            foreach ($tire_movement as $key => $unit) {
                $data[$unit->unit][$date->format('d')] = $unit->date == $date->format("Y-m-d") ?
                    ($unit->status == "RUNNING" ? "I" : "R") : "-";

            }

            foreach ($tire_inspect as $key => $unit) {
                $data[$unit->unit->unit_number][$date->format('d')] = $unit->date == $date ? "V" : "-";
            }
        }
        return view("admin.history.historydailyInspect", compact("data", "total_hari", "sites", "site", "year", "month"));
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
