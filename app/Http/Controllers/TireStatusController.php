<?php

namespace App\Http\Controllers;

use App\Models\TireStatus;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class TireStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $data = TireStatus::select("*");
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = "<a class='me-3 text-warning' href='#'
                                    data-bs-target='#form-modal'  data-bs-toggle='modal' data-id='$row->id'>
                                    <img src='assets/img/icons/edit.svg' alt='img'>
                                </a>
                                <a class='confirm-text' href='javascript:void(0);' data-bs-toggle='modal'
                                                    data-bs-target='#deleteModal' data-id='$row->id'
                                                    data-action='" . route('tirestatus.destroy', $row->id) . "'
                                                    data-message='$row->name'>
                                    <img src='assets/img/icons/delete.svg' alt='img'>
                                </a>";
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view("admin.master.tireStatus");
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
        $request->validate([
            "status" => [
                "required",
                "string",
                "max:255",
                Rule::unique("tire_statuses")->where(function ($query) use ($request) {
                    return $query;
                }),
            ],
        ]);

        TireStatus::create([
            "status" => $request->status,
        ]);

        return redirect()->back()->with("success", "Created Tire Status");
    }

    /**
     * Display the specified resource.
     */
    public function show(TireStatus $tireStatus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TireStatus $tirestatus)
    {
        return $tirestatus;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TireStatus $tirestatus)
    {
        $request->validate([
            "status" => [
                "required",
                "string",
                "max:255",
                Rule::unique("tire_statuses")->ignore($tirestatus->id)->where(function ($query) use ($request) {
                    return $query;
                }),
            ],
        ]);
        $tirestatus->status = $request->status;
        $tirestatus->save();

        return redirect()->back()->with("success", "Updated Tire Status");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TireStatus $tirestatus)
    {
        $tirestatus->delete();
        return redirect()->back()->with("success", "Deleted Tire Status $tirestatus->status");
    }
}
