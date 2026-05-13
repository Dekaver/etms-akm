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
    protected $site;
    protected $date;

    public function __construct(Carbon $date, string $site)
    {
        $this->date = $date;
        $this->site = $site;
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
        $tire_inspect = DailyInspect::select("unit_id", DB::raw('DATE(start_date) as date'))->with("unit")->whereBetween("start_date", [$start, $end]);

        if ($this->site) {
            $tire_inspect = $tire_inspect->where("site_id", $this->site);
        }
        $tire_inspect = $tire_inspect->groupBy("unit_id", "date")->get();

        $tire_movement = HistoryTireMovement::select("unit", "process", DB::raw('DATE(start_date) as date'))
            ->where('company_id', auth()->user()->company->id)
            ->whereBetween("start_date", [$start, $end])->groupBy("unit", "date", "process");
        if ($this->site) {
            $tire_movement = $tire_movement->where('site_id', $this->site);
        }
        $tire_movement = $tire_movement->get();

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

        return view('admin.export.dailymonitoring', compact("data", "total_days", "month", "period", "totals", "lastInspect"));
    }
}
