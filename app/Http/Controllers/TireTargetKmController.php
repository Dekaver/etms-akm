<?php

namespace App\Http\Controllers;

use App\Models\Site;
use App\Models\TireSize;
use App\Models\TireTargetKm;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class TireTargetKmController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $company = auth()->user()->company;
        $sites = Site::where('company_id', $company->id)->get();
        $tire_sizes = TireSize::where("company_id", $company->id)->get();

        if($request->ajax()) {
            $data = TireTargetKm::where('company_id', $company->id);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('site', function($row){
                    return $row->site->name;
                })
                ->addColumn('tire_size', function($row){
                    return $row->tire_size->size;
                })
                ->addColumn('manufacture', function($row){
                    return $row->tire_size->tire_pattern->manufacture->name;
                })
                ->addColumn('action', function($row){
                    $actionBtn = "<a class='me-3 text-warning' href='#'
                                    data-bs-target='#form-modal'  data-bs-toggle='modal' data-id='$row->id'>
                                    <img src='assets/img/icons/edit.svg' alt='img'>
                                </a>
                                <a class='confirm-text' href='javascript:void(0);' data-bs-toggle='modal'
                                                    data-bs-target='#deleteModal' data-id='$row->id'
                                                    data-action='" . route('tiretargetkm.destroy', $row->id) . "'
                                                    data-message='$row->name'>
                                    <img src='assets/img/icons/delete.svg' alt='img'>
                                </a>";
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view("admin.master.tiretargetkm.index", compact('sites', 'tire_sizes'));
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

        $request->validate([
            "site_id" => "required",
            "tire_size_id" => "required",
            "rtd_target_km" => "required"
        ]);

        TireTargetKm::create([
            "site_id" => $request->site_id,
            "tire_size_id" => $request->tire_size_id,
            "rtd_target_km" => $request->rtd_target_km,
            "company_id" => $company->id,
        ]);

        return redirect()->back()->with("success", "Created Tire Target Km");
    }

    /**
     * Display the specified resource.
     */
    public function show(TireTargetKm $tiretargetkm)
    {
        return view("admin.master.tiretargetkm.show", compact("tiretargetkm"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TireTargetKm $tiretargetkm)
    {
        return $tiretargetkm;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TireTargetKm $tiretargetkm)
    {
        $company = auth()->user()->company;
        $request->validate([
            "site_id" => "required",
            "tire_size_id" => "required",
            "rtd_target_km" => "required"
        ]);

        $tiretargetkm->site_id = $request->site_id;
        $tiretargetkm->tire_size_id = $request->tire_size_id;
        $tiretargetkm->rtd_target_km = $request->rtd_target_km;
        $tiretargetkm->save();

        return redirect()->back()->with("success", "Updated Tire Target Km");

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TireTargetKm $tiretargetkm)
    {
        $tiretargetkm->delete();

        return redirect()->back()->with("success", "Deleted Tire Target Km");
    }
}
