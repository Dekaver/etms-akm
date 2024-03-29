<?php

namespace App\Http\Controllers;

use App\Models\TireCompound;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class TireCompoundController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $company = auth()->user()->company;

        if ($request->ajax()) {
            $data = TireCompound::where('company_id', $company->id);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = "<a class='me-3 text-warning' href='#'
                                    data-bs-target='#form-modal'  data-bs-toggle='modal' data-id='$row->id'>
                                    <img src='assets/img/icons/edit.svg' alt='img'>
                                </a>
                                <a class='confirm-text' href='javascript:void(0);' data-bs-toggle='modal'
                                                    data-bs-target='#deleteModal' data-id='$row->id'
                                                    data-action='" . route('tirecompound.destroy', $row->id) . "'
                                                    data-message='$row->name'>
                                    <img src='assets/img/icons/delete.svg' alt='img'>
                                </a>";
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view("admin.master.tireCompound");
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
        $request->validate([
            "compound" => [
                "required",
                "string",
                "max:255",
                Rule::unique("tire_compounds")->where(function ($query) use ($request, $company) {
                    return $query
                        ->where("company_id", $company->id);
                }),
            ],
        ]);

        TireCompound::create([
            "compound" => $request->compound,
            "company_id" => $company->id,
        ]);

        return redirect()->back()->with("success", "Created Tire Compound");
    }

    /**
     * Display the specified resource.
     */
    public function show(TireCompound $tireCompound)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TireCompound $tirecompound)
    {
        return $tirecompound;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TireCompound $tirecompound)
    {
        $company = auth()->user()->company;
        $request->validate([
            "compound" => [
                "required",
                "string",
                "max:255",
                Rule::unique("tire_compounds")->ignore($tirecompound->id)->where(function ($query) use ($request, $company) {
                    return $query
                        ->where("company_id", $company->id);
                }),
            ],
        ]);
        $tirecompound->compound = $request->compound;
        $tirecompound->save();

        return redirect()->back()->with("success", "Updated Tire Compound");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TireCompound $tirecompound)
    {
        $tirecompound->delete();
        return redirect()->back()->with("success", "Deleted Tire Compound $tirecompound->name");
    }
}
