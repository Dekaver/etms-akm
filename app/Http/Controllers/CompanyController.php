<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\TireCompound;
use App\Models\TireDamage;
use App\Models\TireManufacture;
use App\Models\TirePattern;
use App\Models\TireStatus;
use App\Models\UnitStatus;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $company = auth()->user()->company;
        $companies = Company::where("name", "!=", "DEMO")->get();
        if ($request->ajax()) {
            $data = Company::whereNotNull("name");
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = "<a class='me-3 text-warning' href='#'
                                    data-bs-target='#form-update-modal'  data-bs-toggle='modal' data-id='$row->id'>
                                    <img src='assets/img/icons/edit.svg' alt='img'>
                                </a>
                                <a class='confirm-text' href='javascript:void(0);' data-bs-toggle='modal'
                                                    data-bs-target='#deleteModal' data-id='$row->id'
                                                    data-action='" . route('company.destroy', $row->id) . "'
                                                    data-message='$row->name'>
                                    <img src='assets/img/icons/delete.svg' alt='img'>
                                </a>";
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view("admin.master.company.index", compact("companies"));
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
            "name" => "required",
            "initial" => "required",
            "email" => "required",
        ]);

        $company = Company::create([
            "name" => $request->company_name,
            "initial" => $request->initial,
            "email" => $request->email,
        ]);

        $user = User::create([
            "name" => $request->company_name,
            "email" => $request->email,
            "company_id" => $company->id,
            "password" => bcrypt($request->password),
        ]);

        $user->syncRoles(["customeradmin"]);

        if ($request->clone_from == "on") {
            $selected_company_id = $request->customer;
            if ($request->master_only) {
                $a = TireManufacture::where("company_id", $selected_company_id)->get();
                foreach ($a as $key => $value) {
                    $value = $value->replicate();
                    $value->company_id = $company->id;
                    $value->save();
                }
                $a = TireStatus::where("company_id", $selected_company_id)->get();
                foreach ($a as $key => $value) {
                    $value = $value->replicate();
                    $value->company_id = $company->id;
                    $value->save();
                }
                $a = TireDamage::where("company_id", $selected_company_id)->get();
                foreach ($a as $key => $value) {
                    $value = $value->replicate();
                    $value->company_id = $company->id;
                    $value->save();
                }
                $a = TireCompound::where("company_id", $selected_company_id)->get();
                foreach ($a as $key => $value) {
                    $value = $value->replicate();
                    $value->company_id = $company->id;
                    $value->save();
                }
                $a = UnitStatus::where("company_id", $selected_company_id)->get();
                foreach ($a as $key => $value) {
                    $value = $value->replicate();
                    $value->company_id = $company->id;
                    $value->save();
                }
                $a = TirePattern::where("company_id", $selected_company_id)->get();
                foreach ($a as $key => $value) {
                    $manufacture = $value->manufacture;
                    $newTireManufacture = TireManufacture::where("name", $manufacture->name)->where("company_id", $selected_company_id)->first();
                    $value = $value->replicate();
                    $value->company_id = $company->id;
                    $value->tire_manufacture_id = $newTireManufacture->id;
                    $value->save();
                }
            }
        }

        return redirect()->back()->with("success", "Created Customer");
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company)
    {

        return $company;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Company $company)
    {
        $request->validate([
            "name" => "required",
            "initial" => "required"
        ]);
        $company->name = $request->name;
        $company->initial = $request->initial;
        $company->email = $request->email;
        $company->save();

        return redirect()->back()->with("success", "Updated Customer");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        $company->tire_compound()->delete();
        $company->tire_size()->delete();
        $company->tire_status()->delete();
        $company->tire_damage()->delete();
        $company->tire_pattern()->delete();
        $company->unit_status()->delete();
        $company->tire_manufacture()->delete();
        foreach ($company->site() as $key => $site) {
            $site->user->delete();
        }
        $company->user()->delete();
        $company->site()->delete();
        $company->delete();

        return redirect()->back()->with("success", "Deleted Customer $company->name");
    }
}
