<?php

namespace App\Http\Controllers;

use App\Models\TireMaster;
use App\Models\Site;
use App\Models\TireStatus;
use App\Models\TireCompound;
use App\Models\TireSize;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;

class TireMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $company = auth()->user()->company;
        $site = Site::where('company_id', $company->id)->get();
        $tiresize = TireSize::where('company_id', $company->id)->get();
        $tirecompound = TireCompound::where('company_id', $company->id)->get();
        $tirestatus = TireStatus::where('company_id', $company->id)->get();
        if ($request->ajax()) {
            $data = TireMaster::where('company_id', $company->id);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn("size", function ($row) {
                    return $row->tire_size->size;
                })
                ->addColumn("site", function ($row) {
                    return $row->site->name;
                })
                ->addColumn("status", function ($row) {
                    return $row->tire_status->status;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = "<a class='me-3 text-warning' href='#'
                                    data-bs-target='#form-modal'  data-bs-toggle='modal' data-id='$row->id'>
                                    <img src='assets/img/icons/edit.svg' alt='img'>
                                </a>
                                <a class='confirm-text' href='javascript:void(0);' data-bs-toggle='modal'
                                                    data-bs-target='#deleteModal' data-id='$row->id'
                                                    data-action='" . route('tiremaster.destroy', $row->id) . "'
                                                    data-message='$row->name'>
                                    <img src='assets/img/icons/delete.svg' alt='img'>
                                </a>";
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view("admin.master.tireMaster", compact('site', 'tiresize', 'tirecompound', 'tirestatus'));
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
            "lifetime" => "required",
            "rtd" => "required",
            "date" => "required"
        ]);

        $company = auth()->user()->company;
        $date = Carbon::createFromFormat('d-m-Y', $request->date)->format('Y-m-d');

        TireMaster::create([
            'company_id' => $company->id,
            'site_id' => $request->site_id,
            'serial_number' => $request->serial_number,
            'tire_size_id' => $request->tire_size_id,
            'tire_compound_id' => $request->tire_compound_id,
            'tire_status_id' => $request->tire_status_id,
            'lifetime_km' => 0,
            'lifetime_hm' => $request->lifetime,
            'rtd' => $request->rtd,
            'date' => $date,
        ]);

        return redirect()->back()->with("success", "Created Tire Master");
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
        $request->validate([
            "site_id" => "required",
            "serial_number" => "required",
            "tire_size_id" => "required",
            "tire_compound_id" => "required",
            "tire_status_id" => "required",
            "lifetime" => "required",
            "rtd" => "required",
            "date" => "required"
        ]);
        $date = Carbon::createFromFormat('d-m-Y', $request->date)->format('Y-m-d');

        $tiremaster->site_id = $request->site_id;
        $tiremaster->serial_number = $request->serial_number;
        $tiremaster->tire_size_id = $request->tire_size_id;
        $tiremaster->tire_compound_id = $request->tire_compound_id;
        $tiremaster->tire_status_id = $request->tire_status_id;
        $tiremaster->lifetime_hm = $request->lifetime;
        $tiremaster->rtd = $request->rtd;
        $tiremaster->date = $date;
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
}
