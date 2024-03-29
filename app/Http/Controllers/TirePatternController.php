<?php

namespace App\Http\Controllers;

use App\Models\TireManufacture;
use App\Models\TirePattern;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class TirePatternController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $tire_manufacture_id = $request->query("manufacture");
        $type_pattern = $request->query("type_pattern");

        $company = auth()->user()->company;
        $tiremanufacture = TireManufacture::where('company_id', $company->id)->get();
        if ($request->ajax()) {
            $data = TirePattern::where('company_id', $company->id);
            if ($type_pattern) {
                $data = $data->where('type_pattern', $type_pattern);
            }
            if ($tire_manufacture_id) {
                $data = $data->where('tire_manufacture_id', $tire_manufacture_id);
            }
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('manufacture_name', function ($row) {
                    return $row->manufacture->name;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = "<a class='me-3 text-warning' href='#'
                                    data-bs-target='#form-modal'  data-bs-toggle='modal' data-id='$row->id'>
                                    <img src='assets/img/icons/edit.svg' alt='img'>
                                </a>
                                <a class='confirm-text' href='javascript:void(0);' data-bs-toggle='modal'
                                                    data-bs-target='#deleteModal' data-id='$row->id'
                                                    data-action='" . route('tirepattern.destroy', $row->id) . "'
                                                    data-message='$row->name'>
                                    <img src='assets/img/icons/delete.svg' alt='img'>
                                </a>";
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view("admin.master.tirePattern", compact('tiremanufacture', 'tire_manufacture_id', 'type_pattern'));
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
            "pattern" => [
                "required",
                "string",
                "max:255",
                Rule::unique("tire_patterns")->where(function ($query) use ($request, $company) {
                    return $query
                        ->where("tire_manufacture_id", $request->tire_manufacture_id)
                        ->where("type_pattern", $request->type_pattern)
                        ->where("company_id", $company->id);
                }),
            ],
            "type_pattern" => "required",
            "tire_manufacture_id" => "required|exists:tire_manufactures,id",
        ]);
        TirePattern::create([
            'company_id' => $company->id,
            'pattern' => $request->pattern,
            'type_pattern' => $request->type_pattern,
            'tire_manufacture_id' => $request->tire_manufacture_id,
        ]);

        return redirect()->back()->with("success", "Created Tire Pattern");
    }

    /**
     * Display the specified resource.
     */
    public function show(TirePattern $tirePattern)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TirePattern $tirepattern)
    {
        return $tirepattern;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TirePattern $tirepattern)
    {
        $company = auth()->user()->company;
        $request->validate([
            "pattern" => [
                "required",
                "string",
                "max:255",
                Rule::unique("tire_patterns")->ignore($tirepattern->id)->where(function ($query) use ($request, $company) {
                    return $query
                        ->where("tire_manufacture_id", $request->tire_manufacture_id)
                        ->where("type_pattern", $request->type_pattern)
                        ->where("company_id", $company->id);
                }),
            ],
            "type_pattern" => "required",
            "tire_manufacture_id" => "required|exists:tire_manufactures,id",
        ]);
        $tirepattern->pattern = $request->pattern;
        $tirepattern->type_pattern = $request->type_pattern;
        $tirepattern->tire_manufacture_id = $request->tire_manufacture_id;
        $tirepattern->save();

        return redirect()->back()->with("success", "Updated Tire Pattern");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TirePattern $tirepattern)
    {
        $tirepattern->delete();
        return redirect()->back()->with("success", "Deleted Tire Pattern $tirepattern->name");
    }
}
