<?php

namespace App\Http\Controllers;

use App\Models\TireMaster;
use App\Models\Site;
use App\Models\TireStatus;
use App\Models\TireCompound;
use App\Models\TireSize;
use DB;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Validator;
use Yajra\DataTables\DataTables;

class TireMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $tiresite_id = $request->query("tiresite");
        $tiresize_id = $request->query("tiresize");
        $tirestatus_id = $request->query("tirestatus");

        $company = auth()->user()->company;
        $site = Site::where('company_id', $company->id)->get();
        $tiresize = TireSize::where('company_id', $company->id)->with("tire_pattern")->with("tire_pattern.manufacture")->get();
        $tirecompound = TireCompound::where('company_id', $company->id)->get();
        $tirestatus = TireStatus::where('status', '!=', 'Scrap')->get();

        // foreach ($data as $item) {
        //     dd($item->countTireDamage);
        // }
        // dd($data);   
        if ($request->ajax()) {
            $data = TireMaster::where('company_id', $company->id)->get();
            if ($tiresite_id) {
                $data = $data->where('site_id', $tiresite_id);
            }
            if ($tiresize_id) {
                $data = $data->where('tire_size_id', $tiresize_id);
            }
            if ($tirestatus_id) {
                $data = $data->where('tire_status_id', $tirestatus_id);
            }
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn("size", function ($row) {
                    return $row->tire_size->size;
                })
                ->addColumn("site", function ($row) {
                    return $row->site->name;
                })
                ->addColumn("tire_repair", function ($row) {
                    return $row->countTireRepair;
                })
                ->addColumn("tire_damage", function ($row) {
                    return $row->countTireDamage;
                })
                ->addColumn("status", function ($row) {
                    return $row->tire_status->status;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = "<a class='text-warning' href='#'
                                    data-bs-target='#form-modal-edit'  data-bs-toggle='modal' data-id='$row->id'>
                                    <img src='assets/img/icons/edit.svg' alt='img'>
                                </a>
                                <a class='confirm-text' href='javascript:void(0);' data-bs-toggle='modal'
                                                    data-bs-target='#deleteModal' data-id='$row->id'
                                                    data-action='" . route('tiremaster.destroy', $row->id) . "'
                                                    data-message='$row->name'>
                                    <img src='assets/img/icons/delete.svg' alt='img'>
                                </a>
                                <a class='confirm-text' href='javascript:void(0);' data-bs-toggle='modal'
                                                    data-bs-target='#resetModal' data-id='$row->id'
                                                    data-action='" . route('tiremaster.reset', $row->id) . "'
                                                    data-message='$row->name'>
                                    <img src='assets/img/icons/reset.svg' alt='img'>
                                </a>";
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view("admin.master.tireMaster", compact('tiresite_id', 'tiresize_id', 'tirestatus_id', 'site', 'tiresize', 'tirecompound', 'tirestatus'));
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
            "site_id" => "required",
            "serial_number" => "required",
            "tire_size_id" => "required",
            "tire_compound_id" => "required",
            "tire_status_id" => "required",
            "lifetime_km" => "required",
            "lifetime_hm" => "required",
            "rtd" => "required",
            "date" => "required"
        ]);

        $company = auth()->user()->company;
        try {
            $result = DB::transaction(function () use ($request, $company) {
                $failed_create = [];
                foreach (preg_split("/\r\n|\r|\n/", $request->serial_number) as $key => $serial_number) {
                    $validator = Validator::make(['serial_number' => $serial_number], [
                        'serial_number' => [
                            'required',
                            'string',
                            'max:255',
                            Rule::unique('tires')->where(function ($query) use ($serial_number, $company) {
                                return $query->whereRaw('LOWER(serial_number) = ?', [strtolower($serial_number)])->where('company_id', $company->id);
                            }),
                        ],
                    ]);

                    // If validation fails, throw an exception to roll back the transaction
                    if ($validator->fails()) {
                        throw ValidationException::withMessages(['serial_number' => "The Serial Number \"$serial_number\" has already been taken."]);
                    }

                    TireMaster::create([
                        'company_id' => $company->id,
                        'tire_supplier_id' => 1,
                        'site_id' => $request->site_id,
                        'serial_number' => $serial_number,
                        'tire_size_id' => $request->tire_size_id,
                        'tire_compound_id' => $request->tire_compound_id,
                        'tire_status_id' => $request->tire_status_id,
                        'lifetime_km' => $request->lifetime_km,
                        'lifetime_hm' => $request->lifetime_hm,
                        'rtd' => $request->rtd,
                        'is_repairing' => $request->is_repairing === 'on' ? 1 : 0,
                        'date' => $request->date,
                    ]);
                }
            });
            return redirect()->back()->with("success", "Created Tire Master");
        } catch (\Throwable $e) {
            DB::rollback();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(TireMaster $tireMaster)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TireMaster $tiremaster)
    {
        return $tiremaster;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TireMaster $tiremaster)
    {
        $company = auth()->user()->company;
        $request->validate([
            "site_id" => "required",
            "serial_number" => [
                "required",
                "string",
                "max:255",
                Rule::unique("tires")->ignore($tiremaster->id)->where(function ($query) use ($request, $company) {
                    return $query
                        ->where("company_id", $company->id);
                }),
            ],
            "tire_size_id" => "required|exists:tire_sizes,id",
            "tire_compound_id" => "required",
            "tire_status_id" => "required",
            "lifetime_km" => "required",
            "lifetime_hm" => "required",
            "rtd" => "required",
            "date" => "required"
        ]);

        $tiremaster->site_id = $request->site_id;
        $tiremaster->tire_supplier_id = 1;
        $tiremaster->serial_number = $request->serial_number;
        $tiremaster->tire_size_id = $request->tire_size_id;
        $tiremaster->tire_compound_id = $request->tire_compound_id;
        $tiremaster->tire_status_id = $request->tire_status_id;
        $tiremaster->lifetime_km = $request->lifetime_km;
        $tiremaster->lifetime_hm = $request->lifetime_hm;
        $tiremaster->rtd = $request->rtd;
        $tiremaster->date = $request->date;
        $tiremaster->is_repairing = $request->is_repairing === 'on' ? 1 : 0;
        $tiremaster->save();

        return redirect()->back()->with("success", "Updated Tire Master");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TireMaster $tiremaster)
    {
        $tiremaster->delete();
        return redirect()->back()->with("success", "Deleted Tire Master $tiremaster->serial_number");
    }

    public function resetHistory(TireMaster $tiremaster)
    {
        DB::beginTransaction();
        try {
            // REMOVE ALL RELATION
            foreach ($tiremaster->daily_inspect_details as $key => $value) {
                if ($value->daily_inspect) {
                    $value->daily_inspect->details()->delete();
                    $value->daily_inspect()->delete();
                }
            }
            $tiremaster->daily_inspect_details()->delete();
            $tiremaster->tire_adjust_km()->delete();
            $tiremaster->tire_running()->delete();
            $tiremaster->tire_repair()->delete();
            $tiremaster->history_tire_movement()->delete();

            // RESET ALL VALUE
            $tiremaster->rtd = $tiremaster->tire_size->otd;
            $tiremaster->lifetime_km = 0;
            $tiremaster->lifetime_hm = 0;
            $tiremaster->lifetime_retread_km = 0;
            $tiremaster->lifetime_retread_hm = 0;
            $tiremaster->lifetime_repair_km = 0;
            $tiremaster->lifetime_repair_hm = 0;
            $tiremaster->is_repair = false;
            $tiremaster->is_retread = false;
            $tiremaster->is_repairing = false;
            $tiremaster->is_retreading = false;
            $tiremaster->tire_damage_id = null;

            $tiremaster->save();
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
        // $tiremaster->delete();
        return redirect()->back()->with("success", "RESET Tire Master $tiremaster->serial_number");
    }
}
