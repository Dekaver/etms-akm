<?php

namespace App\Exports;

use App\Models\DailyInspect;
use App\Models\HistoryTireMovement;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use DB;
use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ReportDailyInspect implements FromView
{
    protected $date;

    public function __construct(Carbon $date)
    {
        $this->date = $date;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {
        $month = $this->date;
        $start = Carbon::parse($month)->startOfMonth();
        $end = Carbon::parse($month)->endOfMonth();
        $period = CarbonPeriod::create($start, $end);
        $total_days = $period->count();
        $tire_inspect = DailyInspect::select("unit_id", "date")->with("unit")->whereBetween("date", [$start, $end])->groupBy("unit_id", "date")->get();

        $tire_movement = HistoryTireMovement::select("unit", "status", DB::raw('DATE(created_at) as date'))->whereBetween("start_date", [$start, $end])->groupBy("unit", "date", "status")->get();
        foreach ($period as $date) {
            foreach ($tire_movement as $key => $unit) {
                $data[$unit->unit][$date->format("d")] = $unit->date == $date->format("Y-m-d") ?
                    ($unit->status == "RUNNING" ? "I" : "R") : "-";
            }
            foreach ($tire_inspect as $key => $unit) {
                $data[$unit->unit->unit_number][$date->format('d')] = $unit->date == $date ? "V" : "-";
            }


        }
        return view('admin.export.dailymonitoring', compact("data", "total_days", "month", "period"));
    }
}