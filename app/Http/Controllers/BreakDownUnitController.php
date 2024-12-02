<?php

namespace App\Http\Controllers;

use App\Imports\BreakDownUnitImport;
use App\Models\BreakDownUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class BreakDownUnitController extends Controller
{
    public function index()
    {
        $data = BreakDownUnit::all();
        return view('admin.master.breakdown.index', compact('data'));
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
