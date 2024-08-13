<?php

namespace App\Http\Controllers;

use App\Exports\ReportDailyInspect;
use App\Imports\DailyInspectImport;
use App\Models\DailyInspect;
use App\Models\DailyInspectDetail;
use App\Models\Site;
use App\Models\TireDamage;
use App\Models\TireRunning;
use App\Models\Unit;
use Carbon\Carbon;
use DB;
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
        $tire_damages = TireDamage::where('company_id', $company->id)->get();

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
                    $actionBtn = "<a class='me-3 text-warning' href='" . route('dailyinspect.show', $row->id) . "'>
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
        $request->validate([
            'unit_id' => 'required',
            'date' => 'required',
            'hm' => 'required|numeric|min:0',
            'km' => 'required|numeric|min:0',
            'pic' => 'required',
            'driver' => 'required',
            'position' => 'required|array',
            'serial_number' => 'required|array',
            'pressure' => 'required|array',
            'rtd' => 'required|array',
        ]);

        DB::beginTransaction();

        try {
            $unit = Unit::find($request->unit_id);

            $company = auth()->user()->company;
            $site = auth()->user()->site;

            $daily_inspect = DailyInspect::create([
                "company_id" => $company->id,
                "site_id" => $site->id,
                "unit_id" => $unit->id,
                "km_unit" => $unit->km,
                "hm_unit" => $unit->hm,
                "updated_hm_unit" => $request->hm,
                "updated_km_unit" => $request->km,
                "location" => $site->name,
                "shift" => $request->shift,
                "pic" => $request->pic,
                "driver" => $request->driver,
                "date" => $request->date,
                "time" => $request->time,
            ]);

            // update lifetime

            if ($request->hm >= $unit->hm && $request->km >= $unit->km) {

                $tire_running = TireRunning::where('unit_id', $unit->id)->get();
                foreach ($tire_running as $key => $running) {
                    // update tire lifetime
                    $tire = $running->tire;
                    $diff_hm = 0;
                    $diff_km = 0;
                    if ($is_selected = $request->has("is_selected.{$running->position}")) {
                        // update HM
                        if ($request->hm > $tire->last_update_hm_unit) {
                            $diff_hm = (int) $request->hm - (int) $tire->last_update_hm_unit;

                            $tire->lifetime_hm += $diff_hm;
                            if ($tire->is_repair) {
                                $tire->lifetime_repair_hm += $diff_hm;
                            }
                            if ($tire->is_retread) {
                                $tire->lifetime_retread_hm += $diff_hm;
                            }
                        }
                        // update KM
                        if ($request->km > $tire->last_update_km_unit) {
                            $diff_km = (int) $request->km - (int) $tire->last_update_km_unit;
                            $tire->lifetime_km += $diff_km;
                            if ($tire->is_repair) {
                                $tire->lifetime_repair_km += $diff_km;
                            }
                            if ($tire->is_retread) {
                                $tire->lifetime_retread_km += $diff_km;
                            }
                        }

                        $diff_rtd = $is_selected ? (int) $tire->rtd - (int) $request->rtd[$running->position] : 0;
                        $diff_pressure = $is_selected ? (int) $tire->pressure - (int) $request->pressure[$running->position]:0;

                        // update tire
                        $tire->tube = $request->tire_tube[$running->position];
                        $tire->rim = $request->tire_rim[$running->position];
                        $tire->t_pentil = $request->has("tire_t_pentil.{$running->position}");
                        $tire->flap = $request->tire_flap[$running->position];
                        $tire->tire_condition = $request->tire_condition[$running->position];
                        $tire->rtd = $request->rtd[$running->position];
                        $tire->pressure = $request->pressure[$running->position];
                        $tire->tire_damage_id = $request->tire_damage_id[$running->position] ?? null;
                    }

                    // end update lifetime

                    $tire_inspection = DailyInspectDetail::create([
                        "daily_inspect_id" => $daily_inspect->id,
                        "tire_id" => $tire->id,
                        "tire_damage_id" => $is_selected ? $request->tire_damage_id[$running->position] ?? null : null,
                        "position" => $request->position[$running->position],
                        "is_selected" => $is_selected,
                        "last_km_unit" => $is_selected ? $request->km : $tire->last_update_km_unit,
                        "last_hm_unit" => $is_selected ? $request->hm : $tire->last_update_hm_unit,
                        "lifetime_hm" => $tire->lifetime_hm,
                        "lifetime_km" => $tire->lifetime_km,
                        "diff_hm" => $diff_hm,
                        "diff_km" => $diff_km,
                        "diff_rtd" => $diff_rtd,
                        "diff_pressure" => $diff_pressure,
                        "rtd" => $is_selected ? $request->rtd[$running->position] : 0,
                        "pressure" => $is_selected ? $request->pressure[$running->position] : 0,
                        "tube" => $is_selected ? $request->tire_tube[$running->position] : 'Good',
                        "flap" => $is_selected ? $request->tire_flap[$running->position] : 'Good',
                        "rim" => $is_selected ? $request->tire_rim[$running->position] : 'Good',
                        "t_pentil" => $is_selected ? $request->has("tire_t_pentil.$running->position") : 1,
                        "remark" => $is_selected ? $request->remark[$running->position] : '',
                    ]);

                    $tire->save();
                }


                if ($request->hm > $unit->hm)
                    $unit->hm = (int) $request->hm;

                if ($request->km > $unit->km)
                    $unit->km = (int) $request->km;

                $unit->save();
            }

            // Jika semuanya berhasil, commit transaksi
            DB::commit();
        } catch (\Exception $e) {
            // Blok ini hanya dijalankan jika terjadi pengecualian (exception)
            // Handle atau log kesalahan
            return "Transaction failed: " . $e->getMessage();
        }
        return redirect()->back()->with("success", "Insert Daily Monitoring");
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id)
    {
        $company = auth()->user()->company;
        $site = auth()->user()->site;
        $sites = Site::where("company_id", $company->id)->get();
        $tire_damages = TireDamage::where("company_id", $company->id)->get();
        $unit = Unit::whereId($id)->with('tire_runnings.tire')->first();
        if ($request->ajax()) {
            $data = DailyInspect::where('company_id', $company->id)->where("unit_id", $id)->where('site_id', $site->id);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn("last_update", function ($row) {
                    return $row->unit->inspection_last_update;
                })
                ->addColumn("unit_number", function ($row) {
                    return $row->unit->unit_number;
                })
                ->addColumn("unit_status", function ($row) {
                    return $row->unit->unit_status->status_code;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = "<a class='me-3 text-warning' href='#'
                                    data-bs-target='#form-modal'  data-bs-toggle='modal'
                                     data-id='$row->id'
                                     data-unit_number='$row->unit_number'
                                     data-hm='$row->hm'
                                     data-km='$row->km'>
                                    <img src='../assets/img/icons/edit.svg' alt='img'>
                                </a>
                                <a class='confirm-text' href='javascript:void(0);' data-bs-toggle='modal'
                                                    data-bs-target='#deleteModal' data-id='$row->id'
                                                    data-action='" . route('dailyinspect.destroy', $row->id) . "'
                                                    data-message='$row->name'>
                                    <img src='../assets/img/icons/delete.svg' alt='img'>
                                </a>";
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view("admin.data.dailyinspect.show", compact("tire_damages", "sites", "unit"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($dailyinspect)
    {
        $data = DailyInspect::whereId($dailyinspect)->with("details.tire")->first()->toArray();

        return $data;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DailyInspect $dailyinspect)
    {
        $request->validate([
            'unit_id' => 'required',
            'date' => 'required',
            'hm' => 'required|numeric|min:0',
            'km' => 'required|numeric|min:0',
            'pic' => 'required',
            'driver' => 'required',
            'position' => 'required|array',
            'serial_number' => 'required|array',
            'pressure' => 'required|array',
            'rtd' => 'required|array',
        ]);
        DB::beginTransaction();

        try {
            $unit = Unit::find($request->unit_id);

            if ($unit->daily_inspect->pluck('id')->first() != $dailyinspect->id) {
                return redirect()->back()->with('error', 'Cant Update, Because This Inspection Not the last Inspection');
            }

            $lTireMovement = TireRunning::where('unit_id', $unit->id)->get();
            if ($dailyinspect->details->count() != $lTireMovement->count()) {
                return redirect()->back()->with('error', 'Tire Inspection tidak sama dengan tire install, Tidak dapat di ubah');
            }
            foreach ($dailyinspect->details as $value) {
                if ($value->tire_id != $lTireMovement->where('position', $value->position)->pluck('tire_id')->first()) {
                    return redirect()->back()->with('error', 'Tire Inspection tidak sama dengan tire install, Tidak dapat di ubah');
                }
            }

            $dailyinspect->updated_hm_unit = $request->hm;
            $dailyinspect->updated_km_unit = $request->km;
            $dailyinspect->shift = $request->shift;
            $dailyinspect->pic = $request->pic;
            $dailyinspect->driver = $request->driver;
            $dailyinspect->date = $request->date;
            $dailyinspect->time = $request->time;
            $dailyinspect->save();

            if ($request->hm >= $unit->hm || $request->km >= $unit->km) {

                $tire_running = TireRunning::where('unit_id', $unit->id)->get();
                foreach ($tire_running as $key => $running) {
                    // update tire lifetime
                    $tire = $running->tire;
                    $diff_hm = 0;
                    $diff_km = 0;
                    $daily_inspect_detail = $dailyinspect->details->where('position', $running->position)->first();
                    if (($is_selected = !$request->has("is_selected.{$running->position}")) && !$daily_inspect_detail->is_selected) {
                        continue;
                    }

                    if ($tire->last_update_km_unit != $daily_inspect_detail->last_km_unit) {
                        return redirect()->back()->with('error', "Tire {$daily_inspect_detail->tire->serial_number} has updated another");
                    }
                    if (($is_selected = $request->has("is_selected.{$running->position}"))) {
                        $diff_hm = (int) $request->hm - (int) $tire->last_update_hm_unit;
                        $diff_km = (int) $request->km - (int) $tire->last_update_km_unit;

                    } else if (!($is_selected = $request->has("is_selected.{$running->position}")) && $daily_inspect_detail->is_selected) {

                        $diff_hm = (int) $daily_inspect_detail->diff_hm * -1;
                        $diff_km = (int) $daily_inspect_detail->diff_km * -1;
                    }
                    // update HM
                    $tire->lifetime_hm += $diff_hm;
                    if ($tire->is_repair) {
                        $tire->lifetime_repair_hm += $diff_hm;
                    }
                    if ($tire->is_retread) {
                        $tire->lifetime_retread_hm += $diff_hm;
                    }
                    $daily_inspect_detail->diff_hm += $diff_hm;
                    $daily_inspect_detail->last_hm_unit += $diff_hm;
                    $daily_inspect_detail->lifetime_hm = $tire->lifetime_hm;


                    // update KM
                    $tire->lifetime_km += $diff_km;
                    if ($tire->is_repair) {
                        $tire->lifetime_repair_km += $diff_km;
                    }
                    if ($tire->is_retread) {
                        $tire->lifetime_retread_km += $diff_km;
                    }
                    $daily_inspect_detail->diff_km += $diff_km;
                    $daily_inspect_detail->last_km_unit += $diff_km;
                    $daily_inspect_detail->lifetime_km = $tire->lifetime_km;

                    // dd($daily_inspect_detail);

                    // UPDATE RTD PRESSURE OTHER
                    $daily_inspect_detail->is_selected = $is_selected ? 1 : 0;
                    $daily_inspect_detail->diff_rtd = $daily_inspect_detail->rtd - $request->rtd[$running->position] + $daily_inspect_detail->diff_rtd;
                    $daily_inspect_detail->diff_pressure = $daily_inspect_detail->pressure - $request->pressure[$running->position] + $daily_inspect_detail->diff_pressure;
                    $daily_inspect_detail->rtd = $request->rtd[$running->position];
                    $daily_inspect_detail->pressure = $request->pressure[$running->position];
                    $daily_inspect_detail->tube = $request->tire_tube[$running->position];
                    $daily_inspect_detail->flap = $request->tire_flap[$running->position];
                    $daily_inspect_detail->rim = $request->tire_rim[$running->position];
                    $daily_inspect_detail->t_pentil = $request->has("tire_t_pentil.$running->position") ? 1 : 0;
                    $daily_inspect_detail->remark = $request->remark[$running->position];
                    $daily_inspect_detail->tire_damage_id = $request->tire_damage_id[$running->position] ?? null;

                    $tire->rtd = $request->rtd[$running->position];
                    $tire->pressure = $request->pressure[$running->position];

                    $tire->tube = $request->tire_tube[$running->position];
                    $tire->rim = $request->tire_rim[$running->position];
                    $tire->flap = $request->tire_flap[$running->position];
                    $tire->t_pentil = $request->has("tire_t_pentil.{$running->position}") ? 1 : 0;
                    $tire->tire_condition = $request->tire_condition[$running->position];
                    $tire->tire_damage_id = $request->tire_damage_id[$running->position] ?? null;

                    $daily_inspect_detail->save();
                    $tire->save();
                }




                $unit->hm = (int) $request->hm;

                $unit->km = (int) $request->km;

                $unit->save();
            }

            // Jika semuanya berhasil, commit transaksi
            DB::commit();
        } catch (\Exception $e) {
            // Blok ini hanya dijalankan jika terjadi pengecualian (exception)
            // Handle atau log kesalahan
            return "Transaction failed: " . $e->getMessage();
        }
        return redirect()->back()->with("success", "Insert Daily Monitoring");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DailyInspect $dailyinspect)
    {
        $unit = Unit::find($dailyinspect->unit_id);
        if ($unit->daily_inspect->pluck('id')->first() != $dailyinspect->id) {
            return redirect()->back()->with('error', 'Cant Update, Because This Inspection Not the last Inspection');
        }
        if ($unit->km != $dailyinspect->updated_km_unit || $unit->hm != $dailyinspect->updated_hm_unit) {
            return redirect()->back()->with('error', 'Cant Delete, Because KM Unit telad updated another fitur');
        }
        try {
            $unit = Unit::find($dailyinspect->unit_id);

            if ($unit->daily_inspect->pluck('id')->first() != $dailyinspect->id) {
                return redirect()->back()->with('error', 'Cant Update, Because This Inspection Not the last Inspection');
            }


            $tire_running = TireRunning::where('unit_id', $unit->id)->get();
            foreach ($tire_running as $key => $running) {
                // update tire lifetime
                $tire = $running->tire;
                $diff_hm = 0;
                $diff_km = 0;
                $daily_inspect_detail = $dailyinspect->details->where('position', $running->position)->first();
                $diff_hm = (int) $daily_inspect_detail->diff_hm * -1;
                $diff_km = (int) $daily_inspect_detail->diff_km * -1;
                $diff_rtd = (int) $daily_inspect_detail->diff_rtd;
                $diff_pressure = (int) $daily_inspect_detail->diff_pressure;

                // update HM
                $tire->lifetime_hm += $diff_hm;
                if ($tire->is_repair) {
                    $tire->lifetime_repair_hm += $diff_hm;
                }
                if ($tire->is_retread) {
                    $tire->lifetime_retread_hm += $diff_hm;
                }

                // update KM
                $tire->lifetime_km += $diff_km;
                if ($tire->is_repair) {
                    $tire->lifetime_repair_km += $diff_km;
                }
                if ($tire->is_retread) {
                    $tire->lifetime_retread_km += $diff_km;
                }

                $tire->rtd = $daily_inspect_detail->rtd + $diff_rtd;
                $tire->pressure = $daily_inspect_detail->pressure + $diff_pressure;

                $daily_inspect_detail->save();
                $tire->save();
            }
            $unit->hm = (int) $dailyinspect->hm_unit;
            $unit->km = (int) $dailyinspect->km_unit;
            $unit->save();

            $dailyinspect->details()->delete();
            $dailyinspect->delete();

            // Jika semuanya berhasil, commit transaksi
            DB::commit();
        } catch (\Exception $e) {
            // Blok ini hanya dijalankan jika terjadi pengecualian (exception)
            // Handle atau log kesalahan
            return "Transaction failed: " . $e->getMessage();
        }
        return redirect()->back()->with("success", "Deleted Daily Inspect");

    }

    public function export(Request $request)
    {
        $site = $request->query("site") ?? auth()->user()->site?->id;
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
