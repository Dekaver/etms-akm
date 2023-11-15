<?php

namespace App\Http\Controllers;

use App\Models\TireDamage;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class TireDamageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $company = auth()->user()->company;

        if ($request->ajax()) {
            $data = TireDamage::where('company_id', $company->id);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = "<a class='me-3 text-warning' href='#'
                                    data-bs-target='#form-modal'  data-bs-toggle='modal' data-id='$row->id'>
                                    <img src='assets/img/icons/edit.svg' alt='img'>
                                </a>
                                <a class='confirm-text' href='javascript:void(0);' data-bs-toggle='modal'
                                                    data-bs-target='#deleteModal' data-id='$row->id'
                                                    data-action='" . route('tiredamage.destroy', $row->id) . "'
                                                    data-message='$row->name'>
                                    <img src='assets/img/icons/delete.svg' alt='img'>
                                </a>";
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view("admin.master.tireDamage");
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
            "damage" => [
                "required",
                "string",
                "max:255",
                Rule::unique("tire_damages")->where(function ($query) use ($company) {
                    return $query
                        ->where("company_id", $company->id);
                }),
            ],
            "cause" => "required",
            "rating" => "required"
        ]);

        TireDamage::create([
            "damage" => $request->damage,
            "cause" => $request->cause,
            "rating" => $request->rating,
            "company_id" => $company->id,
        ]);

        return redirect()->back()->with("success", "Created Tire Damage");
    }

    /**
     * Display the specified resource.
     */
    public function show(TireDamage $tireDamage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TireDamage $tiredamage)
    {
        return $tiredamage;

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TireDamage $tiredamage)
    {
        $company = auth()->user()->company;
        $request->validate([
            "damage" => [
                "required",
                "string",
                "max:255",
                Rule::unique("tire_damages")->ignore($tiredamage->id)->where(function ($query) use ($request, $company) {
                    return $query
                        ->where("company_id", $company->id);
                }),
            ],
            "cause" => "required",
            "rating" => "required"
        ]);

        $tiredamage->damage = $request->damage;
        $tiredamage->cause = $request->cause;
        $tiredamage->rating = $request->rating;
        $tiredamage->save();

        return redirect()->back()->with("success", "Updated Tire Damage");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TireDamage $tiredamage)
    {
        $tiredamage->delete();
        return redirect()->back()->with("success", "Deleted Tire Damage $tiredamage->damage");
    }
}
