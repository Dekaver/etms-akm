<?php

namespace App\Http\Controllers;

use App\Models\TireManufacture;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class TireManufactureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $company = auth()->user()->company;

        if ($request->ajax()) {
            $data = TireManufacture::where('company_id', $company->id);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = "<a class='me-3 text-warning' href='#'
                                    data-bs-target='#form-modal'  data-bs-toggle='modal' data-id='$row->id'>
                                    <img src='assets/img/icons/edit.svg' alt='img'>
                                </a>
                                <a class='confirm-text' href='javascript:void(0);' data-bs-toggle='modal'
                                                    data-bs-target='#deleteModal' data-id='$row->id'
                                                    data-action='" . route('tiremanufacture.destroy', $row->id) . "'
                                                    data-message='$row->name'>
                                    <img src='assets/img/icons/delete.svg' alt='img'>
                                </a>";
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view("admin.master.tiremanufacture.index");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort(404);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $company = auth()->user()->company;

        TireManufacture::create([
            "name" => $request->name,
            "company_id" => $company->id,
        ]);

        return redirect()->back()->with("success", "Created Tire Manufacture");
    }

    /**
     * Display the specified resource.
     */
    public function show(TireManufacture $tiremanufacture)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TireManufacture $tiremanufacture)
    {

        return $tiremanufacture;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TireManufacture $tiremanufacture)
    {
        $tiremanufacture->name = $request->name;
        $tiremanufacture->save();

        return redirect()->back()->with("success", "Updated Tire Manufacture");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TireManufacture $tiremanufacture)
    {
        $tiremanufacture->delete();
        return redirect()->back()->with("success", "Deleted Tire Manufacture $tiremanufacture->name");
    }
}
