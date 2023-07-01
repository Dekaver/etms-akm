<?php

namespace App\Http\Controllers;

use App\Exports\ReportDailyInspect;
use App\Models\DailyInspect;
use App\Models\Site;
use App\Models\TireDamage;
use App\Models\TireMaster;
use App\Models\TireRunning;
use App\Models\TireStatus;
use App\Models\Unit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class DailyInspectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $company = auth()->user()->company;
        $site = auth()->user()->site;
        $sites = Site::where("company_id", $company->id)->get();
        $tire_damages = TireDamage::all();

        if ($request->ajax()) {
            $data = Unit::where('company_id', $company->id)->where('site_id', $site->id);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn("last_update", function ($row) {
                    return $row->inspection_last_update;
                })
                ->addColumn("unit_status", function ($row) {
                    return $row->unit_status->status_code;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = "<a class='me-3 text-warning' href='#'
                                    data-bs-target='#form-modal'  data-bs-toggle='modal'
                                     data-id='$row->id'
                                     data-unit_number='$row->unit_number'
                                     data-hm='$row->hm'
                                     data-km='$row->km'

                                     >
                                    <img src='assets/img/icons/edit.svg' alt='img'>
                                </a>";
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view("admin.data.dailyInspect", compact("tire_damages", "sites"));
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
    public function show(DailyInspect $dailyInspect)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Unit $dailyinspect)
    {
        $daily = DailyInspect::where("unit_id", $dailyinspect->id)->with("tire")->whereDate("updated_at", Carbon::now(8))->orderBy("position", "desc")->get();
        $tiresrunning = TireRunning::where("unit_id", $dailyinspect->id)->with("tire")->orderBy("position")->get();
        $data["shift"] = $daily->pluck("shift")->first();
        $data["driver"] = $daily->pluck("driver")->first();
        $data["pic"] = $daily->pluck("pic")->first();

        foreach ($tiresrunning as $key => $tire) {
            // dd($tire->tire);
            $data["tires"][$key]["id"] = $tire->tire->id;
            $data["tires"][$key]["position"] = $tire->position;
            $data["tires"][$key]["serial_number"] = $tire->tire->serial_number;
            $data["tires"][$key]["pressure"] = $tire->tire->pressure;
            $data["tires"][$key]["rtd"] = $tire->tire->rtd;
            $data["tires"][$key]["tire_condition"] = $tire->tire->tire_condition;
            $data["tires"][$key]["tube"] = $tire->tire->tube;
            $data["tires"][$key]["rim"] = $tire->tire->rim;
            $data["tires"][$key]["flap"] = $tire->tire->flap;
            $data["tires"][$key]["t_pentil"] = $tire->tire->t_pentil;
            $data["tires"][$key]["remark"] = $daily->where("position", $tire->position)->pluck("remark")->first();
        }

        return $data;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Unit $dailyinspect)
    {
        $request->validate([
            'unit_number' => 'required',
            'date' => 'required',
            'hm' => 'required',
            'km' => 'required',
            'pic' => 'required',
            'tire_id' => 'required',
            'position' => 'required',
        ]);
        $unit = $dailyinspect;

        $cekdailyinspect = DailyInspect::where("unit_id", $unit->id)->whereDate("date", $request->date)->first();

        if ($cekdailyinspect) {
            $cekdailyinspect;
        }

        // update lifetime
        if ($request->hm > $unit->hm || $request->km > $unit->km) {

            // update tire lifetime
            $tire_running = TireRunning::where('unit_id', $unit->id)->get();
            foreach ($tire_running as $key => $running) {
                $tire = $running->tire;

                // update HM
                if ($request->hm > $unit->hm) {
                    $diff_smu = (int) $request->hm - (int) $unit->hm;

                    $tire->lifetime_hm += $diff_smu;
                    if ($tire->is_repair) {
                        $tire->lifetime_repair_hm += $diff_smu;
                    }
                    if ($tire->is_retread) {
                        $tire->lifetime_retread_hm += $diff_smu;
                    }
                }

                // update HM
                if ($request->km > $unit->km) {
                    $diff_smu = (int) $request->km - (int) $unit->km;

                    $tire->lifetime_km += $diff_smu;
                    if ($tire->is_repair) {
                        $tire->lifetime_repair_km += $diff_smu;
                    }
                    if ($tire->is_retread) {
                        $tire->lifetime_retread_km += $diff_smu;
                    }
                }



                $tire->save();
            }

            if ($request->hm_actual > $unit->hm)
                $unit->km = (int) $request->km;

            if ($request->km_actual > $unit->km)
                $unit->hm = (int) $request->hm;
            $unit->save();
        }
        // end update lifetime

        foreach ($request->position as $key => $position) {
            $tire = TireMaster::find($request->tire_id[$position]);
            $tire_inspection = DailyInspect::firstOrCreate(
                [
                    "company_id" => auth()->user()->company->id,
                    "site_id" => auth()->user()->site->id,
                    "tire_id" => $request->tire_id[$position],
                    "unit_id" => $unit->id,
                    "date" => $request->date,
                ],
                [
                    "location" => auth()->user()->site->name,
                    "shift" => $request->shift,
                    "driver" => $request->driver,
                    "pic" => $request->pic,
                    "tire_damage_id" => $request->tire_damage_id[$position] ?? null,
                    "rtd" => $request->rtd[$position],
                    "pressure" => $request->pressure[$position],
                    "position" => $position,
                    "tire_condition" => $request->tire_condition[$position],
                    "flap" => $request->tire_flap[$position],
                    "rim" => $request->tire_rim[$position],
                    "tube" => $request->tire_tube[$position],
                    "t_pentil" => ($request->tire_t_pentil[$position] ?? null) == "on" ? true : false,
                    "remark" => $request->remark[$position],
                    "lifetime_hm" => $tire->lifetime_hm,
                    "lifetime_km" => $tire->lifetime_km,
                ],
            );
            $tire_inspection->driver = $request->driver;
            $tire_inspection->pic = $request->pic;
            $tire_inspection->shift = $request->shift;
            $tire_inspection->tire_damage_id = $request->tire_damage_id[$position] ?? null;
            $tire_inspection->rtd = $request->rtd[$position];
            $tire_inspection->pressure = $request->pressure[$position];
            $tire_inspection->position = $position;
            $tire_inspection->tire_condition = $request->tire_condition[$position];
            $tire_inspection->flap = $request->tire_flap[$position];
            $tire_inspection->rim = $request->tire_rim[$position];
            $tire_inspection->tube = $request->tire_tube[$position];
            $tire_inspection->t_pentil = ($request->tire_t_pentil[$position] ?? null) == "on" ? true : false;
            $tire_inspection->remark = $request->remark[$position];
            $tire_inspection->lifetime_hm = $tire->lifetime_hm;
            $tire_inspection->lifetime_km = $tire->lifetime_km;

            $tire_inspection->save();

            TireMaster::where('id', $request->tire_id[$position])->update([
                'tube' => $request->tire_tube[$position],
                'rim' => $request->tire_rim[$position],
                't_pentil' => ($request->tire_t_pentil[$position] ?? null) == "on" ? true : false,
                'flap' => $request->tire_flap[$position],
                'tire_condition' => $request->tire_condition[$position],
                'rtd' => $request->rtd[$position],
                'pressure' => $request->pressure[$position],
                'tire_damage_id' => $request->tire_damage_id[$position] ?? null,
            ]);
        }

        return redirect()->back()->with("success", "Insert Daily Monitoring");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DailyInspect $dailyInspect)
    {
        //
    }

    public function export(Request $request)
    {
        $site = $request->query("site");
        $month = $request->query("month");
        $year = $request->query("year");

        if ($month && $year) {
            $date = Carbon::parse("$year-$month-1");
        } else {
            $date = Carbon::now();
        }

        return Excel::download(new ReportDailyInspect($date, $site), 'daily_report.xlsx');
    }
}