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
            $data = TireSize::where('company_id', $company->id);
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
                                                    data-action='" . route('unit_model.destroy', $row->id) . "'
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(UnitModel $unitModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UnitModel $unitModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UnitModel $unitModel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UnitModel $unitModel)
    {
        //
    }
}
