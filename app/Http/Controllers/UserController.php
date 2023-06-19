<?php

namespace App\Http\Controllers;

use App\Models\Site;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            if (Gate::allows("isSupeAadmin")) {
                $data = User::select('*');
            } else {
                $company_id = auth()->user()->company_id;
                $data = User::where("company_id", $company_id)->where("name", "!=", "superadmin");
            }

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = "<a class='me-3 text-warning' href='#'
                                    data-bs-target='#form-modal'  data-bs-toggle='modal' data-id='$row->id'>
                                    <img src='assets/img/icons/edit.svg' alt='img'>
                                </a>
                                <a class='confirm-text' href='javascript:void(0);' data-bs-toggle='modal'
                                                    data-bs-target='#deleteModal' data-id='$row->id'
                                                    data-action='" . route('user.destroy', $row->id) . "'
                                                    data-message='$row->name'>
                                    <img src='assets/img/icons/delete.svg' alt='img'>
                                </a>
                                <a class='me-3' href='" . route('user.index') . "/$row->id/permission'>
                                    <img src='assets/img/icons/settings.svg' alt='img'>
                                </a>";
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.users.index');
        // return $dataTable->render('admin.users.index');
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
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->new_password),
        ]);

        return redirect()->back()->with("success", "Created New User");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::find($id);
        return $user;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->new_password) {
            $user->password = bcrypt($request->new_password);
        }
        $user->save();

        return redirect()->back()->with("success", "Update New User");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        User::findOrFail($id)->delete();

        return redirect()->back();
    }

    public function indexPermission(string $id)
    {
        $user = User::findOrFail($id);
        $permissions = Permission::all();
        $roles = Role::all();
        $sites = Site::where("company_id", $user->company_id)->get();

        return view("admin.users.permission", compact('user', 'permissions', 'roles', 'sites'));
    }

    public function updatePermission(Request $request, string $id)
    {
        $user = User::findOrFail($id);
        $user->syncRoles([$request->role]);
        $user->syncPermissions($request->permission);
        // dd($user->userSite());
        if ($request->site_id) {
            $user->userSite()->delete();
            $user->userSite()->create([
                "site_id" => $request->site_id,
            ]);
        }

        return redirect()->back()->with("success", "Update Permission User");
    }

    public function updateCompany(Request $request, string $id)
    {
        auth()->user()->company()->update([
            "company_id" => $id
        ]);

        return redirect()->back()->with("success", "Update Company");
    }
}
