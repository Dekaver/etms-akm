<?php

namespace App\Http\Controllers;

use App\Models\Site;
use App\Models\Unit;
use App\Models\UnitModel;
use App\Models\UnitStatus;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $company = auth()->user()->company;

        $sites = Site::where('company_id', $company->id)->get();
        $unit_status = UnitStatus::where('company_id', $company->id)->get();
        $unit_model = UnitModel::where('company_id', $company->id)->get();

        if ($request->ajax()) {
            $data = Unit::where('company_id', $company->id);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    return $row->unit_status->status_code;
                })
                ->addColumn('value', function ($row) {
                    return ($row->jenis == 'km') ? $row->km : $row->hm;
                })
                ->addColumn('site', function ($row) {
                    return $row->site->name;
                })
                ->addColumn('model', function ($row) {
                    return $row->unit_model->model;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = "<a class='me-3 text-warning' href='#'
                                    data-bs-target='#form-modal'  data-bs-toggle='modal' data-id='$row->id'>
                                    <img src='assets/img/icons/edit.svg' alt='img'>
                                </a>
                                <a class='confirm-text' href='javascript:void(0);' data-bs-toggle='modal'
                                                    data-bs-target='#deleteModal' data-id='$row->id'
                                                    data-action='" . route('unit.destroy', $row->id) . "'
                                                    data-message='$row->name'>
                                    <img src='assets/img/icons/delete.svg' alt='img'>
                                </a>";
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view("admin.data.unit", compact('unit_status', 'unit_model', 'sites'));
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
        $km = 0;
        $hm = 0;
        if ($request->jenis == "hm") {
            $hm = (int) $request->value;
        } elseif ($request->jenis == "km") {
            $km = (int) $request->value;
        }

        Unit::create([
            "company_id" => $company->id,
            "unit_model_id" => $request->unit_model_id,
            "unit_status_id" => $request->unit_status_id,
            "site_id" => $request->site_id,
            "unit_number" => $request->unit_number,
            "head" => $request->head,
            "km" => $km,
            "hm" => $hm,
        ]);

        return redirect()->back()->with("success", "Created Unit");
    }

    /**
     * Display the specified resource.
     */
    public function show(Unit $unit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Unit $unit)
    {
        return $unit;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Unit $unit)
    {

        $km = 0;
        $hm = 0;
        if ($request->jenis == "hm") {
            $hm = (int) $request->value;
        } elseif ($request->jenis == "km") {
            $km = (int) $request->value;
        }

        $unit->unit_model_id = $request->unit_model_id;
        $unit->unit_status_id = $request->unit_status_id;
        $unit->site_id = $request->site_id;
        $unit->unit_number = $request->unit_number;
        $unit->head = $request->head;
        $unit->km = $km;
        $unit->hm = $hm;
        $unit->save();

        return redirect()->back()->with("success", "Updated Unit");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Unit $unit)
    {
        $unit->delete();
        return redirect()->back()->with("success", "Deleted Unit $unit->unit_number");
    }
}