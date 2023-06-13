<?php

namespace App\Http\Controllers;

use App\Models\TireManufacture;
use App\Models\TirePattern;
use App\Models\TireSize;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class TireSizeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $tire_manufacture = $request->query("tire_manufacture");
        $tire_size = $request->query("tire_size");
        $tire_pattern = $request->query("tire_pattern");


        $company = auth()->user()->company;
        $tirepattern = TirePattern::with("manufacture")->where('company_id', $company->id)->get();
        $tire_patterns = TirePattern::select("pattern")->where('company_id', $company->id)->groupBy("pattern")->get();
        $tire_sizes = TireSize::select("size")->where('company_id', $company->id)->groupBy("size")->get();
        $tire_manufactures = TireManufacture::where('company_id', $company->id)->get();

        if ($request->ajax()) {
            $data = TireSize::where('company_id', $company->id);
            if ($tire_manufacture) {
                $data = $data->whereHas("tire_pattern", function ($q) use ($tire_manufacture) {
                    $q->where("tire_manufacture_id", $tire_manufacture);
                });
            }
            if ($tire_pattern) {
                $data = $data->whereHas("tire_pattern", function ($q) use ($tire_pattern) {
                    $q->where("pattern", $tire_pattern);
                });
            }
            if ($tire_size) {
                $data = $data->where("size", $tire_size);
            }
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('pattern', function ($row) {
                    return $row->tire_pattern->pattern;
                })
                ->addColumn('manufacture', function ($row) {
                    return $row->tire_pattern->manufacture->name;
                })
                ->addColumn('manufacture_pattern', function ($row) {
                    return "{$row->tire_pattern->type_pattern}-{$row->tire_pattern->manufacture->name}-{$row->tire_pattern->pattern}";
                })
                ->addColumn('type', function ($row) {
                    return $row->tire_pattern->type_pattern;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = "<a class='me-3 text-warning' href='#'
                                    data-bs-target='#form-modal'  data-bs-toggle='modal' data-id='$row->id'>
                                    <img src='assets/img/icons/edit.svg' alt='img'>
                                </a>
                                <a class='confirm-text' href='javascript:void(0);' data-bs-toggle='modal'
                                                    data-bs-target='#deleteModal' data-id='$row->id'
                                                    data-action='" . route('tiresize.destroy', $row->id) . "'
                                                    data-message='$row->name'>
                                    <img src='assets/img/icons/delete.svg' alt='img'>
                                </a>";
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view("admin.master.tireSize", compact('tirepattern', 'tire_manufactures', 'tire_sizes', 'tire_patterns', 'tire_pattern', 'tire_size', 'tire_manufacture'));
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
            "pattern" => "required",
            "size" => "required",
            "tire_pattern_id" => "required",
            "otd" => "required",
            "recomended_pressure" => "required",
            "target_lifetime" => "required"
        ]);

        $company = auth()->user()->company;
        TireSize::create([
            'company_id' => $company->id,
            'size' => $request->size,
            'tire_pattern_id' => $request->tire_pattern_id,
            'otd' => $request->otd,
            'recomended_pressure' => $request->recomended_pressure,
            'target_lifetime' => $request->target_lifetime,
        ]);

        return redirect()->back()->with("success", "Created Tire Size");
    }

    /**
     * Display the specified resource.
     */
    public function show(TireSize $tireSize)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TireSize $tiresize)
    {
        return $tiresize;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TireSize $tiresize)
    {
        $request->validate([
            "pattern" => "required",
            "size" => "required",
            "tire_pattern_id" => "required",
            "otd" => "required",
            "recomended_pressure" => "required",
            "target_lifetime" => "required"
        ]);
        $tiresize->size = $request->size;
        $tiresize->tire_pattern_id = $request->tire_pattern_id;
        $tiresize->otd = $request->otd;
        $tiresize->recomended_pressure = $request->recomended_pressure;
        $tiresize->target_lifetime = $request->target_lifetime;
        $tiresize->save();

        return redirect()->back()->with("success", "Updated Tire Size");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TireSize $tiresize)
    {
        $tiresize->delete();
        return redirect()->back()->with("success", "Deleted Tire Size $tiresize->size");
    }
}
