<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DriverController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $company = auth()->user()->company;

        if($request->ajax()) {
            $data = Driver::where('company_id', $company->id);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('nama', function($row){
                    return $row->nama;
                })
                ->addColumn('hp', function($row){
                    return $row->hp;
                })
                ->addColumn('email', function($row){
                    return $row->email;
                })
                ->addColumn('action', function($row){
                    $actionBtn = "<a class='me-3 text-warning' href='#'
                                    data-bs-target='#form-modal'  data-bs-toggle='modal' data-id='$row->id'>
                                    <img src='assets/img/icons/edit.svg' alt='img'>
                                </a>
                                <a class='confirm-text' href='javascript:void(0);' data-bs-toggle='modal'
                                                    data-bs-target='#deleteModal' data-id='$row->id'
                                                    data-action='" . route('driver.destroy', $row->id) . "'
                                                    data-message='$row->nama'>
                                    <img src='assets/img/icons/delete.svg' alt='img'>
                                </a>";
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view("admin.master.driver.index");
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
            "email" => "required",
            "nama" => "required",
            "hp" => "required"
        ]);

        Driver::create([
            "email" => $request->email,
            "nama" => $request->nama,
            "hp" => $request->hp,
            "company_id" => $company->id,
        ]);

        return redirect()->back()->with("success", "Created Driver");
    }

    /**
     * Display the specified resource.
     */
    public function show(Driver $driver)
    {
        return view("admin.master.driver.show", compact("driver"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Driver $driver)
    {
        return $driver;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Driver $driver)
    {
        $company = auth()->user()->company;
        $request->validate([
            "email" => "required",
            "nama" => "required",
            "hp" => "required"
        ]);

        $driver->email = $request->email;
        $driver->nama = $request->nama;
        $driver->hp = $request->hp;
        $driver->save();

        return redirect()->back()->with("success", "Updated Driver");

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Driver $driver)
    {
        $driver->delete();

        return redirect()->back()->with("success", "Deleted Driver");
    }
}
