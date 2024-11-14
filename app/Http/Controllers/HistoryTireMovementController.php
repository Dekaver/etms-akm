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
                        <a href='" . route('historytiremovement.tire', $row->id) . "' class='btn btn-sm btn-info text-white'>HISTORY</a>
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
        $data = HistoryTireMovement::with(['site', 'tire_damage', 'driver'])
            ->where('tire', $tire->serial_number)
            ->get()
            ->map(function ($item) {
                if (!empty($item->start_date) && !empty($item->end_date)) {
                    $start = Carbon::parse($item->start_date);
                    $end = Carbon::parse($item->end_date);
                    $hours = $end->diffInHours($start);
                    $minutes = $end->diffInMinutes($start) % 60;
                    $item->duration = "{$hours} Hours {$minutes} Minutes";
                } else {
                    $item->duration = "0 Hours 0 Minutes";
                }
                return $item;
            });

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
                ->addColumn("hm_tire", function ($row) {
                    return number_format($row->hm_tire, 0, ',', '.');
                })
                ->addColumn("km_tire", function ($row) {
                    return number_format($row->km_tire, 0, ',', '.');
                })
                ->addColumn("hm_unit", function ($row) {
                    return number_format($row->hm_unit, 0, ',', '.');
                })
                ->addColumn("km_unit", function ($row) {
                    return number_format($row->km_unit, 0, ',', '.');
                })
                ->make(true);
        }
        return view("admin.history.historyTireMovement", compact("tire"));
    }

    public function tireinspect(Request $request, TireMaster $tire)
    {
        if ($request->ajax()) {
            return DataTables::of(TireMaster::select(
                'tires.serial_number',
                'tires.tire_condition',
                'daily_inspects.date',
                'daily_inspect_details.position',
                'daily_inspect_details.lifetime_hm',
                'daily_inspect_details.lifetime_km',
                'daily_inspect_details.rtd',
                'daily_inspect_details.pressure',
                'daily_inspect_details.tube',
                'daily_inspect_details.flap',
                'daily_inspect_details.rim',
                'daily_inspect_details.t_pentil',
                'units.unit_number',
                'sites.name as site_name',
                'daily_inspect_details.remark'
            )
                ->join('tire_sizes', 'tire_sizes.id', '=', 'tires.tire_size_id')
                ->join('sites', 'sites.id', '=', 'tires.site_id')
                ->join('daily_inspect_details', 'daily_inspect_details.tire_id', '=', 'tires.id')
                ->join('daily_inspects', 'daily_inspect_details.daily_inspect_id', '=', 'daily_inspects.id')
                ->join('units', 'units.id', '=', 'daily_inspects.unit_id')
                ->where('daily_inspect_details.is_selected', true)
                ->where('tires.company_id', auth()->user()->company->id)
                ->where('tires.site_id', auth()->user()->site->id)
                ->where('tires.id', $tire->id)
                ->orderBy('daily_inspects.created_at', 'desc')
                ->get())
                ->addIndexColumn()
                ->addColumn("tire", function ($row) {
                    return $row->serial_number;
                })
                ->addColumn("unit", function ($row) {
                    return $row->unit_number;
                })
                ->addColumn("site", function ($row) {
                    return $row->site_name;
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

    public function tireData(Request $request, TireMaster $tire)
    {
        $historyQuery = HistoryTireMovement::select(
            'history_tire_movements.start_date as date',
            'history_tire_movements.tire as tire',
            'history_tire_movements.position',
            'sites.name as site',
            'history_tire_movements.unit as unit',
            'history_tire_movements.hm_tire as lifetime_hm',
            'history_tire_movements.km_tire as lifetime_km',
            'history_tire_movements.rtd',
            \DB::raw('NULL as pressure'),
            \DB::raw('NULL as tube'),
            \DB::raw('NULL as flap'),
            \DB::raw('NULL as rim'),
            \DB::raw('NULL as t_pentil'),
            'history_tire_movements.des as remark'
        )
            ->join('tires', 'history_tire_movements.tire', '=', 'tires.serial_number')
            ->join('sites', 'history_tire_movements.site_id', '=', 'sites.id')
            ->where('history_tire_movements.tire', $tire->serial_number);

        $inspectQuery = TireMaster::select(
            'daily_inspects.date',
            'tires.serial_number as tire',
            'daily_inspect_details.position',
            'sites.name as site',
            'units.unit_number as unit',
            'daily_inspect_details.lifetime_hm',
            'daily_inspect_details.lifetime_km',
            'daily_inspect_details.rtd',
            'daily_inspect_details.pressure',
            'daily_inspect_details.tube',
            'daily_inspect_details.flap',
            'daily_inspect_details.rim',
            'daily_inspect_details.t_pentil',
            'daily_inspect_details.remark'
        )
            ->join('daily_inspect_details', 'daily_inspect_details.tire_id', '=', 'tires.id')
            ->join('daily_inspects', 'daily_inspect_details.daily_inspect_id', '=', 'daily_inspects.id')
            ->join('sites', 'daily_inspects.site_id', '=', 'sites.id')
            ->join('units', 'daily_inspects.unit_id', '=', 'units.id')
            ->where('daily_inspect_details.is_selected', true)
            ->where('tires.id', $tire->id);

        // Gabungkan query
        $data = $historyQuery->union($inspectQuery)->orderBy('date', 'desc')->get();

        if ($request->ajax()) {
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn("tPentil", function ($row) {
                    return $row->t_pentil ? '<input type="checkbox" checked disabled>' : '<input type="checkbox" disabled>';
                })
                ->rawColumns(['tPentil'])
                ->make(true);
        }

        return view("admin.history.historyTireData", compact("tire"));
    }

    public function monthlytireconsumption(Request $request, TireMaster $tire)
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

        if ($request->ajax()) {
            if ($grup == 'driver') {
                $query = HistoryTireMovement::select(
                    "drivers.nama as unit",
                    DB::raw("SUM(CASE WHEN DAYOFMONTH(history_tire_movements.start_date) BETWEEN 1 AND 7 AND status = 'NEW' THEN 1 ELSE 0 END) AS 'new1'"),
                    DB::raw("SUM(CASE WHEN DAYOFMONTH(history_tire_movements.start_date) BETWEEN 1 AND 7 AND status = 'SPARE' THEN 1 ELSE 0 END) AS 'spare1'"),
                    DB::raw("SUM(CASE WHEN DAYOFMONTH(history_tire_movements.start_date) BETWEEN 1 AND 7 AND status = 'SCRAP' THEN 1 ELSE 0 END) AS 'scrap1'"),
                    DB::raw("SUM(CASE WHEN DAYOFMONTH(history_tire_movements.start_date) BETWEEN 8 AND 14 AND status = 'NEW' THEN 1 ELSE 0 END) AS 'new2'"),
                    DB::raw("SUM(CASE WHEN DAYOFMONTH(history_tire_movements.start_date) BETWEEN 8 AND 14 AND status = 'SPARE' THEN 1 ELSE 0 END) AS 'spare2'"),
                    DB::raw("SUM(CASE WHEN DAYOFMONTH(history_tire_movements.start_date) BETWEEN 8 AND 14 AND status = 'SCRAP' THEN 1 ELSE 0 END) AS 'scrap2'"),
                    DB::raw("SUM(CASE WHEN DAYOFMONTH(history_tire_movements.start_date) BETWEEN 15 AND 21 AND status = 'NEW' THEN 1 ELSE 0 END) AS 'new3'"),
                    DB::raw("SUM(CASE WHEN DAYOFMONTH(history_tire_movements.start_date) BETWEEN 15 AND 21 AND status = 'SPARE' THEN 1 ELSE 0 END) AS 'spare3'"),
                    DB::raw("SUM(CASE WHEN DAYOFMONTH(history_tire_movements.start_date) BETWEEN 15 AND 21 AND status = 'SCRAP' THEN 1 ELSE 0 END) AS 'scrap3'"),
                    DB::raw("SUM(CASE WHEN DAYOFMONTH(history_tire_movements.start_date) BETWEEN 22 AND DAY(LAST_DAY(history_tire_movements.start_date)) AND status = 'NEW' THEN 1 ELSE 0 END) AS 'new4'"),
                    DB::raw("SUM(CASE WHEN DAYOFMONTH(history_tire_movements.start_date) BETWEEN 22 AND DAY(LAST_DAY(history_tire_movements.start_date)) AND status = 'SPARE' THEN 1 ELSE 0 END) AS 'spare4'"),
                    DB::raw("SUM(CASE WHEN DAYOFMONTH(history_tire_movements.start_date) BETWEEN 22 AND DAY(LAST_DAY(history_tire_movements.start_date)) AND status = 'SCRAP' THEN 1 ELSE 0 END) AS 'scrap4'"),
                    DB::raw("SUM(CASE WHEN status = 'NEW' THEN price ELSE 0 END) AS 'price'")
                )->leftJoin("drivers", "drivers.id", "=", "history_tire_movements.driver_id");
            } else {
                $query = HistoryTireMovement::select(
                    'unit',
                    DB::raw("SUM(CASE WHEN DAYOFMONTH(start_date) BETWEEN 1 AND 7 AND status = 'NEW' THEN 1 ELSE 0 END) AS 'new1'"),
                    DB::raw("SUM(CASE WHEN DAYOFMONTH(start_date) BETWEEN 1 AND 7 AND status = 'SPARE' THEN 1 ELSE 0 END) AS 'spare1'"),
                    DB::raw("SUM(CASE WHEN DAYOFMONTH(start_date) BETWEEN 1 AND 7 AND status = 'SCRAP' THEN 1 ELSE 0 END) AS 'scrap1'"),
                    DB::raw("SUM(CASE WHEN DAYOFMONTH(start_date) BETWEEN 8 AND 14 AND status = 'NEW' THEN 1 ELSE 0 END) AS 'new2'"),
                    DB::raw("SUM(CASE WHEN DAYOFMONTH(start_date) BETWEEN 8 AND 14 AND status = 'SPARE' THEN 1 ELSE 0 END) AS 'spare2'"),
                    DB::raw("SUM(CASE WHEN DAYOFMONTH(start_date) BETWEEN 8 AND 14 AND status = 'SCRAP' THEN 1 ELSE 0 END) AS 'scrap2'"),
                    DB::raw("SUM(CASE WHEN DAYOFMONTH(start_date) BETWEEN 15 AND 21 AND status = 'NEW' THEN 1 ELSE 0 END) AS 'new3'"),
                    DB::raw("SUM(CASE WHEN DAYOFMONTH(start_date) BETWEEN 15 AND 21 AND status = 'SPARE' THEN 1 ELSE 0 END) AS 'spare3'"),
                    DB::raw("SUM(CASE WHEN DAYOFMONTH(start_date) BETWEEN 15 AND 21 AND status = 'SCRAP' THEN 1 ELSE 0 END) AS 'scrap3'"),
                    DB::raw("SUM(CASE WHEN DAYOFMONTH(start_date) BETWEEN 22 AND DAY(LAST_DAY(start_date)) AND status = 'NEW' THEN 1 ELSE 0 END) AS 'new4'"),
                    DB::raw("SUM(CASE WHEN DAYOFMONTH(start_date) BETWEEN 22 AND DAY(LAST_DAY(start_date)) AND status = 'SPARE' THEN 1 ELSE 0 END) AS 'spare4'"),
                    DB::raw("SUM(CASE WHEN DAYOFMONTH(start_date) BETWEEN 22 AND DAY(LAST_DAY(start_date)) AND status = 'SCRAP' THEN 1 ELSE 0 END) AS 'scrap4'"),
                    DB::raw("SUM(CASE WHEN status = 'NEW' THEN price ELSE 0 END) AS 'price'")
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
                $queryAkhir = $query->whereYear("drivers.created_at", $year)->where('drivers.company_id', $company->id)->groupBy('drivers.id', 'drivers.nama')->get();
            } else {
                $queryAkhir = $query->whereYear("start_date", $year)->whereMonth("start_date", $month)->where('company_id', $company->id)->groupBy('unit')->get();
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
                ->addColumn("totalnew", function ($row) {
                    return $row->new1 + $row->new2 + $row->new3 + $row->new4;
                })
                ->addColumn("totalspare", function ($row) {
                    return $row->spare1 + $row->spare2 + $row->spare3 + $row->spare4;
                })
                ->addColumn("totalscrap", function ($row) {
                    return $row->scrap1 + $row->scrap2 + $row->scrap3 + $row->scrap4;
                })
                ->addColumn("total", function ($row) {
                    $totalNew = $row->new1 + $row->new2 + $row->new3 + $row->new4;
                    $totalSpare = $row->spare1 + $row->spare2 + $row->spare3 + $row->spare4;
                    $totalScrap = $row->scrap1 + $row->scrap2 + $row->scrap3 + $row->scrap4;
                    return $totalNew + $totalSpare;
                })
                ->addColumn("price", function ($row) {
                    return number_format($row->price, 0, ',', '.');
                })
                ->make(true);
        }

        return view("admin.history.historyTireConsumption", compact('grup', 'unit', 'driver', 'units', 'drivers', 'brand_tire', 'type_pattern', 'tire_sizes', 'tire_size', 'manufacturer', 'type_patterns', 'tire_patterns', 'tire_pattern', 'tire', 'month', 'year'));
    }

    public function annualtireconsumption(Request $request, TireMaster $tire)
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

        if ($request->ajax()) {
            if ($grup == 'driver') {
                $query = HistoryTireMovement::select(
                    "drivers.nama as unit",
                    DB::raw("SUM(CASE WHEN MONTH(history_tire_movements.start_date) = 1 AND status = 'NEW' THEN 1 ELSE 0 END) AS 'new1'"),
                    DB::raw("SUM(CASE WHEN MONTH(history_tire_movements.start_date) = 1 AND status = 'SPARE' THEN 1 ELSE 0 END) AS 'spare1'"),
                    DB::raw("SUM(CASE WHEN MONTH(history_tire_movements.start_date) = 1 AND status = 'SCRAP' THEN 1 ELSE 0 END) AS 'scrap1'"),
                    DB::raw("SUM(CASE WHEN MONTH(history_tire_movements.start_date) = 2 AND status = 'NEW' THEN 1 ELSE 0 END) AS 'new2'"),
                    DB::raw("SUM(CASE WHEN MONTH(history_tire_movements.start_date) = 2 AND status = 'SPARE' THEN 1 ELSE 0 END) AS 'spare2'"),
                    DB::raw("SUM(CASE WHEN MONTH(history_tire_movements.start_date) = 2 AND status = 'SCRAP' THEN 1 ELSE 0 END) AS 'scrap2'"),
                    DB::raw("SUM(CASE WHEN MONTH(history_tire_movements.start_date) = 3 AND status = 'NEW' THEN 1 ELSE 0 END) AS 'new3'"),
                    DB::raw("SUM(CASE WHEN MONTH(history_tire_movements.start_date) = 3 AND status = 'SPARE' THEN 1 ELSE 0 END) AS 'spare3'"),
                    DB::raw("SUM(CASE WHEN MONTH(history_tire_movements.start_date) = 3 AND status = 'SCRAP' THEN 1 ELSE 0 END) AS 'scrap3'"),
                    DB::raw("SUM(CASE WHEN MONTH(history_tire_movements.start_date) = 4 AND status = 'NEW' THEN 1 ELSE 0 END) AS 'new4'"),
                    DB::raw("SUM(CASE WHEN MONTH(history_tire_movements.start_date) = 4 AND status = 'SPARE' THEN 1 ELSE 0 END) AS 'spare4'"),
                    DB::raw("SUM(CASE WHEN MONTH(history_tire_movements.start_date) = 4 AND status = 'SCRAP' THEN 1 ELSE 0 END) AS 'scrap4'"),
                    DB::raw("SUM(CASE WHEN MONTH(history_tire_movements.start_date) = 5 AND status = 'NEW' THEN 1 ELSE 0 END) AS 'new5'"),
                    DB::raw("SUM(CASE WHEN MONTH(history_tire_movements.start_date) = 5 AND status = 'SPARE' THEN 1 ELSE 0 END) AS 'spare5'"),
                    DB::raw("SUM(CASE WHEN MONTH(history_tire_movements.start_date) = 5 AND status = 'SCRAP' THEN 1 ELSE 0 END) AS 'scrap5'"),
                    DB::raw("SUM(CASE WHEN MONTH(history_tire_movements.start_date) = 6 AND status = 'NEW' THEN 1 ELSE 0 END) AS 'new6'"),
                    DB::raw("SUM(CASE WHEN MONTH(history_tire_movements.start_date) = 6 AND status = 'SPARE' THEN 1 ELSE 0 END) AS 'spare6'"),
                    DB::raw("SUM(CASE WHEN MONTH(history_tire_movements.start_date) = 6 AND status = 'SCRAP' THEN 1 ELSE 0 END) AS 'scrap6'"),
                    DB::raw("SUM(CASE WHEN MONTH(history_tire_movements.start_date) = 7 AND status = 'NEW' THEN 1 ELSE 0 END) AS 'new7'"),
                    DB::raw("SUM(CASE WHEN MONTH(history_tire_movements.start_date) = 7 AND status = 'SPARE' THEN 1 ELSE 0 END) AS 'spare7'"),
                    DB::raw("SUM(CASE WHEN MONTH(history_tire_movements.start_date) = 7 AND status = 'SCRAP' THEN 1 ELSE 0 END) AS 'scrap7'"),
                    DB::raw("SUM(CASE WHEN MONTH(history_tire_movements.start_date) = 8 AND status = 'NEW' THEN 1 ELSE 0 END) AS 'new8'"),
                    DB::raw("SUM(CASE WHEN MONTH(history_tire_movements.start_date) = 8 AND status = 'SPARE' THEN 1 ELSE 0 END) AS 'spare8'"),
                    DB::raw("SUM(CASE WHEN MONTH(history_tire_movements.start_date) = 8 AND status = 'SCRAP' THEN 1 ELSE 0 END) AS 'scrap8'"),
                    DB::raw("SUM(CASE WHEN MONTH(history_tire_movements.start_date) = 9 AND status = 'NEW' THEN 1 ELSE 0 END) AS 'new9'"),
                    DB::raw("SUM(CASE WHEN MONTH(history_tire_movements.start_date) = 9 AND status = 'SPARE' THEN 1 ELSE 0 END) AS 'spare9'"),
                    DB::raw("SUM(CASE WHEN MONTH(history_tire_movements.start_date) = 9 AND status = 'SCRAP' THEN 1 ELSE 0 END) AS 'scrap9'"),
                    DB::raw("SUM(CASE WHEN MONTH(history_tire_movements.start_date) = 10 AND status = 'NEW' THEN 1 ELSE 0 END) AS 'new10'"),
                    DB::raw("SUM(CASE WHEN MONTH(history_tire_movements.start_date) = 10 AND status = 'SPARE' THEN 1 ELSE 0 END) AS 'spare10'"),
                    DB::raw("SUM(CASE WHEN MONTH(history_tire_movements.start_date) = 10 AND status = 'SCRAP' THEN 1 ELSE 0 END) AS 'scrap10'"),
                    DB::raw("SUM(CASE WHEN MONTH(history_tire_movements.start_date) = 11 AND status = 'NEW' THEN 1 ELSE 0 END) AS 'new11'"),
                    DB::raw("SUM(CASE WHEN MONTH(history_tire_movements.start_date) = 11 AND status = 'SPARE' THEN 1 ELSE 0 END) AS 'spare11'"),
                    DB::raw("SUM(CASE WHEN MONTH(history_tire_movements.start_date) = 11 AND status = 'SCRAP' THEN 1 ELSE 0 END) AS 'scrap11'"),
                    DB::raw("SUM(CASE WHEN MONTH(history_tire_movements.start_date) = 11 AND status = 'NEW' THEN 1 ELSE 0 END) AS 'new11'"),
                    DB::raw("SUM(CASE WHEN MONTH(history_tire_movements.start_date) = 11 AND status = 'SPARE' THEN 1 ELSE 0 END) AS 'spare11'"),
                    DB::raw("SUM(CASE WHEN MONTH(history_tire_movements.start_date) = 11 AND status = 'SCRAP' THEN 1 ELSE 0 END) AS 'scrap11'"),
                    DB::raw("SUM(CASE WHEN MONTH(history_tire_movements.start_date) = 12 AND status = 'NEW' THEN 1 ELSE 0 END) AS 'new12'"),
                    DB::raw("SUM(CASE WHEN MONTH(history_tire_movements.start_date) = 12 AND status = 'SPARE' THEN 1 ELSE 0 END) AS 'spare12'"),
                    DB::raw("SUM(CASE WHEN MONTH(history_tire_movements.start_date) = 12 AND status = 'SCRAP' THEN 1 ELSE 0 END) AS 'scrap12'"),
                    DB::raw("SUM(CASE WHEN status = 'NEW' THEN history_tire_movements.price ELSE 0 END) AS 'price'")
                )
                    ->leftJoin("drivers", "drivers.id", "=", "history_tire_movements.driver_id")
                    ->groupBy("drivers.nama"); // Grupkan hasil berdasarkan nama unit

            } else {
                $query = HistoryTireMovement::select(
                    'unit',
                    DB::raw("SUM(CASE WHEN MONTH(history_tire_movements.start_date) = 1 AND status = 'NEW' THEN 1 ELSE 0 END) AS 'new1'"),
                    DB::raw("SUM(CASE WHEN MONTH(history_tire_movements.start_date) = 1 AND status = 'SPARE' THEN 1 ELSE 0 END) AS 'spare1'"),
                    DB::raw("SUM(CASE WHEN MONTH(history_tire_movements.start_date) = 1 AND status = 'SCRAP' THEN 1 ELSE 0 END) AS 'scrap1'"),
                    DB::raw("SUM(CASE WHEN MONTH(history_tire_movements.start_date) = 2 AND status = 'NEW' THEN 1 ELSE 0 END) AS 'new2'"),
                    DB::raw("SUM(CASE WHEN MONTH(history_tire_movements.start_date) = 2 AND status = 'SPARE' THEN 1 ELSE 0 END) AS 'spare2'"),
                    DB::raw("SUM(CASE WHEN MONTH(history_tire_movements.start_date) = 2 AND status = 'SCRAP' THEN 1 ELSE 0 END) AS 'scrap2'"),
                    DB::raw("SUM(CASE WHEN MONTH(history_tire_movements.start_date) = 3 AND status = 'NEW' THEN 1 ELSE 0 END) AS 'new3'"),
                    DB::raw("SUM(CASE WHEN MONTH(history_tire_movements.start_date) = 3 AND status = 'SPARE' THEN 1 ELSE 0 END) AS 'spare3'"),
                    DB::raw("SUM(CASE WHEN MONTH(history_tire_movements.start_date) = 3 AND status = 'SCRAP' THEN 1 ELSE 0 END) AS 'scrap3'"),
                    DB::raw("SUM(CASE WHEN MONTH(history_tire_movements.start_date) = 4 AND status = 'NEW' THEN 1 ELSE 0 END) AS 'new4'"),
                    DB::raw("SUM(CASE WHEN MONTH(history_tire_movements.start_date) = 4 AND status = 'SPARE' THEN 1 ELSE 0 END) AS 'spare4'"),
                    DB::raw("SUM(CASE WHEN MONTH(history_tire_movements.start_date) = 4 AND status = 'SCRAP' THEN 1 ELSE 0 END) AS 'scrap4'"),
                    DB::raw("SUM(CASE WHEN MONTH(history_tire_movements.start_date) = 5 AND status = 'NEW' THEN 1 ELSE 0 END) AS 'new5'"),
                    DB::raw("SUM(CASE WHEN MONTH(history_tire_movements.start_date) = 5 AND status = 'SPARE' THEN 1 ELSE 0 END) AS 'spare5'"),
                    DB::raw("SUM(CASE WHEN MONTH(history_tire_movements.start_date) = 5 AND status = 'SCRAP' THEN 1 ELSE 0 END) AS 'scrap5'"),
                    DB::raw("SUM(CASE WHEN MONTH(history_tire_movements.start_date) = 6 AND status = 'NEW' THEN 1 ELSE 0 END) AS 'new6'"),
                    DB::raw("SUM(CASE WHEN MONTH(history_tire_movements.start_date) = 6 AND status = 'SPARE' THEN 1 ELSE 0 END) AS 'spare6'"),
                    DB::raw("SUM(CASE WHEN MONTH(history_tire_movements.start_date) = 6 AND status = 'SCRAP' THEN 1 ELSE 0 END) AS 'scrap6'"),
                    DB::raw("SUM(CASE WHEN MONTH(history_tire_movements.start_date) = 7 AND status = 'NEW' THEN 1 ELSE 0 END) AS 'new7'"),
                    DB::raw("SUM(CASE WHEN MONTH(history_tire_movements.start_date) = 7 AND status = 'SPARE' THEN 1 ELSE 0 END) AS 'spare7'"),
                    DB::raw("SUM(CASE WHEN MONTH(history_tire_movements.start_date) = 7 AND status = 'SCRAP' THEN 1 ELSE 0 END) AS 'scrap7'"),
                    DB::raw("SUM(CASE WHEN MONTH(history_tire_movements.start_date) = 8 AND status = 'NEW' THEN 1 ELSE 0 END) AS 'new8'"),
                    DB::raw("SUM(CASE WHEN MONTH(history_tire_movements.start_date) = 8 AND status = 'SPARE' THEN 1 ELSE 0 END) AS 'spare8'"),
                    DB::raw("SUM(CASE WHEN MONTH(history_tire_movements.start_date) = 8 AND status = 'SCRAP' THEN 1 ELSE 0 END) AS 'scrap8'"),
                    DB::raw("SUM(CASE WHEN MONTH(history_tire_movements.start_date) = 9 AND status = 'NEW' THEN 1 ELSE 0 END) AS 'new9'"),
                    DB::raw("SUM(CASE WHEN MONTH(history_tire_movements.start_date) = 9 AND status = 'SPARE' THEN 1 ELSE 0 END) AS 'spare9'"),
                    DB::raw("SUM(CASE WHEN MONTH(history_tire_movements.start_date) = 9 AND status = 'SCRAP' THEN 1 ELSE 0 END) AS 'scrap9'"),
                    DB::raw("SUM(CASE WHEN MONTH(history_tire_movements.start_date) = 10 AND status = 'NEW' THEN 1 ELSE 0 END) AS 'new10'"),
                    DB::raw("SUM(CASE WHEN MONTH(history_tire_movements.start_date) = 10 AND status = 'SPARE' THEN 1 ELSE 0 END) AS 'spare10'"),
                    DB::raw("SUM(CASE WHEN MONTH(history_tire_movements.start_date) = 10 AND status = 'SCRAP' THEN 1 ELSE 0 END) AS 'scrap10'"),
                    DB::raw("SUM(CASE WHEN MONTH(history_tire_movements.start_date) = 11 AND status = 'NEW' THEN 1 ELSE 0 END) AS 'new11'"),
                    DB::raw("SUM(CASE WHEN MONTH(history_tire_movements.start_date) = 11 AND status = 'SPARE' THEN 1 ELSE 0 END) AS 'spare11'"),
                    DB::raw("SUM(CASE WHEN MONTH(history_tire_movements.start_date) = 11 AND status = 'SCRAP' THEN 1 ELSE 0 END) AS 'scrap11'"),
                    DB::raw("SUM(CASE WHEN MONTH(history_tire_movements.start_date) = 11 AND status = 'NEW' THEN 1 ELSE 0 END) AS 'new11'"),
                    DB::raw("SUM(CASE WHEN MONTH(history_tire_movements.start_date) = 11 AND status = 'SPARE' THEN 1 ELSE 0 END) AS 'spare11'"),
                    DB::raw("SUM(CASE WHEN MONTH(history_tire_movements.start_date) = 11 AND status = 'SCRAP' THEN 1 ELSE 0 END) AS 'scrap11'"),
                    DB::raw("SUM(CASE WHEN MONTH(history_tire_movements.start_date) = 12 AND status = 'NEW' THEN 1 ELSE 0 END) AS 'new12'"),
                    DB::raw("SUM(CASE WHEN MONTH(history_tire_movements.start_date) = 12 AND status = 'SPARE' THEN 1 ELSE 0 END) AS 'spare12'"),
                    DB::raw("SUM(CASE WHEN MONTH(history_tire_movements.start_date) = 12 AND status = 'SCRAP' THEN 1 ELSE 0 END) AS 'scrap12'"),
                    DB::raw("SUM(CASE WHEN status = 'NEW' THEN history_tire_movements.price ELSE 0 END) AS 'price'")
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
                $queryAkhir = $query->whereYear("drivers.created_at", $year)->where('drivers.company_id', $company->id)->groupBy('drivers.id', 'drivers.nama')->get();
            } else {
                $queryAkhir = $query->whereYear("created_at", $year)->where('company_id', $company->id)->groupBy('unit')->get();
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
                ->addColumn("new5", function ($row) {
                    return $row->new5;
                })
                ->addColumn("spare5", function ($row) {
                    return $row->spare5;
                })
                ->addColumn("scrap5", function ($row) {
                    return $row->scrap5;
                })
                ->addColumn("new6", function ($row) {
                    return $row->new6;
                })
                ->addColumn("spare6", function ($row) {
                    return $row->spare6;
                })
                ->addColumn("scrap6", function ($row) {
                    return $row->scrap6;
                })
                ->addColumn("new7", function ($row) {
                    return $row->new7;
                })
                ->addColumn("spare7", function ($row) {
                    return $row->spare7;
                })
                ->addColumn("scrap7", function ($row) {
                    return $row->scrap7;
                })
                ->addColumn("new8", function ($row) {
                    return $row->new8;
                })
                ->addColumn("spare8", function ($row) {
                    return $row->spare8;
                })
                ->addColumn("scrap8", function ($row) {
                    return $row->scrap8;
                })
                ->addColumn("new9", function ($row) {
                    return $row->new9;
                })
                ->addColumn("spare9", function ($row) {
                    return $row->spare9;
                })
                ->addColumn("scrap9", function ($row) {
                    return $row->scrap9;
                })
                ->addColumn("new10", function ($row) {
                    return $row->new10;
                })
                ->addColumn("spare10", function ($row) {
                    return $row->spare10;
                })
                ->addColumn("scrap10", function ($row) {
                    return $row->scrap10;
                })
                ->addColumn("new11", function ($row) {
                    return $row->new11;
                })
                ->addColumn("spare11", function ($row) {
                    return $row->spare11;
                })
                ->addColumn("scrap11", function ($row) {
                    return $row->scrap11;
                })
                ->addColumn("new12", function ($row) {
                    return $row->new12;
                })
                ->addColumn("spare12", function ($row) {
                    return $row->spare12;
                })
                ->addColumn("scrap12", function ($row) {
                    return $row->scrap12;
                })
                ->addColumn("totalnew", function ($row) {
                    return $row->new1 + $row->new2 + $row->new3 + $row->new4 + $row->new5 + $row->new6 + $row->new7 + $row->new8 + $row->new9 + $row->new10 + $row->new11 + $row->new12;
                })
                ->addColumn("totalspare", function ($row) {
                    return $row->spare1 + $row->spare2 + $row->spare3 + $row->spare4 + $row->spare5 + $row->spare6 + $row->spare7 + $row->spare8 + $row->spare9 + $row->spare10 + $row->spare11 + $row->spare12;
                })
                ->addColumn("totalscrap", function ($row) {
                    return $row->scrap1 + $row->scrap2 + $row->scrap3 + $row->scrap4 + $row->scrap5 + $row->scrap6 + $row->scrap7 + $row->scrap8 + $row->scrap9 + $row->scrap10 + $row->scrap11 + $row->scrap12;
                })
                ->addColumn("total", function ($row) {
                    $totalNew = $row->new1 + $row->new2 + $row->new3 + $row->new4 + $row->new5 + $row->new6 + $row->new7 + $row->new8 + $row->new9 + $row->new10 + $row->new11 + $row->new12;
                    $totalSpare = $row->spare1 + $row->spare2 + $row->spare3 + $row->spare4 + $row->spare5 + $row->spare6 + $row->spare7 + $row->spare8 + $row->spare9 + $row->spare10 + $row->spare11 + $row->spare12;
                    $totalScrap = $row->scrap1 + $row->scrap2 + $row->scrap3 + $row->scrap4 + $row->scrap5 + $row->scrap6 + $row->scrap7 + $row->scrap8 + $row->scrap9 + $row->scrap10 + $row->scrap11 + $row->scrap12;
                    return $totalNew + $totalSpare;
                })
                ->addColumn("price", function ($row) {
                    return number_format($row->price, 0, ',', '.');
                })
                ->make(true);
        }

        return view("admin.history.historyTireConsumptionAnnual", compact('grup', 'unit', 'driver', 'units', 'drivers', 'brand_tire', 'type_pattern', 'tire_sizes', 'tire_size', 'manufacturer', 'type_patterns', 'tire_patterns', 'tire_pattern', 'tire', 'month', 'year'));
    }
}
