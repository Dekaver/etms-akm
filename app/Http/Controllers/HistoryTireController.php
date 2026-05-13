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
        $year = $request->query("year", Carbon::now()->format('Y'));
        $month = $request->query("month", Carbon::now()->format('n'));

        $company = auth()->user()->company;
        $date = "$year-$month-1";
        $start = Carbon::parse($date)->startOfMonth();
        $end = Carbon::parse($date)->endOfMonth();

        $period = CarbonPeriod::create($start, $end);
        $total_hari = $period->count();
        $tire_inspect = DailyInspect::select("unit_id", "date")
            ->with("unit")
            ->where('company_id', $company->id)
            ->whereBetween("date", [$start, $end]);
        if ($site) {
            $tire_inspect = $tire_inspect->where("site_id", $site);
        }
        $tire_inspect = $tire_inspect->groupBy("unit_id", "date")->get();

        $sites = Site::where("company_id", $company->id)->get();

        $tire_movement = HistoryTireMovement::select("unit", "process", DB::raw('DATE(start_date) as date'))
            ->where("company_id", $company->id)
            ->whereBetween("start_date", [$start, $end]);
        if ($site) {
            $tire_movement = $tire_movement->where("site_id", $site);
        }
        $tire_movement = $tire_movement->groupBy("unit", "date", "process")->get();

        $units = [];
        foreach ($tire_inspect as $row) {
            $units[$row->unit->unit_number] = true;
        }
        foreach ($tire_movement as $row) {
            $units[$row->unit] = true;
        }

        $data = [];
        $totals = [];
        $lastInspect = [];
        foreach (array_keys($units) as $unitNumber) {
            $totals[$unitNumber] = ["V" => 0, "R" => 0, "I" => 0];
            $lastInspect[$unitNumber] = ["V" => null, "R" => null, "I" => null];
            foreach ($period as $date) {
                $data[$unitNumber][$date->format('d')] = "-";
            }
        }

        foreach ($tire_movement as $row) {
            $rowDate = Carbon::parse($row->date);
            $d = $rowDate->format('d');
            $code = $row->process == "INSTALL" ? "I" : "R";
            $cell = $data[$row->unit][$d] ?? "-";
            $set = $cell == "-" ? [] : explode(",", $cell);
            if (!in_array($code, $set)) {
                $set[] = $code;
                $totals[$row->unit][$code] += 1;
            }
            $data[$row->unit][$d] = implode(",", $set);

            if (!$lastInspect[$row->unit][$code] || $rowDate->gt($lastInspect[$row->unit][$code])) {
                $lastInspect[$row->unit][$code] = $rowDate;
            }
        }

        foreach ($tire_inspect as $row) {
            $unitNumber = $row->unit->unit_number;
            $rowDate = Carbon::parse($row->date);
            $d = $rowDate->format('d');
            $cell = $data[$unitNumber][$d] ?? "-";
            $set = $cell == "-" ? [] : explode(",", $cell);
            if (!in_array("V", $set)) {
                array_unshift($set, "V");
                $totals[$unitNumber]["V"] += 1;
            }
            $data[$unitNumber][$d] = implode(",", $set);

            if (!$lastInspect[$unitNumber]["V"] || $rowDate->gt($lastInspect[$unitNumber]["V"])) {
                $lastInspect[$unitNumber]["V"] = $rowDate;
            }
        }

        return view("admin.history.historydailyInspect", compact("data", "total_hari", "sites", "site", "year", "month", "totals", "lastInspect"));
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
