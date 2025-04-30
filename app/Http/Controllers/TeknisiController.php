<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Department;
use App\Models\Jabatan;
use App\Models\Teknisi;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TeknisiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $department = Department::all();
        $jabatan = Jabatan::all();
        $company = Company::all();
        if ($request->ajax()) {
            $data = Teknisi::with(["jabatan", "department", "company"])->where('company_id', auth()->user()->company_id)->get();
            return DataTables::of($data)
                ->addIndexColumn()

                ->addColumn('nik', function ($row) {
                    return $row->nik;
                })
                ->addColumn('nama', function ($row) {
                    return $row->nama;
                })
                ->addColumn('kode', function ($row) {
                    return $row->kode;
                })
                ->addColumn('department', function ($row) {
                    return $row->department ? $row->department->department : 'N/A';
                })
                ->addColumn('jabatan', function ($row) {
                    return $row->jabatan ? $row->jabatan->jabatan : 'N/A';
                })
                ->addColumn('company', function ($row) {
                    return $row->company ? $row->company->name : 'N/A';
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = "<a class='me-3 text-warning' href='#'
                                    data-bs-target='#form-modal'  data-bs-toggle='modal' data-id='$row->id'>
                                    <img src='assets/img/icons/edit.svg' alt='img'>
                                </a>
                                <a class='confirm-text' href='javascript:void(0);' data-bs-toggle='modal'
                                                    data-bs-target='#deleteModal' data-id='$row->id'
                                                    data-action='" . route('teknisi.destroy', $row->id) . "'
                                                    data-message='$row->nama'>
                                    <img src='assets/img/icons/delete.svg' alt='img'>
                                </a>";
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view("admin.master.teknisi.index", compact("department", "jabatan", "company"));
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
        $request->validate([
            "nama" => "required",
        ]);

        $maxKode = Teknisi::max('kode');
        $kodeBaru = str_pad(($maxKode ? intval($maxKode) + 1 : 1), 5, '0', STR_PAD_LEFT);

        Teknisi::create([
            "nama" => $request->nama,
            "kode" => $kodeBaru,
            "department_id" => $request->department_id,
            "jabatan_id" => $request->jabatan_id,
            "company_id" => $request->company_id,
            "is_leader" => $request->is_leader == "on" ? true : false,
            "is_foreman" => $request->is_foreman == "on" ? true : false,
            "is_manpower" => $request->is_manpower == "on" ? true : false,
            "nik" => $request->nik
        ]);

        return redirect()->back()->with("success", "Created Teknisi");
    }

    /**
     * Display the specified resource.
     */
    public function show(Teknisi $teknisi)
    {
        return view("admin.master.teknisi.show", compact("teknisi"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Teknisi $teknisi)
    {
        return $teknisi;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Teknisi $teknisi)
    {
        $request->validate([
            "nama" => "required",
        ]);
        // dd($request->all());
        $teknisi->nama = $request->nama;
        $teknisi->department_id = $request->department_id;
        $teknisi->jabatan_id = $request->jabatan_id;
        $teknisi->company_id = $request->company_id;
        $teknisi->is_leader = $request->is_leader == "on" ? true : false;
        $teknisi->is_foreman = $request->is_foreman == "on" ? true : false;
        $teknisi->is_manpower = $request->is_manpower == "on" ? true : false;
        $teknisi->nik = $request->nik;
        $teknisi->save();

        return redirect()->back()->with("success", "Updated Teknisi");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Teknisi $teknisi)
    {
        $teknisi->delete();

        return redirect()->back()->with("success", "Deleted Teknisi");
    }
}
