<?php

namespace App\Http\Controllers;

use App\Models\TireSize;
use App\Models\UnitModel;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class UnitModelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $company = auth()->user()->company;
        $tiresize = TireSize::with("tire_pattern")->with("tire_pattern.manufacture")->where('company_id', $company->id)->get();
        if ($request->ajax()) {
            $data = UnitModel::where('company_id', $company->id);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('tire_size', function ($row) {
                    return $row->tire_size->size;
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
        return view("admin.data.unitModel", compact('tiresize'));
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

        UnitModel::create([
            "company_id" => $company->id,
            "tire_size_id" => $request->tire_size_id,
            "brand" => $request->brand,
            "model" => $request->model,
            "type" => $request->type,
            "tire_qty" => $request->tire_qty,
            "axle_2_tire" => $request->axle_2_tire,
            "axle_4_tire" => $request->axle_4_tire,
            "axle_8_tire" => $request->axle_8_tire,
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

        $unitmodel->tire_size_id = $request->tire_size_id;
        $unitmodel->brand = $request->brand;
        $unitmodel->model = $request->model;
        $unitmodel->type = $request->type;
        $unitmodel->tire_qty = $request->tire_qty;
        $unitmodel->axle_2_tire = $request->axle_2_tire;
        $unitmodel->axle_4_tire = $request->axle_4_tire;
        $unitmodel->axle_8_tire = $request->axle_8_tire;
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