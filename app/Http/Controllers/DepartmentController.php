<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DepartmentController extends Controller
{
  /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $company = auth()->user()->company;

        if($request->ajax()) {
            $data = Department::all();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('department', function($row){
                    return $row->department;
                })
                ->addColumn('action', function($row){
                    $actionBtn = "<a class='me-3 text-warning' href='#'
                                    data-bs-target='#form-modal'  data-bs-toggle='modal' data-id='$row->id'>
                                    <img src='assets/img/icons/edit.svg' alt='img'>
                                </a>
                                <a class='confirm-text' href='javascript:void(0);' data-bs-toggle='modal'
                                                    data-bs-target='#deleteModal' data-id='$row->id'
                                                    data-action='" . route('department.destroy', $row->id) . "'
                                                    data-message='$row->department'>
                                    <img src='assets/img/icons/delete.svg' alt='img'>
                                </a>";
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view("admin.master.department.index");
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
            "department" => "required",
        ]);

        Department::create([
            "department" => $request->department,
        ]);

        return redirect()->back()->with("success", "Created Department");
    }

    /**
     * Display the specified resource.
     */
    public function show(Department $department)
    {
        return view("admin.master.department.show", compact("department"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Department $department)
    {
        return $department;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Department $department)
    {
        $request->validate([
            "department" => "required",
        ]);
        $department->department = $request->department;
        $department->save();

        return redirect()->back()->with("success", "Updated Department");

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department)
    {
        $department->delete();

        return redirect()->back()->with("success", "Deleted Department");
    }
}
