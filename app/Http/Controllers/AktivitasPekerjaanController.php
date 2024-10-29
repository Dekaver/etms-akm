<?php

namespace App\Http\Controllers;

use App\Models\AktivitasPekerjaan;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AktivitasPekerjaanController extends Controller
{
  /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $company = auth()->user()->company;

        if($request->ajax()) {
            $data = AktivitasPekerjaan::all();
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
                                                    data-action='" . route('aktivitas-pekerjaan.destroy', $row->id) . "'
                                                    data-message='$row->nama'>
                                    <img src='assets/img/icons/delete.svg' alt='img'>
                                </a>";
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view("admin.master.aktivitas-pekerjaan.index");
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

        AktivitasPekerjaan::create([
            "nama" => $request->nama,
            "company_id" => $company->id,
        ]);

        return redirect()->back()->with("success", "Created Aktivitas Pekerjaan");
    }

    /**
     * Display the specified resource.
     */
    public function show(AktivitasPekerjaan $aktivitasPekerjaan)
    {
        return view("admin.master.aktivitas-pekerjaan.show", compact("aktivitasPekerjaan"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AktivitasPekerjaan $aktivitasPekerjaan)
    {
        return $aktivitasPekerjaan;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AktivitasPekerjaan $aktivitasPekerjaan)
    {
        $request->validate([
            "nama" => "required",
        ]);
        $aktivitasPekerjaan->nama = $request->nama;
        $aktivitasPekerjaan->save();

        return redirect()->back()->with("success", "Updated Aktivitas Pekerjaan");

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AktivitasPekerjaan $aktivitasPekerjaan)
    {
        $aktivitasPekerjaan->delete();

        return redirect()->back()->with("success", "Deleted Aktivitas Pekerjaan");
    }
}
