<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class JabatanController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $company = auth()->user()->company;

        if($request->ajax()) {
            $data = Jabatan::all();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('jabatan', function($row){
                    return $row->jabatan;
                })
                ->addColumn('action', function($row){
                    $actionBtn = "<a class='me-3 text-warning' href='#'
                                    data-bs-target='#form-modal'  data-bs-toggle='modal' data-id='$row->id'>
                                    <img src='assets/img/icons/edit.svg' alt='img'>
                                </a>
                                <a class='confirm-text' href='javascript:void(0);' data-bs-toggle='modal'
                                                    data-bs-target='#deleteModal' data-id='$row->id'
                                                    data-action='" . route('jabatan.destroy', $row->id) . "'
                                                    data-message='$row->jabatan'>
                                    <img src='assets/img/icons/delete.svg' alt='img'>
                                </a>";
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view("admin.master.jabatan.index");
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
            "jabatan" => "required",
        ]);

        Jabatan::create([
            "jabatan" => $request->jabatan,
        ]);

        return redirect()->back()->with("success", "Created Jabatan");
    }

    /**
     * Display the specified resource.
     */
    public function show(Jabatan $jabatan)
    {
        return view("admin.master.jabatan.show", compact("jabatan"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Jabatan $jabatan)
    {
        return $jabatan;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Jabatan $jabatan)
    {
        $request->validate([
            "jabatan" => "required",
        ]);
        $jabatan->jabatan = $request->jabatan;
        $jabatan->save();

        return redirect()->back()->with("success", "Updated Jabatan");

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Jabatan $jabatan)
    {
        $jabatan->delete();

        return redirect()->back()->with("success", "Deleted Jabatan");
    }
}
