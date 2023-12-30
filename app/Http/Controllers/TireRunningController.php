<?php

namespace App\Http\Controllers;

use App\Models\AdjustKmPasang;
use App\Models\HistoryTireMovement;
use App\Models\TireDamage;
use App\Models\TireMaster;
use App\Models\TireMovement;
use App\Models\TireRunning;
use App\Models\TireStatus;
use App\Models\Unit;
use DB;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class TireRunningController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $company = auth()->user()->company;
        $site = auth()->user()->site;

        if ($request->ajax()) {
            $data = Unit::where('company_id', $company->id)->where('site_id', $site->id);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn("unit_model", function ($row) {
                    return $row->unit_model->model;
                })
                ->addColumn("unit_status", function ($row) {
                    return $row->unit_status->status_code;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = "<a class='me-3 text-warning' href='" . route('tirerunning.edit', $row->id) . "'>
                                    <img src='assets/img/icons/edit.svg' alt='img'>
                                </a>";
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view("admin.data.tireMovement");
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
        $company = auth()->user()->company;
        $site = auth()->user()->site;

        $request->validate(
            [
                'unit_id' => "required",
                'tire_id' => "required",
                'position' => "required",
                'start_date' => "required",
                'end_date' => "required",
                'hm' => "required",
                'km' => "required",
                'explanation' => "required",
                'pic' => "required",
                'pic_man_power' => "required",
            ],
        );

        try {
            $result = DB::transaction(function () use ($request, $company, $site) {
                $unit = Unit::find($request->unit_id);
                $tire = TireMaster::findOrFail($request->tire_id);

                HistoryTireMovement::create([
                    "user_id" => auth()->id(),
                    "company_id" => $company->id,
                    "site_id" => auth()->user()->site->id,
                    "unit" => $unit->unit_number,
                    "tire" => $tire->serial_number,
                    "position" => $request->position,
                    "status" => $tire->tire_status->status,
                    "km_unit" => $unit->km,
                    "hm_unit" => $unit->hm,
                    "pic" => $request->pic,
                    "pic_man_power" => $request->pic_man_power,
                    "des" => $request->explanation,
                    "process" => "INSTALL",
                    "km_tire" => $tire->lifetime_km,
                    "hm_tire" => $tire->lifetime_hm,
                    "start_date" => $request->start_date,
                    "rtd" => $tire->rtd,
                    "end_date" => $request->end_date,
                    "start_breakdown" => $request->start_breakdown,
                    "status_schedule" => $request->status_schedule,
                    "lokasi_breakdown" => $request->lokasi_breakdown,
                ]);


                $tirerunning = TireRunning::create([
                    "unit_id" => $unit->id,
                    "tire_id" => $tire->id,
                    "site_id" => $site->id,
                    "company_id" => $company->id,
                    "position" => $request->position,
                ]);

                TireMovement::create([
                    "tire_running_id" => $tirerunning->id,
                    "hm" => $request->hm,
                    "km" => $request->km,
                    "unit_lifetime_hm" => $unit->hm,
                    "unit_lifetime_km" => $unit->km,
                    "tire_lifetime_hm" => $tire->lifetime_hm,
                    "tire_lifetime_km" => $tire->lifetime_km,
                    "rtd" => $tire->rtd,
                    "start_date" => $request->start_date,
                    "end_date" => $request->end_date,
                    "pic" => $request->pic,
                    "pic_man_power" => $request->pic_man_power,
                    "desc" => $request->explanation
                ]);

            });
            // redirect the page
            return redirect()->back()->with('success', "install tire");
        } catch (\Throwable $e) {
            DB::rollback();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(TireRunning $tireRunning)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Unit $tirerunning)
    {
        $unit = Unit::where("id", $tirerunning->id)->with("unit_model")->first();
        $tire_size = $unit->unit_model->tire_size;
        $tire_running = TireRunning::with("tire", "tire.tire_size")->where('unit_id', $unit->id)->orderBy("position")->get();

        $tire_inventory = TireMaster::where('is_repairing', false)->where('is_retreading', false)
            ->whereNotIn("id", DB::table('tire_runnings')->select("tire_id")->where("company_id", auth()->user()->company_id))
            ->whereHas("tire_size", function ($query) use ($tire_size) {
                $query->where("size", $tire_size->size);
            })
            ->whereHas('tire_status', function ($query) {
                $query->whereIn('status', ['spare', 'new', 'repair']);
            })
            ->wherehas('site', function ($query) {
                $query->where('id', auth()->user()->site->id);
            })->get();
        // $tire_running = TireMovement::where('unit_number', $unit->unit_number)->whereHas('tire_status', function ($query) {
        //     $query->whereIn('status', ['running']);
        // })->get();
        // $primemover = $unit;
        // while (strtolower($primemover->unit_model->type) != 'prime mover' && $primemover->unit_head != null) {
        //     $primemover = $primemover->unit_head;
        // }
        // dd($tire_running);
        $unit_model = $unit->unit_model;
        $tire_damage = TireDamage::all();
        $tire_status = TireStatus::all();

        // $trailermovement = HistoryTrailerMovement::where('unit_install', $unit->unit_number)->orderBy('date_end', 'desc')->get();

        return view("admin.data.tireMovementEdit", compact("tire_running", "unit", "unit_model", "tire_status", "tire_damage", "tire_inventory", "tirerunning"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TireRunning $tirerunning)
    {
        $request->validate([
            "tire_id_1" => "required",
            "tire_id_2" => "required",
            "unit_id" => "required",
        ]);
        $company = auth()->user()->company;

        try {

            DB::transaction(function () use ($request, $tirerunning, $company) {
                $tire_1 = TireMaster::find($request->tire_id_1);
                $tire_2 = TireMaster::find($request->tire_id_2);
                $unit = Unit::find($request->unit_id);


                $unit = Unit::findOrFail($request->unit_id);

                if ($request->hm_actual > $unit->hm || $request->km_actual > $unit->km) {
                    // update tire lifetime
                    $tire_running = TireRunning::where('unit_id', $request->unit_id)->get();
                    foreach ($tire_running as $key => $running) {
                        $tire = $running->tire;
                        // update HM
                        if ($request->hm_actual > $unit->hm) {
                            $diff_smu = (int) $request->hm_actual - (int) $unit->hm;
                            $tire->lifetime_hm += $diff_smu;
                            if ($tire->is_repair)
                                $tire->lifetime_repair_hm += $diff_smu;
                            if ($tire->is_retread)
                                $tire->lifetime_retread_hm += $diff_smu;
                        }
                        // update KM
                        if ($request->km_actual > $unit->km) {
                            $diff_smu = (int) $request->km_actual - (int) $unit->km;
                            $tire->lifetime_km += $diff_smu;
                            if ($tire->is_repair)
                                $tire->lifetime_repair_km += $diff_smu;
                            if ($tire->is_retread)
                                $tire->lifetime_retread_km += $diff_smu;
                        }
                        $tire->save();
                    }
                    if ($request->hm_actual > $unit->hm)
                        $unit->hm = (int) $request->hm_actual;
                    if ($request->km_actual > $unit->km)
                        $unit->km = (int) $request->km_actual;
                    $unit->save();
                }

                $tire_1->tire_running->update([
                    "position" => 0
                ]);

                $tire_2->tire_running->update([
                    "position" => $request->tire_position_switch_1,
                ]);


                $tire_1->tire_running->update([
                    "position" => $request->tire_position_switch_2,
                ]);

                $tire_1->update([
                    "rtd" => $request->rtd_1,
                    "tire_damage_id" => $request->tire_damage_id_1,
                ]);

                $tire_2->update([
                    "rtd" => $request->rtd_2,
                    "tire_damage_id" => $request->tire_damage_id_2,
                ]);

                HistoryTireMovement::create([
                    "user_id" => auth()->id(),
                    "company_id" => $company->id,
                    "site_id" => auth()->user()->site->id,
                    "tire_damage_id" => $request->tire_damage_id_1,
                    "unit" => $unit->unit_number,
                    "tire" => $tire_1->serial_number,
                    "position" => $request->tire_position_switch_2,
                    "status" => $tire_1->tire_status->status,
                    "km_unit" => $unit->km,
                    "hm_unit" => $unit->hm,
                    "pic" => $request->pic,
                    "pic_man_power" => $request->pic_man_power,
                    "des" => $request->explanation,
                    "process" => "ROTATION",
                    "km_tire" => $tire_1->lifetime_km,
                    "hm_tire" => $tire_1->lifetime_hm,
                    "rtd" => $request->rtd_1,
                    "start_date" => $request->start_date,
                    "end_date" => $request->end_date,
                    "start_breakdown" => $request->start_breakdown,
                    "status_schedule" => $request->status_schedule,
                    "lokasi_breakdown" => $request->lokasi_breakdown,
                ]);

                HistoryTireMovement::create([
                    "user_id" => auth()->id(),
                    "company_id" => $company->id,
                    "site_id" => auth()->user()->site->id,
                    "tire_damage_id" => $request->tire_damage_id_2,
                    "unit" => $unit->unit_number,
                    "tire" => $tire_2->serial_number,
                    "position" => $request->tire_position_switch_1,
                    "status" => $tire_2->tire_status->status,
                    "km_unit" => $unit->km,
                    "hm_unit" => $unit->hm,
                    "pic" => $request->pic,
                    "pic_man_power" => $request->pic_man_power,
                    "des" => $request->explanation,
                    "process" => "ROTATION",
                    "km_tire" => $tire_2->lifetime_km,
                    "hm_tire" => $tire_2->lifetime_hm,
                    "rtd" => $request->rtd_2,
                    "start_date" => $request->start_date,
                    "end_date" => $request->end_date,
                    "start_breakdown" => $request->start_breakdown,
                    "status_schedule" => $request->status_schedule,
                    "lokasi_breakdown" => $request->lokasi_breakdown,
                ]);

                // dd($tire_1->tire_running);
                // dd($request);
            });

            return redirect()->back()->with('success', "remove tire");
        } catch (\Throwable $e) {
            DB::rollBack();
            // return redirect()->back()->with('error', "remove tire");
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);

        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, TireRunning $tirerunning)
    {
        $request->validate([
            'unit_id' => "required",
            'tire_id' => "required",
            'tire_status_id' => "required",
            'position' => "required",
            'start_date' => "required",
            'end_date' => "required",
            'hm' => "required",
            'rtd' => "required",
            "start_breakdown" => "required",
            "status_schedule" => "required",
            "lokasi_breakdown" => "required",
            "pic" => "required",
            "pic_man_power" => "required"
        ]);

        $company = auth()->user()->company;
        // try {
        //     $result = DB::transaction(function () use ($request, $tirerunning, $company) {

        // start update lifetime
        $unit = Unit::findOrFail($request->unit_id);

        if ($request->hm_actual > $unit->hm || $request->km_actual > $unit->km) {
            // update tire lifetime
            $tire_running = TireRunning::where('unit_id', $request->unit_id)->get();
            foreach ($tire_running as $key => $running) {
                $tire = $running->tire;



                // update ALL HM Tire
                if ($request->hm_actual > $unit->hm) {
                    $diff_smu = (int) $request->hm_actual - (int) $unit->hm;
                    $tire->lifetime_hm += $diff_smu;
                    if ($tire->is_repair)
                        $tire->lifetime_repair_hm += $diff_smu;
                    if ($tire->is_retread)
                        $tire->lifetime_retread_hm += $diff_smu;
                }
                // update ALL KM Tire
                if ($request->km_actual > $unit->km) {
                    $diff_smu = (int) $request->km_actual - (int) $unit->km;
                    $tire->lifetime_km += $diff_smu;
                    if ($tire->is_repair)
                        $tire->lifetime_repair_km += $diff_smu;
                    if ($tire->is_retread)
                        $tire->lifetime_retread_km += $diff_smu;
                }
                $tire->save();
            }
            if ($request->hm_actual > $unit->hm)
                $unit->hm = (int) $request->hm_actual;
            if ($request->km_actual > $unit->km)
                $unit->km = (int) $request->km_actual;
            $unit->save();
        }

        //endupdate lifetime

        // update removed tire
        $tire = TireMaster::findOrFail($request->tire_id);
        $tire->tire_status_id = $request->tire_status_id; // Update status
        if ($request->tire_status_id == 3) { // repairing
            $tire->is_repairing = true;
        }
        if ($request->tire_status_id == 4) { // retreading
            $tire->is_retreading = true;
        }

        $tire->rtd = $request->rtd;
        $tire->tire_damage_id = $request->tire_damage_id;
        $tire->save();

        HistoryTireMovement::create([
            "user_id" => auth()->id(),
            "company_id" => $company->id,
            "site_id" => auth()->user()->site->id,
            "tire_damage_id" => $request->tire_damage_id,
            "unit" => $unit->unit_number,
            "tire" => $tire->serial_number,
            "position" => $request->position,
            "status" => $tire->tire_status->status,
            "km_unit" => $unit->km,
            "hm_unit" => $unit->hm,
            "pic" => $request->pic,
            "pic_man_power" => $request->pic_man_power,
            "des" => $request->explanation,
            "process" => "REMOVE",
            "km_tire" => $tire->lifetime_km,
            "hm_tire" => $tire->lifetime_hm,
            "km_tire_repair" => $tire->lifetime_repair_km,
            "hm_tire_repair" => $tire->lifetime_repair_hm,
            "km_tire_retread" => $tire->lifetime_retread_km,
            "hm_tire_retread" => $tire->lifetime_retread_hm,
            "rtd" => $request->rtd,
            "start_date" => $request->start_date,
            "end_date" => $request->end_date,
            "start_breakdown" => $request->start_breakdown,
            "status_schedule" => $request->status_schedule,
            "lokasi_breakdown" => $request->lokasi_breakdown,

        ]);

        $tirerunning->delete();
        // $this->createActivity("Add History Tire Movement $tirerunning->id");

        // });
        // redirect the page
        return redirect()->back()->with('success', "remove tire");
        // } catch (\Throwable $e) {
        //     DB::rollback();
        //     return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        // }
    }
    public function adjustKmPasang(Request $request)
    {
        $request->validate([
            'unit_id' => 'required',
            'tanggal' => 'required',
            'adjust_km' => 'required|numeric|min:0',
            'adjust_hm' => 'required|numeric|min:0',
            'position' => 'required|array',
            'hm' => 'required|array',
            'km' => 'required|array',
        ]);


        try {

            $unit = Unit::whereId($request->unit_id)->with('tire_runnings.tire')->first();

            if ($unit->daily_inspect()->exists()) {
                return redirect()->back()->with('error', 'Tidak bisa adjust KM/HM Pasang Jika sudah ada inspection');
            }

            foreach ($request->position as $position) {
                $tire_running = $unit->tire_runnings->where('position', $position)->first();
                $tire_movement = $tire_running->tire_movement;
                $tire_movement->km = $request->km[$position];
                $tire_movement->hm = $request->hm[$position];
                $tire_movement->unit_lifetime_km = $request->km[$position];
                $tire_movement->unit_lifetime_hm = $request->hm[$position];
                $tire_movement->save();

                AdjustKmPasang::create([
                    "unit_id" => $request->unit_id,
                    "tire_id" => $tire_running->tire->serial_number,
                    "tanggal" => $request->tanggal,
                    "position" => $position,
                    "km_unit" => $unit->km,
                    "updated_km_unit" => $request->adjust_km,
                    "hm_unit" => $unit->hm,
                    "updated_hm_unit" => $request->adjust_hm,
                    "km" => $tire_running->tire->lifetime_km,
                    "updated_km" => $request->km[$position],
                    "hm" => $tire_running->tire->lifetime_hm,
                    "updated_hm" => $request->hm[$position],
                ]);

                $unit->km = $request->adjust_km;
                $unit->hm = $request->adjust_hm;
                $unit->save();
            }

            // Jika semuanya berhasil, commit transaksi
            DB::commit();
        } catch (\Exception $e) {
            // Blok ini hanya dijalankan jika terjadi pengecualian (exception)
            // Handle atau log kesalahan
            return "Transaction failed: " . $e->getMessage();
        }
        return redirect()->back()->with("success", "Created Adjust KM / HM Pasang");

    }
}

