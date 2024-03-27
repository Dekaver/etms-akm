<?php

namespace App\Http\Controllers;

use App\Models\HistoryTireMovement;
use App\Models\TireDamage;
use App\Models\TireRepair;
use App\Models\TireMaster;
use App\Models\TireStatus;
use DB;
use Yajra\DataTables\DataTables;

use Illuminate\Http\Request;

class HistoryTireRepairController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $company = auth()->user()->company;
        $tire_damages = TireDamage::where("company_id", $company->id)->get();
        $data = TireRepair::where("company_id", $company->id)->get();
        if ($request->ajax()) {
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn("serial_number", function ($row) {
                    return $row->tire->serial_number;
                })
                ->addColumn("size", function ($row) {
                    return $row->tire->tire_size->size;
                })
                ->addColumn("pattern", function ($row) {
                    return $row->tire->tire_size->tire_pattern->pattern ?? "-";
                })
                ->addColumn("compound", function ($row) {
                    return $row->tire->tire_compound->compound;
                })
                ->addColumn("site", function ($row) {
                    return $row->tire->site->name;
                })
                ->addColumn("status", function ($row) {
                    return $row->tire->tire_status->status;
                })
                ->addColumn("start_date", function ($row) {
                    return $row->start_date;
                })
                ->addColumn("end_date", function ($row) {
                    return $row->end_date;
                })
                ->addColumn("man_power", function ($row) {
                    return $row->man_power;
                })
                ->addColumn("pic", function ($row) {
                    return $row->pic;
                })
                ->addColumn("action", function ($row) {
                    return "<a class='me-3 text-warning' href='#'
                                    data-bs-target='#form-modal-spare'  data-bs-toggle='modal' data-id='$row->id'
                                    data-action='" . route('historytirerepair.edit', $row->id) . "'>
                                    <img src='assets/img/icons/edit.svg' alt='img'>
                                </a>";
                })
                ->rawColumns(["action"])
                ->make(true);
        }
        return view("admin.history.historyTireRepair", compact("tire_damages"));
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
    public function show(TireRepair $tireRepair)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $tireRepairId)
    {
        $historyTire = TireRepair::with([
            'history_tire_movement'
        ])->where('id', $tireRepairId)->first();
        return $historyTire;
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TireMaster $tirerepair)
    {
        $request->validate([
            "man_power" => "required",
            "pic" => "required"
        ]);
        try {
            // dd($request->tire_damage);
            DB::transaction(function () use ($tirerepair, $request) {
                $tire_status_new = TireStatus::where('status', $request->tire_status)->first();
                $company = auth()->user()->company;

                // Define an array to hold the filenames for easier assignment to the model later
                $filenames = [
                    "foto_before_1" => null, "keterangan_before_1" => null,
                    "foto_after_1" => null, "keterangan_after_1" => null,
                    "foto_before_2" => null, "keterangan_before_2" => null,
                    "foto_after_2" => null, "keterangan_after_2" => null,
                    "foto_before_3" => null, "keterangan_before_3" => null,
                    "foto_after_3" => null, "keterangan_after_3" => null,
                ];

                // Loop through each "before" and "after" pair
                foreach (['before', 'after'] as $type) {
                    for ($i = 1; $i <= 3; $i++) {
                        $key = "foto_{$type}_{$i}";
                        if ($request->hasFile($key)) {
                            $file = $request->file($key);
                            $extension = $file->extension();
                            $filename = time() . $tirerepair->serial_number . "{$type}{$i}" . '.' . $extension;
                            $filePath = $file->storeAs("uploads/{$type}", $filename, 'public');
                            $filenames[$key] = $filename; // Store filename for later assignment
                        }
                        // Assign description (keterangan) for each foto
                        $descKey = "keterangan_{$type}_{$i}";
                        $filenames[$descKey] = $request->$descKey;
                    }
                }

                // Now create the TireRepair record using the $filenames array for foto and keterangan assignments
                $repair = TireRepair::create(array_merge([
                    "tire_id" => $tirerepair->id,
                    "company_id" => $company->id,
                    "tire_damage_id" => $request->tire_damage[0] ?? null,
                    "tire_damage_2_id" => $request->tire_damage[1] ?? null,
                    "tire_damage_3_id" => $request->tire_damage[2] ?? null,
                    "tire_status_id" => $tirerepair->tire_status_id,
                    "reason" => $request->reason,
                    "analisa" => $request->analisa,
                    "alasan" => $request->alasan,
                    "man_power" => $request->man_power,
                    "pic" => $request->pic,
                    "start_date" => $request->start_date,
                    "end_date" => $request->end_date,
                    "move" => $tirerepair->tire_status->status,
                    "history_tire_movement_id" => $request->history_tire_movement_id,
                ], $filenames)); // Merge the dynamic filenames with the static data

                // $tirerepair->tire_status_id = $tire_status_new->id; // tidak update status
                $tirerepair->is_repair = true;
                $tirerepair->is_repairing = false;
                $tirerepair->save();


                HistoryTireMovement::create([
                    "user_id" => auth()->id(),
                    "company_id" => $company->id,
                    "site_id" => auth()->user()->site->id,
                    "tire_damage_id" => $request->tire_damage_id,
                    "unit" => null,
                    "position" => null,
                    "tire" => $tirerepair->serial_number,
                    "status" => $tirerepair->tire_status->status,
                    "km_unit" => null,
                    "hm_unit" => null,
                    "pic" => $request->pic,
                    "pic_man_power" => $request->man_power,
                    "des" => $request->reason,
                    "process" => "REPAIR",
                    "km_tire" => $tirerepair->lifetime_km,
                    "hm_tire" => $tirerepair->lifetime_hm,
                    "km_tire_repair" => $tirerepair->lifetime_repair_km,
                    "hm_tire_repair" => $tirerepair->lifetime_repair_hm,
                    "km_tire_retread" => $tirerepair->lifetime_retread_km,
                    "hm_tire_retread" => $tirerepair->lifetime_retread_hm,
                    "rtd" => $tirerepair->rtd,
                    "start_date" => $request->start_date,
                    "end_date" => $request->end_date
                ]);
            });
            return redirect()->back()->with("success", "Move Tire Status");
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TireRepair $tireRepair)
    {
        //
    }
}
