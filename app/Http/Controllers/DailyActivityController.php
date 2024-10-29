<?php

namespace App\Http\Controllers;

use App\Models\AktivitasPekerjaan;
use App\Models\AreaPekerjaan;
use App\Models\Company;
use App\Models\DailyActivity;
use App\Models\DailyActivityGambar;
use App\Models\Site;
use App\Models\Teknisi;
use App\Models\Unit;
use App\Models\UnitModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class DailyActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $company = auth()->user()->company;
        $site = Site::where("company_id", $company->id)->get();
        $areaPekerjaan = AreaPekerjaan::where("company_id", $company->id)->get();
        $teknisi = Teknisi::where("company_id", $company->id)->get();
        $aktivitasPekerjaan = AktivitasPekerjaan::where("company_id", $company->id)->get();
        $unitModel = UnitModel::where("company_id", $company->id)->get();
        $unit = Unit::where("company_id", $company->id)->get();

        if ($request->ajax()) {
            $data = DailyActivity::with(["teknisi", "aktivitas_pekerjaan", "unit_model", "unit", "area_pekerjaan", "site"])->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('tanggal', function ($row) {
                    return $row->tanggal;
                })
                ->addColumn('site', function ($row) {
                    return $row->site->name;
                })
                ->addColumn('area', function ($row) {
                    return $row->area_pekerjaan ? $row->area_pekerjaan->nama : 'N/A';
                })
                ->addColumn('teknisi', function ($row) {
                    return $row->teknisi ? $row->teknisi->nama : 'N/A';
                })
                ->addColumn('aktivitas', function ($row) {
                    return $row->aktivitas_pekerjaan ? $row->aktivitas_pekerjaan->nama : 'N/A';
                })
                ->addColumn('unit_model', function ($row) {
                    return $row->unit_model ? $row->unit_model->model : 'N/A';
                })
                ->addColumn('unit', function ($row) {
                    return $row->unit ? $row->unit->unit_number : 'N/A';
                })
                ->addColumn('start_date', function ($row) {
                    return $row->start_date;
                })
                ->addColumn('end_date', function ($row) {
                    return $row->end_date;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = "<a class='me-3 text-warning' href='#'
                                    data-bs-target='#form-modal' data-bs-toggle='modal' data-id='$row->id'>
                                    <img src='assets/img/icons/edit.svg' alt='img'>
                                </a>
                                <a class='confirm-text' href='javascript:void(0);' data-bs-toggle='modal'
                                    data-bs-target='#deleteModal' data-id='$row->id'
                                    data-action='" . route('daily-activity.destroy', $row->id) . "'
                                    data-message='$row->nama'>
                                    <img src='assets/img/icons/delete.svg' alt='img'>
                                </a>";
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view("admin.report.daily-activity", compact("areaPekerjaan", "site", "teknisi", "aktivitasPekerjaan", "unitModel", "unit"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "tanggal" => "required|date",
            "photos.*" => "image|mimes:jpeg,png,jpg,gif|max:2048"
        ]);

        // Debugging untuk memastikan company_id
        $companyId = auth()->user()->company_id;

        $dailyActivity = DailyActivity::create([
            "tanggal" => $request->tanggal,
            "site_id" => $request->site_id,
            "teknisi_id" => $request->teknisi_id,
            "aktivitas_pekerjaan_id" => $request->aktivitas_pekerjaan_id,
            "unit_model_id" => $request->unit_model_id,
            "unit_id" => $request->unit_id,
            "start_date" => $request->start_date,
            "end_date" => $request->end_date,
            "area_pekerjaan_id" => $request->area_pekerjaan_id,
            "remark" => $request->remark,
            "company_id" => $companyId,
        ]);

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('photos', 'public'); // Simpan di storage 'public/photos'

                // Simpan path gambar di tabel daily_activity_gambars
                DailyActivityGambar::create([
                    'daily_activity_id' => $dailyActivity->id,
                    'gambar' => $path
                ]);
            }
        }

        return redirect()->back()->with("success", "Daily Activity Created Successfully");
    }

    /**
     * Display the specified resource.
     */
    public function show(DailyActivity $dailyActivity)
    {
        return view("admin.report.show", compact("dailyActivity"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DailyActivity $dailyActivity)
    {
        $dailyActivity->load('gambars');

        return response()->json($dailyActivity);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DailyActivity $dailyActivity)
    {
        $request->validate([
            "tanggal" => "required|date",
            "photos.*" => "image|mimes:jpeg,png,jpg,gif|max:2048"
        ]);

        $dailyActivity->update([
            "tanggal" => $request->tanggal,
            "site_id" => $request->site_id,
            "teknisi_id" => $request->teknisi_id,
            "aktivitas_pekerjaan_id" => $request->aktivitas_pekerjaan_id,
            "unit_model_id" => $request->unit_model_id,
            "unit_id" => $request->unit_id,
            "start_date" => $request->start_date,
            "end_date" => $request->end_date,
            "area_pekerjaan_id" => $request->area_pekerjaan_id,
            "remark" => $request->remark,
        ]);

        // Hapus gambar lama dari storage dan database
        foreach ($dailyActivity->gambars as $gambar) {
            if (Storage::disk('public')->exists($gambar->gambar)) {
                Storage::disk('public')->delete($gambar->gambar); // Hapus dari storage
            }
            $gambar->delete(); // Hapus dari database
        }

        // Menyimpan gambar baru
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('photos', 'public'); // Menyimpan foto di dalam folder "photos" di disk "public"
                // Simpan path gambar di tabel daily_activity_gambars
                DailyActivityGambar::create([
                    'daily_activity_id' => $dailyActivity->id,
                    'gambar' => $path
                ]);
            }
        }
        return redirect()->back()->with("success", "Daily Activity Updated Successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DailyActivity $dailyActivity)
    {
        $dailyActivity->delete();

        return redirect()->back()->with("success", "Daily Activity Deleted Successfully");
    }
}
