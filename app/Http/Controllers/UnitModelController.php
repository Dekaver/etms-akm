<?php

namespace App\Http\Controllers;

use App\Models\TireSize;
use App\Models\UnitModel;
use DB;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class UnitModelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $tiresize_id = $request->query("tiresize");

        $company = auth()->user()->company;
        $tiresize = TireSize::where('company_id', $company->id)
            ->get();

        if ($request->ajax()) {
            $data = UnitModel::where('company_id', $company->id);
            if ($tiresize_id) {
                $data = $data->where('tire_size_id', $tiresize_id);
            }
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('tire_size', function ($row) {
                    return $row->tire_size->size;
                })
                ->addColumn('tire_pattern', function ($row) {
                    return $row->tire_size->tire_pattern->pattern;
                })
                ->addColumn('type_pattern', function ($row) {
                    return $row->tire_size->tire_pattern->type_pattern;
                })
                ->addColumn('tire_manufacture', function ($row) {
                    return $row->tire_size->tire_pattern->manufacture->name;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = "<a class='me-3 text-warning' href='#'
                                    data-bs-target='#form-modal'  data-bs-toggle='modal' data-id='$row->id'>
                                    <img src='assets/img/icons/edit.svg' alt='img'>
                                </a>
                                <a class='confirm-text' href='javascript:void(0);' data-bs-toggle='modal'
                                                    data-bs-target='#deleteModal' data-id='$row->id'
                                                    data-action='" . route('unitmodel.destroy', $row->id) . "'
                                                    data-message='$row->name'>
                                    <img src='assets/img/icons/delete.svg' alt='img'>
                                </a>";
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view("admin.data.unitModel", compact('tiresize_id', 'tiresize'));
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
            "model" => [
                "required",
                "string",
                "max:255",
                Rule::unique("unit_models")->where(function ($query) use ($request, $company) {
                    return $query
                        ->where("tire_size_id", $request->tire_size_id)
                        ->where("company_id", $company->id);
                }),
            ],
            "tire_size_id" => "required",
            "brand" => "required|string|max:255",
            "type" => "required|string|max:255",
            "tire_qty" => "required",
            "axle_2_tire" => "required",
            "axle_4_tire" => "required",
        ]);

        UnitModel::create([
            "company_id" => $company->id,
            "tire_size_id" => $request->tire_size_id,
            "brand" => $request->brand,
            "model" => $request->model,
            "type" => $request->type,
            "tire_qty" => $request->tire_qty,
            "axle_2_tire" => $request->axle_2_tire,
            "axle_4_tire" => $request->axle_4_tire,
            "axle_8_tire" => 0,
            "informasi_berat_kosong" => $request->informasi_berat_kosong,
            "distribusi_beban" => $request->distribusi_beban,
            "standar_load_capacity" => $request->standar_load_capacity,
        ]);

        return redirect()->back()->with("success", "Created Unit Model");

    }

    /**
     * Display the specified resource.
     */
    public function show(UnitModel $unitmodel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UnitModel $unitmodel)
    {
        return $unitmodel;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UnitModel $unitmodel)
    {

        $request->validate([
            "model" =>
                [
                    "required",
                    "string",
                    "max:255",
                    Rule::unique("unit_models")->ignore($unitmodel->id)->where(function ($query) use ($unitmodel) {
                        return $query->where("company_id", $unitmodel->company_id);
                    })
                ],
            "tire_size_id" => "required",
            "brand" => "required",
            "model" => "required",
            "type" => "required",
            "tire_qty" => "required",
            "axle_2_tire" => "required",
            "axle_4_tire" => "required",
        ]);

        $unitmodel->tire_size_id = $request->tire_size_id;
        $unitmodel->brand = $request->brand;
        $unitmodel->model = $request->model;
        $unitmodel->type = $request->type;
        $unitmodel->tire_qty = $request->tire_qty;
        $unitmodel->axle_2_tire = $request->axle_2_tire;
        $unitmodel->axle_4_tire = $request->axle_4_tire;
        $unitmodel->axle_8_tire = 0;
        $unitmodel->distribusi_beban = $request->distribusi_beban;
        $unitmodel->informasi_berat_kosong = $request->informasi_berat_kosong;
        $unitmodel->standar_load_capacity = $request->standar_load_capacity;
        $unitmodel->save();

        return redirect()->back()->with("success", "Updated Unit Model");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UnitModel $unitmodel)
    {
        $unitmodel->delete();
        return redirect()->back()->with("success", "Deleted Unit Model $unitmodel->model");
    }
}
