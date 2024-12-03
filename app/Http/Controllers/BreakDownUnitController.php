<?php

namespace App\Http\Controllers;

use App\Imports\BreakDownUnitImport;
use App\Models\BreakDownUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class BreakDownUnitController extends Controller
{
    public function index(Request $request)
    {
        $company = auth()->user()->company;
        if($request->ajax()) {
            $data = BreakDownUnit::where('company_id', $company->id);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('site', function($row){
                    return $row->site->name;
                })
                ->addColumn('tipe', function($row){
                    return $row->unit_number->unit_model->type;
                })
                ->addColumn('model', function($row){
                    return $row->unit_number->unit_model->model;
                })
                ->addColumn("manpowers", function ($row) {
                    return $row->manpowersList; 
                })
                ->addColumn("hm_bd", function ($row) {
                    return number_format($row->hm_bd, 0, ',', '.');
                })
                ->addColumn("hm_ready", function ($row) {
                    return number_format($row->hm_ready, 0, ',', '.');
                })
                ->addColumn("start_bd", function ($row) {
                    return number_format($row->start_bd, 0, ',', '.');
                })
                ->addColumn("end_bd", function ($row) {
                    return number_format($row->end_bd, 0, ',', '.');
                })
                ->addColumn("duration_bd", function ($row) {
                    return number_format($row->duration_bd, 0, ',', '.');
                })
                ->addColumn('action', function($row){
                    $actionBtn = "
                                <a class='confirm-text' href='javascript:void(0);' data-bs-toggle='modal'
                                                    data-bs-target='#deleteModal' data-id='$row->id'
                                                    data-action='" . route('breakdown-unit.destroy', $row->id) . "'
                                                    data-message='$row->nama'>
                                    <img src='assets/img/icons/delete.svg' alt='img'>
                                </a>";
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.master.breakdown.index');
    }
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,xlsx,xls',
        ]);
        DB::beginTransaction(); // Mulai transaksi
        try {
            $file = $request->file('file');
            Excel::import(new BreakDownUnitImport, $file); // Proses impor
            DB::commit(); // Commit transaksi jika semua berhasil
            return redirect()->back()->with("success", "Data Berhasil Diimport");   
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback jika ada errorz
            return redirect()->back()->with("error", $e->getMessage());
        }
    }    
}
