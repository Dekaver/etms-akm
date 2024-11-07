<?php

namespace App\Http\Controllers;

use App\Models\Size;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class SizeController extends Controller
{
/**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $company = auth()->user()->company;

        if($request->ajax()) {
            $data = Size::all();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('name', function($row){
                    return $row->name;
                })
                ->addColumn('action', function($row){
                    $actionBtn = "<a class='me-3 text-warning' href='#'
                                    data-bs-target='#form-modal'  data-bs-toggle='modal' data-id='$row->id'>
                                    <img src='assets/img/icons/edit.svg' alt='img'>
                                </a>
                                <a class='confirm-text' href='javascript:void(0);' data-bs-toggle='modal'
                                                    data-bs-target='#deleteModal' data-id='$row->id'
                                                    data-action='" . route('size.destroy', $row->id) . "'
                                                    data-message='$row->name'>
                                    <img src='assets/img/icons/delete.svg' alt='img'>
                                </a>";
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view("admin.master.size.index");
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
            "name" => "required",
        ]);

        Size::create([
            "name" => $request->name,
            "company_id" => $company->id,
        ]);

        return redirect()->back()->with("success", "Created Size");
    }

    /**
     * Display the specified resource.
     */
    public function show(Size $size)
    {
        return view("admin.master.size.show", compact("size"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Size $size)
    {
        return $size;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Size $size)
    {
        $request->validate([
            "name" => "required",
        ]);
        $size->name = $request->name;
        $size->save();

        return redirect()->back()->with("success", "Updated Size");

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Size $size)
    {
        $size->delete();

        return redirect()->back()->with("success", "Deleted Size");
    }
}
