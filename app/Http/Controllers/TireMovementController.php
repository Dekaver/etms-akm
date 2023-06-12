<?php

namespace App\Http\Controllers;

use App\Models\TireDamage;
use App\Models\TireMaster;
use App\Models\TireRunning;
use App\Models\TireStatus;
use App\Models\Unit;
use App\Models\TireMovement;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TireMovementController extends Controller
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
                    $actionBtn = "<a class='me-3 text-warning' href='" . route('tiremovement.edit', $row->id) . "'>
                                    <img src='assets/img/icons/edit.svg' alt='img'>
                                </a>";
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view("admin.data.tiremovement");
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
    public function show(TireMovement $tireMovement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Unit $tiremovement)
    {
        $unit = Unit::where("id", $tiremovement->id)->with("unit_model")->first();
        $tire_running = TireRunning::where('unit_id', $unit->id)->orderBy("position")->get();

        $tire_inventory = TireMaster::whereHas('tire_status', function ($query) {
            $query->whereIn('status', ['spare', 'new']);
        })->wherehas('site', function ($query) {
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

        return view("admin.data.tiremovementedit", compact("tire_running", "unit", "unit_model", "tire_status", "tire_damage", "tire_inventory"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        dd($request);
        $result = DB::transaction(function () use ($request) {
            $request->validate([
                'unit_number' => "required",
                'tire_serial_number' => "required",
                'position' => "required",
                'date' => "required",
                'end_date' => "required",
                'pic' => "required",
                'pic_man_power' => "required",
            ]);

            $tire_status_running = TireStatus::where('status', 'running')->first();
            $tire_status_new = TireStatus::where('status', 'new install')->first();
            $unit = Unit::where('unit_number', $request->unit_number)->firstOrFail();
            $primemover = $unit;
            while (strtolower($primemover->unit_model->type) != 'prime mover' && $primemover->unit_head != null) {
                $primemover = $primemover->unit_head;
            }

            $primemover_unit = $primemover->unit_number;
            // dd($primemover_unit);
            $tire = Tire::where('serial_number', $request->tire_serial_number)->firstOrFail();
            // dd($primemover_unit);
            if ($request->hm_actual > 0) {
                $hm_actual = $request->hm_actual;
            } else {
                $hm_actual = $request->hm;
            }
            if ($tire->tire_status->status == 'New Stock' && $tire->lifetime == 0) {
                $tire_movement = HistoryTireMovement::create(
                    [
                        'tire_serial_number' => $request->tire_serial_number,
                        'position' => $request->position,
                        'tire_status_id' => $tire_status_new->id,
                        'unit_number' => $request->unit_number,
                        'primeover' => $primemover_unit,
                        'site_id' => auth()->user()->site->id,
                        // 'tire_damage_id' => $request->tire_damage_id,
                        'date' => $request->date,
                        'hm' => (int) $request->hm,
                        'hm_km_actual' => (int) $hm_actual,
                        'rtd' => $tire->rtd ?? 0,
                        'type_measure' => $request->type_measure,
                        'lifetime' => $request->lifetime,
                        'finish_date' => $request->end_date,
                        'desc' => 'Instal New Tire',
                        'start' => $request->start,
                        'end' => $request->end,
                        'pic' => $request->pic,
                        'pic_man_power' => $request->pic_man_power,
                        'date_end' => $request->date_end,
                        'start_breakdown' => $request->start_breakdown,
                        'status_breakdown' => $request->status_breakdown,
                        'lokasi_breakdown' => $request->lokasi_breakdown,
                        'tire_lifetime' => $tire->lifetime
                    ]
                );
                // dd($tire_movement);
            }
            $tire->update(['tire_status_id' => $tire_status_running->id, 'type_measure' => $unit->jenis]);
            if ($tire->is_repair) {
                $lifetime_repair = $tire->lifetime_repair;
                //    dd($lifetime_repair);
            }

            if ($tire->is_retread) {
                $lifetime_repair = $tire->lifetime_retread;
            }


            //  dd($hm_actual,$lifetime_repair);
            $tire_movement = HistoryTireMovement::create(
                [
                    'tire_serial_number' => $request->tire_serial_number,
                    'position' => $request->position,
                    'tire_status_id' => $tire_status_running->id,
                    'unit_number' => $request->unit_number,
                    'primeover' => $primemover_unit,
                    'site_id' => auth()->user()->site->id,
                    'tire_damage_id' => $request->tire_damage_id,
                    'date' => $request->date,
                    'hm' => (int) $request->hm,
                    'hm_km_actual' => (int) $hm_actual,
                    'rtd' => $tire->rtd ?? 0,
                    'type_measure' => $request->type_measure,
                    'lifetime' => $request->lifetime,
                    'finish_date' => $request->finish_date,
                    'desc' => $request->explaination,
                    'start' => $request->start,
                    'end' => $request->end,
                    'pic' => $request->pic,
                    'pic_man_power' => $request->pic_man_power,
                    'date_end' => $request->date_end,
                    'start_breakdown' => $request->start_breakdown,
                    'status_breakdown' => $request->status_breakdown,
                    'lokasi_breakdown' => $request->lokasi_breakdown,
                    'tire_lifetime' => $tire->lifetime,
                    'tire_lifetime_repair' => $lifetime_repair ?? 0,
                    'tire_lifetime_retread' => $lifetime_retread ?? 0,
                ]
            );

            $tire_movement = TireMovement::updateOrCreate(
                [
                    'unit_number' => $request->unit_number,
                    'position' => $request->position,
                    'tire_status_id' => $tire_status_running->id,
                ],
                [
                    'tire_serial_number' => $request->tire_serial_number,
                    'site_id' => auth()->user()->site->id,
                    'tire_damage_id' => $request->tire_damage_id,
                    'date' => $request->date,
                    'hm' => (int) $request->hm,
                    'hm_km_actual' => (int) $hm_actual,
                    'rtd' => $tire->rtd ?? 0,
                    'type_measure' => $request->type_measure,
                    'lifetime' => $request->lifetime,
                    'finish_date' => $request->finish_date,
                    'desc' => $request->explaination,
                    'start' => $request->start,
                    'end' => $request->end,
                    'pic' => $request->pic,
                    'pic_man_power' => $request->pic_man_power,
                    'date_end' => $request->date_end,
                    'start_breakdown' => $request->start_breakdown,
                    'status_breakdown' => $request->status_breakdown,
                    'lokasi_breakdown' => $request->lokasi_breakdown,
                    'tire_lifetime' => $tire->lifetime,
                ]
            );

        });
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TireMovement $tireMovement)
    {
        //

   }
}
