<?php

namespace App\Http\Controllers;

use App\Models\DailyInspect;
use App\Models\TireDamage;
use App\Models\TireMaster;
use App\Models\TireRunning;
use App\Models\TireStatus;
use App\Models\Unit;
use Illuminate\Http\Request;
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
        return view("admin.data.dailyinspect", compact("tire_damages"));
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
        return TireRunning::where("unit_id", $dailyinspect->id)->with("tire")->orderBy("position")->get();
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
            'tire_serial_number' => 'required',
            'position' => 'required',
            'serialnumber' => 'required',
        ]);
        $unit = $dailyinspect;
        $tire_status_running = TireStatus::where('status', 'running')->first();

        $cekdailyinspect = DailyInspect::where("unit_id", $unit->id)->whereDate("date", $request->date)->first();

        if ($cekdailyinspect) {
            $cekdailyinspect;
        }

        // update lifetime
        if ($request->hm > $unit->hm || $request->km > $unit->km) {

            // update tire lifetime
            $tire_running = TireRunning::where('unit_id', $request->unit_id)->get();

            foreach ($tire_running as $key => $running) {
                $tire = $running->tire;

                // update HM
                if ($request->hm > $unit->hm) {
                    $diff_smu = (int) $request->hm - (int) $unit->hm;
                    $unit->hm = (int) $request->hm;

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
                    $unit->km = (int) $request->km;

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
            $unit->save();
        }
        // end update lifetime

        foreach ($request->position as $key => $value) {
            $tire_inspection = DailyInspect::firstOrCreate(
                [
                    'unit_number' => $unit->unit_number,
                    'tire_serial_number' => $request->tire_serial_number[$value],
                    'position' => $request->position[$value],
                    'date' => $request->date,
                    'action' => $request->action,
                ],
                [
                    'unit_number' => $unit->unit_number,
                    'prime_mover' => $unit->prime_mover->unit_number ?? null,
                    'tire_damage_id' => $request->tire_damage_id[$value] ?? null,
                    'rtd' => $request->rtd[$value],
                    'lifetime' => $request->lifetime[$value] ?? null,
                ],
            );
            $tire_inspection->tire_damage_id = $request->tire_damage_id[$value] ?? null;

            $tire_inspection->rtd = $request->rtd[$value];
            $tire_inspection->lifetime = $request->lifetime[$value] ?? null;
            $tire_inspection->save();
            if ($request->tire_serial_number[$value]) {
                TireMaster::where('serial_number', $request->tire_serial_number[$value])->update([
                    'rtd' => $request->rtd[$value],
                    'tire_damage_id' => $request->tire_damage_id[$value],
                ]);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DailyInspect $dailyInspect)
    {
        //
    }
}
