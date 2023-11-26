<?php

namespace App\Http\Controllers;

use App\Models\Site;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class SiteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $company = auth()->user()->company;

        if ($request->ajax()) {
            $data = Site::where('company_id', $company->id);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = "<a class='me-3 text-warning' href='#'
                                    data-bs-target='#form-modal'  data-bs-toggle='modal' data-id='$row->id'>
                                    <img src='assets/img/icons/edit.svg' alt='img'>
                                </a>
                                <a class='confirm-text' href='javascript:void(0);' data-bs-toggle='modal'
                                                    data-bs-target='#deleteModal' data-id='$row->id'
                                                    data-action='" . route('site.destroy', $row->id) . "'
                                                    data-message='$row->name'>
                                    <img src='assets/img/icons/delete.svg' alt='img'>
                                </a>";
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view("admin.master.site.index");
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
            "name" => [
                "required",
                "string",
                "max:255",
                Rule::unique("sites")->where(function ($query) use ($company) {
                    return $query
                        ->where("company_id", $company->id);
                }),
            ],
            'jarak_hauling' => 'required',
            'rit_per_hari' => 'required',
            'total_jarak' =>'required',
        ]);

        Site::create([
            "name" => $request->name,
            "jarak_hauling" => $request->jarak_hauling,
            "rit_per_hari" => $request->rit_per_hari,
            "total_jarak" => $request->total_jarak,
            "company_id" => $company->id,

        ]);

        return redirect()->back()->with("success", "Created Site");
    }

    /**
     * Display the specified resource.
     */
    public function show(Site $site)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Site $site)
    {
        return $site;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Site $site)
    {
        $company = auth()->user()->company;
        $request->validate([
            "name"=> [
                "required",
                "string",
                "max:255",
                Rule::unique("sites")->ignore($site->id)->where(function ($query) use ($company) {
                    return $query->where("company_id", $company->id);
                })
            ],
            'jarak_hauling' =>'required',
            'rit_per_hari' =>'required',
            'total_jarak' =>'required',
        ]);

        $site->name = $request->name;
        $site->jarak_hauling = $request->jarak_hauling;
        $site->rit_per_hari = $request->rit_per_hari;
        $site->total_jarak = $request->total_jarak;
        $site->save();

        return redirect()->back()->with("success", "Update Site");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Site $site)
    {
        $site->delete();
        return redirect()->back()->with("success", "Deleted Site");
    }
}
