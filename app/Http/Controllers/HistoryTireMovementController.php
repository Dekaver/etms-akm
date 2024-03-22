<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\HistoryTireMovement;
use App\Models\TireManufacture;
use App\Models\TireMaster;
use App\Models\TireSize;
use App\Models\TirePattern;
use App\Models\TireStatus;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class HistoryTireMovementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $tiresize_id = $request->query("tiresize");
        $tirepattern_id = $request->query("tirepattern");
        $tirestatus_id = $request->query("tirestatus");

        $company = auth()->user()->company;

        $tiresize = TireSize::where('company_id', $company->id)->get();
        $tirepattern = TirePattern::where('company_id', $company->id)->get();
        $tirestatus = TireStatus::all();

        if ($request->ajax()) {
            $data = TireMaster::select("tires.*", "tire_sizes.size", "sites.name as site_name", "tire_statuses.status", "tire_patterns.pattern", "tire_compounds.compound")
                ->leftJoin("sites", "tires.site_id", "=", "sites.id")
                ->leftJoin("tire_statuses", "tires.tire_status_id", "=", "tire_statuses.id")
                ->leftJoin("tire_sizes", "tires.tire_size_id", "=", "tire_sizes.id")
                ->leftJoin("tire_compounds", "tires.tire_compound_id", "=", "tire_compounds.id")
                ->leftJoin("tire_patterns", "tire_sizes.tire_pattern_id", "=", "tire_patterns.id")
                ->where("tires.company_id", $company->id)
                ->has("history_tire_movement");
            if ($tiresize_id) {
                $data = $data->where("tire_size_id", $tiresize_id);
            }
            if ($tirepattern_id) {
                $data = $data->where("tire_sizes.tire_pattern_id", $tirepattern_id);
            }
            if ($tirestatus_id) {
                $data = $data->where("tire_status_id", $tirestatus_id);
            }
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = "
                        <a href='" . route('historytiremovement.tiremovement', $row->id) . "' class='btn btn-sm btn-primary text-white'>MOVEMENT</a>
                        <a href='" . route('historytiremovement.tireinspect', $row->id) . "' class='btn btn-sm btn-warning text-white'>INSPECT</a>
                    ";
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }


        return view("admin.history.historyTire", compact('tiresize', 'tirepattern', 'tirestatus', 'tiresize_id', 'tirepattern_id', 'tirestatus_id'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(HistoryTireMovement $historyTireMovement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HistoryTireMovement $historyTireMovement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HistoryTireMovement $historyTireMovement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HistoryTireMovement $historyTireMovement)
    {
        //
    }

    public function tiremovement(Request $request, TireMaster $tire)
    {
        // dd($tire->history_tire_movement);
        $data = HistoryTireMovement::with(["site", "tire_damage", "driver"])->where("tire", $tire->serial_number);

        if ($request->ajax()) {
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn("site", function ($row) {
                    return $row->site->name;
                })
                ->addColumn("driver", function ($row) {
                    return $row->driver->nama ?? null;
                })
                ->addColumn("damage", function ($row) {
                    return $row->tire_damage->damage ?? null;
                })
                ->make(true);
        }

        return view("admin.history.historyTireMovement", compact("tire"));
    }

    public function tireinspect(Request $request, TireMaster $tire)
    {
        if ($request->ajax()) {
            return DataTables::of($tire->daily_inspect)
                ->addIndexColumn()
                ->addColumn("tire", function ($row) {
                    return $row->tire->serial_number;
                })
                ->addColumn("unit", function ($row) {
                    return $row->unit->unit_number;
                })
                ->addColumn("site", function ($row) {
                    return $row->site->name;
                })
                ->addColumn("tPentil", function ($row) {
                    $a = "<input type='checkbox' " . ($row->t_pentil ? 'checked' : '') . "> ";
                    return $a;
                })
                ->rawColumns(['tPentil'])
                ->make(true);
        }

        return view("admin.history.historyTireInspect", compact("tire"));
    }

    public function tireconsumption(Request $request, TireMaster $tire)
    {
        $year = $request->query('year') ?? Carbon::now()->format("Y");
        $month = $request->query('month') ?? Carbon::now()->format("m");
        $company = auth()->user()->company;
        $tire_sizes = TireSize::select('size')->where('company_id', $company->id)->groupBy('size')->get();
        $manufacturer = TireManufacture::where('company_id', $company->id)->get();
        $type_patterns = TirePattern::select('type_pattern')->where('company_id', $company->id)->groupBy('type_pattern')->get();
        $tire_patterns = TirePattern::select('pattern')->where('company_id', $company->id)->groupBy('pattern')->get();
        $drivers = Driver::where('company_id', $company->id)->get();
        $units = Unit::orderBy('unit_number')->where('company_id', $company->id)->get();

        $grup = $request->query('grup') ?? 'unit';
        $tire_pattern = $request->query('tire_pattern');
        $tire_size = $request->query('tire_size');
        $brand_tire = $request->query('brand_tire');
        $type_pattern = $request->query('type_pattern');
        $tire_size = $request->query('tire_size');
        $unit = $request->query('unit');
        $driver = $request->query('driver');
        if ($grup == 'driver') {
            $query = HistoryTireMovement::select(
                "drivers.nama as unit",
                DB::raw("SUM(CASE WHEN DAYOFMONTH(history_tire_movements.created_at) BETWEEN 1 AND 7 AND status = 'NEW' THEN 1 ELSE 0 END) AS 'new1'"),
                DB::raw("SUM(CASE WHEN DAYOFMONTH(history_tire_movements.created_at) BETWEEN 1 AND 7 AND status = 'SPARE' THEN 1 ELSE 0 END) AS 'spare1'"),
                DB::raw("SUM(CASE WHEN DAYOFMONTH(history_tire_movements.created_at) BETWEEN 1 AND 7 AND status = 'SCRAP' THEN 1 ELSE 0 END) AS 'scrap1'"),
                DB::raw("SUM(CASE WHEN DAYOFMONTH(history_tire_movements.created_at) BETWEEN 8 AND 14 AND status = 'NEW' THEN 1 ELSE 0 END) AS 'new2'"),
                DB::raw("SUM(CASE WHEN DAYOFMONTH(history_tire_movements.created_at) BETWEEN 8 AND 14 AND status = 'SPARE' THEN 1 ELSE 0 END) AS 'spare2'"),
                DB::raw("SUM(CASE WHEN DAYOFMONTH(history_tire_movements.created_at) BETWEEN 8 AND 14 AND status = 'SCRAP' THEN 1 ELSE 0 END) AS 'scrap2'"),
                DB::raw("SUM(CASE WHEN DAYOFMONTH(history_tire_movements.created_at) BETWEEN 15 AND 21 AND status = 'NEW' THEN 1 ELSE 0 END) AS 'new3'"),
                DB::raw("SUM(CASE WHEN DAYOFMONTH(history_tire_movements.created_at) BETWEEN 15 AND 21 AND status = 'SPARE' THEN 1 ELSE 0 END) AS 'spare3'"),
                DB::raw("SUM(CASE WHEN DAYOFMONTH(history_tire_movements.created_at) BETWEEN 15 AND 21 AND status = 'SCRAP' THEN 1 ELSE 0 END) AS 'scrap3'"),
                DB::raw("SUM(CASE WHEN DAYOFMONTH(history_tire_movements.created_at) BETWEEN 22 AND DAY(LAST_DAY(history_tire_movements.created_at)) AND status = 'NEW' THEN 1 ELSE 0 END) AS 'new4'"),
                DB::raw("SUM(CASE WHEN DAYOFMONTH(history_tire_movements.created_at) BETWEEN 22 AND DAY(LAST_DAY(history_tire_movements.created_at)) AND status = 'SPARE' THEN 1 ELSE 0 END) AS 'spare4'"),
                DB::raw("SUM(CASE WHEN DAYOFMONTH(history_tire_movements.created_at) BETWEEN 22 AND DAY(LAST_DAY(history_tire_movements.created_at)) AND status = 'SCRAP' THEN 1 ELSE 0 END) AS 'scrap4'")
            )->leftJoin("drivers","drivers.id","=","history_tire_movements.driver_id");
        } else {
            $query = HistoryTireMovement::select(
                'unit',
                DB::raw("SUM(CASE WHEN DAYOFMONTH(created_at) BETWEEN 1 AND 7 AND status = 'NEW' THEN 1 ELSE 0 END) AS 'new1'"),
                DB::raw("SUM(CASE WHEN DAYOFMONTH(created_at) BETWEEN 1 AND 7 AND status = 'SPARE' THEN 1 ELSE 0 END) AS 'spare1'"),
                DB::raw("SUM(CASE WHEN DAYOFMONTH(created_at) BETWEEN 1 AND 7 AND status = 'SCRAP' THEN 1 ELSE 0 END) AS 'scrap1'"),
                DB::raw("SUM(CASE WHEN DAYOFMONTH(created_at) BETWEEN 8 AND 14 AND status = 'NEW' THEN 1 ELSE 0 END) AS 'new2'"),
                DB::raw("SUM(CASE WHEN DAYOFMONTH(created_at) BETWEEN 8 AND 14 AND status = 'SPARE' THEN 1 ELSE 0 END) AS 'spare2'"),
                DB::raw("SUM(CASE WHEN DAYOFMONTH(created_at) BETWEEN 8 AND 14 AND status = 'SCRAP' THEN 1 ELSE 0 END) AS 'scrap2'"),
                DB::raw("SUM(CASE WHEN DAYOFMONTH(created_at) BETWEEN 15 AND 21 AND status = 'NEW' THEN 1 ELSE 0 END) AS 'new3'"),
                DB::raw("SUM(CASE WHEN DAYOFMONTH(created_at) BETWEEN 15 AND 21 AND status = 'SPARE' THEN 1 ELSE 0 END) AS 'spare3'"),
                DB::raw("SUM(CASE WHEN DAYOFMONTH(created_at) BETWEEN 15 AND 21 AND status = 'SCRAP' THEN 1 ELSE 0 END) AS 'scrap3'"),
                DB::raw("SUM(CASE WHEN DAYOFMONTH(created_at) BETWEEN 22 AND DAY(LAST_DAY(created_at)) AND status = 'NEW' THEN 1 ELSE 0 END) AS 'new4'"),
                DB::raw("SUM(CASE WHEN DAYOFMONTH(created_at) BETWEEN 22 AND DAY(LAST_DAY(created_at)) AND status = 'SPARE' THEN 1 ELSE 0 END) AS 'spare4'"),
                DB::raw("SUM(CASE WHEN DAYOFMONTH(created_at) BETWEEN 22 AND DAY(LAST_DAY(created_at)) AND status = 'SCRAP' THEN 1 ELSE 0 END) AS 'scrap4'")
            );
        }

      
        if ($request->ajax()) {
            if ($grup == 'driver') {
                $query = HistoryTireMovement::select(
                    "drivers.nama as unit",
                    DB::raw("SUM(CASE WHEN DAYOFMONTH(history_tire_movements.created_at) BETWEEN 1 AND 7 AND status = 'NEW' THEN 1 ELSE 0 END) AS 'new1'"),
                    DB::raw("SUM(CASE WHEN DAYOFMONTH(history_tire_movements.created_at) BETWEEN 1 AND 7 AND status = 'SPARE' THEN 1 ELSE 0 END) AS 'spare1'"),
                    DB::raw("SUM(CASE WHEN DAYOFMONTH(history_tire_movements.created_at) BETWEEN 1 AND 7 AND status = 'SCRAP' THEN 1 ELSE 0 END) AS 'scrap1'"),
                    DB::raw("SUM(CASE WHEN DAYOFMONTH(history_tire_movements.created_at) BETWEEN 8 AND 14 AND status = 'NEW' THEN 1 ELSE 0 END) AS 'new2'"),
                    DB::raw("SUM(CASE WHEN DAYOFMONTH(history_tire_movements.created_at) BETWEEN 8 AND 14 AND status = 'SPARE' THEN 1 ELSE 0 END) AS 'spare2'"),
                    DB::raw("SUM(CASE WHEN DAYOFMONTH(history_tire_movements.created_at) BETWEEN 8 AND 14 AND status = 'SCRAP' THEN 1 ELSE 0 END) AS 'scrap2'"),
                    DB::raw("SUM(CASE WHEN DAYOFMONTH(history_tire_movements.created_at) BETWEEN 15 AND 21 AND status = 'NEW' THEN 1 ELSE 0 END) AS 'new3'"),
                    DB::raw("SUM(CASE WHEN DAYOFMONTH(history_tire_movements.created_at) BETWEEN 15 AND 21 AND status = 'SPARE' THEN 1 ELSE 0 END) AS 'spare3'"),
                    DB::raw("SUM(CASE WHEN DAYOFMONTH(history_tire_movements.created_at) BETWEEN 15 AND 21 AND status = 'SCRAP' THEN 1 ELSE 0 END) AS 'scrap3'"),
                    DB::raw("SUM(CASE WHEN DAYOFMONTH(history_tire_movements.created_at) BETWEEN 22 AND DAY(LAST_DAY(history_tire_movements.created_at)) AND status = 'NEW' THEN 1 ELSE 0 END) AS 'new4'"),
                    DB::raw("SUM(CASE WHEN DAYOFMONTH(history_tire_movements.created_at) BETWEEN 22 AND DAY(LAST_DAY(history_tire_movements.created_at)) AND status = 'SPARE' THEN 1 ELSE 0 END) AS 'spare4'"),
                    DB::raw("SUM(CASE WHEN DAYOFMONTH(history_tire_movements.created_at) BETWEEN 22 AND DAY(LAST_DAY(history_tire_movements.created_at)) AND status = 'SCRAP' THEN 1 ELSE 0 END) AS 'scrap4'")
                )->leftJoin("drivers","drivers.id","=","history_tire_movements.driver_id");
            } else {
                $query = HistoryTireMovement::select(
                    'unit',
                    DB::raw("SUM(CASE WHEN DAYOFMONTH(created_at) BETWEEN 1 AND 7 AND status = 'NEW' THEN 1 ELSE 0 END) AS 'new1'"),
                    DB::raw("SUM(CASE WHEN DAYOFMONTH(created_at) BETWEEN 1 AND 7 AND status = 'SPARE' THEN 1 ELSE 0 END) AS 'spare1'"),
                    DB::raw("SUM(CASE WHEN DAYOFMONTH(created_at) BETWEEN 1 AND 7 AND status = 'SCRAP' THEN 1 ELSE 0 END) AS 'scrap1'"),
                    DB::raw("SUM(CASE WHEN DAYOFMONTH(created_at) BETWEEN 8 AND 14 AND status = 'NEW' THEN 1 ELSE 0 END) AS 'new2'"),
                    DB::raw("SUM(CASE WHEN DAYOFMONTH(created_at) BETWEEN 8 AND 14 AND status = 'SPARE' THEN 1 ELSE 0 END) AS 'spare2'"),
                    DB::raw("SUM(CASE WHEN DAYOFMONTH(created_at) BETWEEN 8 AND 14 AND status = 'SCRAP' THEN 1 ELSE 0 END) AS 'scrap2'"),
                    DB::raw("SUM(CASE WHEN DAYOFMONTH(created_at) BETWEEN 15 AND 21 AND status = 'NEW' THEN 1 ELSE 0 END) AS 'new3'"),
                    DB::raw("SUM(CASE WHEN DAYOFMONTH(created_at) BETWEEN 15 AND 21 AND status = 'SPARE' THEN 1 ELSE 0 END) AS 'spare3'"),
                    DB::raw("SUM(CASE WHEN DAYOFMONTH(created_at) BETWEEN 15 AND 21 AND status = 'SCRAP' THEN 1 ELSE 0 END) AS 'scrap3'"),
                    DB::raw("SUM(CASE WHEN DAYOFMONTH(created_at) BETWEEN 22 AND DAY(LAST_DAY(created_at)) AND status = 'NEW' THEN 1 ELSE 0 END) AS 'new4'"),
                    DB::raw("SUM(CASE WHEN DAYOFMONTH(created_at) BETWEEN 22 AND DAY(LAST_DAY(created_at)) AND status = 'SPARE' THEN 1 ELSE 0 END) AS 'spare4'"),
                    DB::raw("SUM(CASE WHEN DAYOFMONTH(created_at) BETWEEN 22 AND DAY(LAST_DAY(created_at)) AND status = 'SCRAP' THEN 1 ELSE 0 END) AS 'scrap4'")
                );
            }

            // dd($query);
            $query = $query->whereHas('tire_number.tire_size', function ($q) use ($brand_tire, $type_pattern, $tire_pattern, $tire_size) {
                if ($tire_size) {
                    $q->where('size', $tire_size);
                }
                $q->whereHas('tire_pattern', function ($q) use ($brand_tire, $type_pattern, $tire_pattern) {
                    if ($type_pattern) {
                        $q->where('type_pattern', $type_pattern);
                    }
                    if ($tire_pattern) {
                        $q->where('pattern', $tire_pattern);
                    }
                    if ($brand_tire) {
                        $q->whereHas('manufacture', function ($q) use ($brand_tire) {
                            $q->where('name', $brand_tire);
                        });
                    }
                });
            });

            if ($driver) {
                $query = $query->where("driver_id", $driver);
            }

            if ($unit) {
                $query = $query->where("unit", $unit);
            }

            if ($grup == 'driver') {
                $queryAkhir = $query->whereYear("drivers.created_at", $year)->whereMonth("drivers.created_at", $month)->where('drivers.company_id', $company->id)->groupBy('drivers.id', 'drivers.nama')->get();
            } else {
                $queryAkhir = $query->whereYear("created_at", $year)->whereMonth("created_at", $month)->where('company_id', $company->id)->groupBy('unit')->get();
            }
            // dd($queryAkhir->get());
            return DataTables::of($queryAkhir)
                ->addIndexColumn()
                ->addColumn("unit", function ($row) {
                    return $row->unit;
                })
                ->addColumn("new1", function ($row) {
                    return $row->new1;
                })
                ->addColumn("spare1", function ($row) {
                    return $row->spare1;
                })
                ->addColumn("scrap1", function ($row) {
                    return $row->scrap1;
                })
                ->addColumn("new2", function ($row) {
                    return $row->new2;
                })
                ->addColumn("spare2", function ($row) {
                    return $row->spare2;
                })
                ->addColumn("scrap2", function ($row) {
                    return $row->scrap2;
                })
                ->addColumn("new3", function ($row) {
                    return $row->new3;
                })
                ->addColumn("spare3", function ($row) {
                    return $row->spare3;
                })
                ->addColumn("scrap3", function ($row) {
                    return $row->scrap3;
                })
                ->addColumn("new4", function ($row) {
                    return $row->new4;
                })
                ->addColumn("spare4", function ($row) {
                    return $row->spare4;
                })
                ->addColumn("scrap4", function ($row) {
                    return $row->scrap4;
                })
                ->addColumn("total", function ($row) {
                    $totalNew = $row->new1 + $row->new2 + $row->new3 + $row->new4;
                    $totalSpare = $row->spare1 + $row->spare2 + $row->spare3 + $row->spare4;
                    $totalScrap = $row->scrap1 + $row->scrap2 + $row->scrap3 + $row->scrap4;
                    return $totalNew + $totalSpare + $totalScrap;
                })
                ->make(true);
        }

        return view("admin.history.historyTireConsumption",  compact('grup', 'unit', 'driver', 'units', 'drivers', 'brand_tire', 'type_pattern', 'tire_sizes', 'tire_size', 'manufacturer', 'type_patterns', 'tire_patterns', 'tire_pattern', 'tire', 'month', 'year'));
    }
}
