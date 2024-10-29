<?php

namespace App\Http\Controllers;

use App\Models\AreaPekerjaan;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AreaPekerjaanController extends Controller
{
/**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $company = auth()->user()->company;

        if($request->ajax()) {
            $data = AreaPekerjaan::all();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('nama', function($row){
                    return $row->nama;
                })
                ->addColumn('action', function($row){
                    $actionBtn = "<a class='me-3 text-warning' href='#'
                                    data-bs-target='#form-modal'  data-bs-toggle='modal' data-id='$row->id'>
                                    <img src='assets/img/icons/edit.svg' alt='img'>
                                </a>
                                <a class='confirm-text' href='javascript:void(0);' data-bs-toggle='modal'
                                                    data-bs-target='#deleteModal' data-id='$row->id'
                                                    data-action='" . route('area-pekerjaan.destroy', $row->id) . "'
                                                    data-message='$row->nama'>
                                    <img src='assets/img/icons/delete.svg' alt='img'>
                                </a>";
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view("admin.master.area-pekerjaan.index");
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
            "nama" => "required",
        ]);

        AreaPekerjaan::create([
            "nama" => $request->nama,
            "company_id" => $company->id,
        ]);

        return redirect()->back()->with("success", "Created Area Pekerjaan");
    }

    /**
     * Display the specified resource.
     */
    public function show(AreaPekerjaan $areaPekerjaan)
    {
        return view("admin.master.area-pekerjaan.show", compact("areaPekerjaan"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AreaPekerjaan $areaPekerjaan)
    {
        return $areaPekerjaan;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AreaPekerjaan $areaPekerjaan)
    {
        $request->validate([
            "nama" => "required",
        ]);
        $areaPekerjaan->nama = $request->nama;
        $areaPekerjaan->save();

        return redirect()->back()->with("success", "Updated Area Pekerjaan");

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AreaPekerjaan $areaPekerjaan)
    {
        $areaPekerjaan->delete();

        return redirect()->back()->with("success", "Deleted Area Pekerjaan");
    }
}
