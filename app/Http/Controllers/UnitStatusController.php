<?php

namespace App\Http\Controllers;

use App\Models\TireManufacture;
use App\Models\UnitStatus;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class UnitStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $company = auth()->user()->company;

        if ($request->ajax()) {
            $data = UnitStatus::where('company_id', $company->id);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = "<a class='me-3 text-warning' href='#'
                                    data-bs-target='#form-modal'  data-bs-toggle='modal' data-id='$row->id'>
                                    <img src='assets/img/icons/edit.svg' alt='img'>
                                </a>
                                <a class='confirm-text' href='javascript:void(0);' data-bs-toggle='modal'
                                                    data-bs-target='#deleteModal' data-id='$row->id'
                                                    data-action='" . route('unitstatus.destroy', $row->id) . "'
                                                    data-message='$row->name'>
                                    <img src='assets/img/icons/delete.svg' alt='img'>
                                </a>";
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view("admin.data.unitStatus");
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

        UnitStatus::create([
            "company_id" => $company->id,
            "status_code" => $request->status_code,
            "description" => $request->description,
        ]);

        return redirect()->back()->with("success", "Created Unit Status");
    }

    /**
     * Display the specified resource.
     */
    public function show(UnitStatus $unitstatus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UnitStatus $unitstatus)
    {
        return $unitstatus;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UnitStatus $unitstatus)
    {
        $unitstatus->status_code = $request->status_code;
        $unitstatus->description = $request->description;
        $unitstatus->save();

        return redirect()->back()->with("success", "Updated Unit Status");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UnitStatus $unitstatus)
    {
        $unitstatus->delete();

        return redirect()->back()->with("success", "Created Unit Status");
    }
}