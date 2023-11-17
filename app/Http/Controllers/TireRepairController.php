<?php

namespace App\Http\Controllers;

use App\Models\HistoryTireMovement;
use App\Models\TireDamage;
use App\Models\TireMaster;
use App\Models\TireRepair;
use App\Models\TireStatus;
use DB;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class TireRepairController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $company = auth()->user()->company;
        $tire_damages = TireDamage::all();
        if ($request->ajax()) {
            $data = TireMaster::where('company_id', $company->id)->where('is_repairing', true);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn("size", function ($row) {
                    return $row->tire_size->size;
                })
                ->addColumn("pattern", function ($row) {
                    return $row->tire_size->tire_pattern->pattern ?? "-";
                })
                ->addColumn("compound", function ($row) {
                    return $row->tire_compound->compound;
                })
                ->addColumn("site", function ($row) {
                    return $row->site->name;
                })
                ->addColumn("status", function ($row) {
                    return $row->tire_status->status;
                })
                ->addColumn("action", function ($row) {
                    return "<a class='me-3 text-warning' href='#'
                                    data-bs-target='#form-modal-spare'  data-bs-toggle='modal' data-id='$row->id'
                                    data-action='" . route('tirerepair.edit', $row->id) . "'>
                                    <img src='assets/img/icons/edit.svg' alt='img'>
                                </a>
                                <a class='me-3 text-warning' href='#'
                                    data-bs-target='#form-modal-scrap'  data-bs-toggle='modal' data-id='$row->id'
                                    data-action='" . route('tirerepair.edit', $row->id) . "'>
                                    <img src='assets/img/icons/delete.svg' alt='img'>
                                </a>";
                })
                ->rawColumns(["action"])
                ->make(true);
        }
        return view("admin.data.tireRepair", compact("tire_damages"));
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
    public function edit(string $tirerepair)
    {
        $tire = TireMaster::with("site")->where("id", $tirerepair)->first();
        return $tire;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TireMaster $tirerepair)
    {
        $request->validate([
            "man_power" => "required",
            "pic" => "required",
        ]);
        try {
            DB::transaction(function () use ($tirerepair, $request) {
                $tire_status_new = TireStatus::where('status', $request->tire_status)->first();
                $company = auth()->user()->company;

                TireRepair::create([
                    "tire_id" => $tirerepair->id,
                    "company_id" => $company->id,
                    "tire_damage_id" => $request->tire_damage_id,
                    "tire_status_id" => $tirerepair->tire_status_id,
                    "reason" => $request->reason,
                    "analisa" => $request->analisa,
                    "alasan" => $request->alasan,
                    "man_power" => $request->man_power,
                    "pic" => $request->pic,
                    "start_date" => $request->start_date,
                    "end_date" => $request->end_date,
                    "move" => $request->tire_status,
                ]);

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
