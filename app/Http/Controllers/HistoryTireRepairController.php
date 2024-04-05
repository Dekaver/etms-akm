<?php

namespace App\Http\Controllers;

use App\Models\HistoryTireMovement;
use App\Models\TireDamage;
use App\Models\TireRepair;
use App\Models\TireMaster;
use App\Models\TireRunning;
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
                    return "<a class='me-3 text-warning' href='" . route('historytirerepair.edit', $row->id) . "'>
                                    <img src='assets/img/icons/edit.svg' alt='img'>
                                </a>";
                })
                ->rawColumns(["action"])
                ->make(true);
        }
        return view("admin.history.historyTireRepair", compact("tire_damages"));
    }

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
    public function edit($id)
    {
        $company = auth()->user()->company;
        $tire_damages = TireDamage::where("company_id", $company->id)->get();
        $tire_repair = TireRepair::find($id);

        $historyTire = HistoryTireMovement::with(['tire_number', 'site', 'unit_number', 'driver'])
            ->whereHas('tire_number', function ($query) use ($tire_repair) {
                $query->where('id', $tire_repair->tire_id);
            })->where('STATUS', 'REPAIR')->where('id', $tire_repair->history_tire_movement_id)->first();
        // Get the current selections
        // dd($historyTire);
        $selectedDamages = [
            $tire_repair->tire_damage_id,
            $tire_repair->tire_damage_2_id,
            $tire_repair->tire_damage_3_id,
        ];

        $tire_repair_last = TireRepair::where('tire_id', $tire_repair->tire_id)->orderBy('id', 'DESC')->first();
        $isrunning = TireRunning::where('tire_id', $tire_repair->tire_id)->exists();
        $isTrue = true;
        if ($tire_repair_last->id != $tire_repair->id || $isrunning) {
            $isTrue = false;
        }
        return view("admin.history.historyTireRepairEdit", compact("historyTire", "isTrue", "tire_repair", "tire_damages", "selectedDamages"));
    }

    public function update(Request $request, $tireRepairId)
    {
        $request->validate([
            "man_power" => "required",
            "pic" => "required"
        ]);

        try {
            DB::transaction(function () use ($request, $tireRepairId) {
                $tireRepair = TireRepair::findOrFail($tireRepairId);
                $company = auth()->user()->company;

                // Assume tire_status is provided to update the tire's status
                // if ($request->has('tire_status')) {
                //     $tire_status_new = TireStatus::where('status', $request->tire_status)->firstOrFail();
                //     $tireRepair->tire_status_id = $tire_status_new->id;
                // }

                // Update tire damages if provided
                $tireRepair->tire_damage_id = $request->tire_damage[0] ?? null;
                $tireRepair->tire_damage_2_id = $request->tire_damage[1] ?? null;
                $tireRepair->tire_damage_3_id = $request->tire_damage[2] ?? null;

                // Loop to handle foto and keterangan updates as in your original code
                $filenames = []; // This will hold the new filenames for updating

                foreach (['before', 'after'] as $type) {
                    for ($i = 1; $i <= 3; $i++) {
                        $key = "foto_{$type}_{$i}";
                        if ($request->hasFile($key)) {
                            $file = $request->file($key);
                            $extension = $file->extension();
                            $filename = time() . $tireRepair->serial_number . "{$type}{$i}" . '.' . $extension;
                            $filePath = $file->storeAs("uploads/{$type}", $filename, 'public');
                            $filenames[$key] = $filename;
                        }
                        $descKey = "keterangan_{$type}_{$i}";
                        $filenames[$descKey] = $request->$descKey ?? null; // Ensure null if not provided
                    }
                }

                // Update the tire repair record with new filenames and descriptions
                $tireRepair->update($filenames);

                // Additional fields to update
                $tireRepair->fill([
                    'reason' => $request->reason,
                    'analisa' => $request->analisa,
                    'alasan' => $request->alasan,
                    'man_power' => $request->man_power,
                    'pic' => $request->pic,
                    'start_date' => $request->start_date,
                    'end_date' => $request->end_date
                ]);

                // $tireRepair->is_repair = true;
                // $tireRepair->is_repairing = false;
                $tireRepair->save();

                // For HistoryTireMovement, if you're just updating the last entry or a specific entry, fetch and update it. 
                // This example assumes a new history record for each update - adjust based on your logic.
                // Example: $history = HistoryTireMovement::where('tire_repair_id', $tireRepair->id)->latest()->first();

                // If updating an existing HistoryTireMovement is needed, fetch it using an appropriate identifier and update instead of creating a new one
            });

            return redirect()->back()->with("success", "Tire Repair Updated Successfully.");
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

    public function cetak($id)
    {
        $company = auth()->user()->company;
        $tire_damages = TireDamage::where("company_id", $company->id)->get();
        $tire_repair = TireRepair::find($id);

        $historyTire = HistoryTireMovement::with(['tire_number', 'site', 'unit_number', 'driver'])
            ->whereHas('tire_number', function ($query) use ($tire_repair) {
                $query->where('id', $tire_repair->tire_id);
            })->where('STATUS', 'REPAIR')->where('id', $tire_repair->history_tire_movement_id)->first();

        $selectedDamages = array_filter([
            $tire_repair->tire_damage->damage ?? null,
            $tire_repair->tire_damage2->damage ?? null,
            $tire_repair->tire_damage3->damage ?? null,
        ], function ($value) {
            return !is_null($value);
        });

        return view("admin.history.historyTireRepairCetak", compact("historyTire", "tire_repair", "tire_damages", "selectedDamages"));
    }
}
