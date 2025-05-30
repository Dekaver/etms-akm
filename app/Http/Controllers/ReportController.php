<?php

namespace App\Http\Controllers;

use App\Models\DailyActivity;
use App\Models\Driver;
use App\Models\HistoryTireMovement;
use App\Models\Site;
use App\Models\TireManufacture;
use App\Models\TireMaster;
use App\Models\TirePattern;
use App\Models\TireRunning;
use App\Models\TireSize;
use App\Models\TireStatus;
use App\Models\TireTargetKm;
use App\Models\Unit;
use App\Models\UnitModel;
use App\Models\UnitStatus;
use Auth;
use Carbon\Carbon;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class ReportController extends Controller
{
    public function statusTireCount(Request $request)
    {
        $tire_manufacture = $request->query("tire_manufacture");
        $tire_size = $request->query("tire_size");
        $tire_pattern = $request->query("tire_pattern");
        $type_pattern = $request->query("type_pattern");


        $company = auth()->user()->company_id;
        $tirepattern = TirePattern::with("manufacture")->where('company_id', $company)->get();
        $tire_patterns = TirePattern::select("pattern")->where('company_id', $company)->groupBy("pattern")->get();
        $tire_sizes = TireSize::select("size")->where('company_id', $company)->groupBy("size")->get();
        $tire_manufactures = TireManufacture::where('company_id', $company)->get();

        if ($request->ajax()) {
            $data = TireSize::where('company_id', $company);
            if ($tire_manufacture || $tire_pattern || $type_pattern) {
                $data = $data->whereHas("tire_pattern", function ($q) use ($tire_manufacture, $tire_pattern, $type_pattern) {
                    if ($tire_manufacture) {
                        $q->where("tire_manufacture_id", $tire_manufacture);
                    }
                    if ($tire_pattern) {
                        $q->where("pattern", $tire_pattern);
                    }
                    if ($type_pattern) {
                        $q->where("type_pattern", $type_pattern);
                    }
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
                ->addColumn('scrap', function ($row) {
                    return number_format($row->scrap_count, 0, ',', '.');
                })
                ->addColumn('spare', function ($row) {
                    return number_format($row->spare_count, 0, ',', '.');
                })
                ->addColumn('running', function ($row) {
                    return number_format($row->running_count, 0, ',', '.');
                })
                ->addColumn('new', function ($row) {
                    return number_format($row->new_count, 0, ',', '.');
                })
                ->addColumn('repair', function ($row) {
                    return number_format($row->repair_count, 0, ',', '.');
                })
                ->addColumn('inventory', function ($row) {
                    return number_format($row->new_count + $row->spare_count, 0, ',', '.');
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
                ->make(true);
        }
        return view("admin.report.tireSize", compact('tirepattern', 'tire_manufactures', 'tire_sizes', 'tire_patterns', 'tire_pattern', 'tire_size', 'tire_manufacture', 'type_pattern'));
    }

    public function scrapTireCount(Request $request)
    {
        $tire_manufacture = $request->query("tire_manufacture");
        $tire_size = $request->query("tire_size");
        $tire_pattern = $request->query("tire_pattern");
        $type_pattern = $request->query("type_pattern");


        $company = auth()->user()->company_id;
        $tirepattern = TirePattern::with("manufacture")->where('company_id', $company)->get();
        $tire_patterns = TirePattern::select("pattern")->where('company_id', $company)->groupBy("pattern")->get();
        $tire_sizes = TireSize::select("size")->where('company_id', $company)->groupBy("size")->get();
        $tire_manufactures = TireManufacture::where('company_id', $company)->get();

        if ($request->ajax()) {
            $data = TireMaster::select(
                "tires.*",
                "serial_number",
                "size",
                "pattern",
                "type_pattern",
                "tire_manufactures.name as manufacture",
                'damage',
            )
                ->join('tire_sizes', 'tire_sizes.id', '=', 'tires.tire_size_id')
                ->join('tire_patterns', 'tire_patterns.id', '=', 'tire_sizes.tire_pattern_id')
                ->join('tire_manufactures', 'tire_manufactures.id', '=', 'tire_patterns.tire_manufacture_id')
                ->join('tire_damages', 'tire_damages.id', '=', 'tires.tire_damage_id')
                ->where('tires.company_id', $company)
                ->where("tire_status_id", 5); // id 5 SCRAP
            if ($tire_manufacture || $tire_pattern || $type_pattern) {
                $data = $data->whereHas("tire_pattern", function ($q) use ($tire_manufacture, $tire_pattern, $type_pattern) {
                    if ($tire_manufacture) {
                        $q->where("tire_manufacture_id", $tire_manufacture);
                    }
                    if ($tire_pattern) {
                        $q->where("pattern", $tire_pattern);
                    }
                    if ($type_pattern) {
                        $q->where("type_pattern", $type_pattern);
                    }
                });
            }
            if ($tire_size) {
                $data = $data->where("size", $tire_size);
            }
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('pattern', function ($row) {
                    return "$row->type_pattern - $row->pattern";
                })
                ->addColumn('damage', function ($row) {
                    return "$row->damage";
                })
                ->addColumn('lifetime_hm', function ($row) {
                    return number_format($row->lifetime_hm, 0, ',', '.');
                })
                ->addColumn('lifetime_km', function ($row) {
                    return number_format($row->lifetime_km, 0, ',', '.');
                })

                ->make(true);
        }
        return view("admin.report.tire-scrap", compact('tirepattern', 'tire_manufactures', 'tire_sizes', 'tire_patterns', 'tire_pattern', 'tire_size', 'tire_manufacture', 'type_pattern'));
    }

    public function tireRunning(Request $request)
    {
        $tire_manufacture = $request->query("tire_manufacture");
        $tire_size = $request->query("tire_size");
        $tire_pattern = $request->query("tire_pattern");
        $type_pattern = $request->query("type_pattern");
        $tire_status = $request->query("tire_status");


        $company = auth()->user()->company_id;
        $tirepattern = TirePattern::with("manufacture")->where('company_id', $company)->get();
        $tire_patterns = TirePattern::select("pattern")->where('company_id', $company)->groupBy("pattern")->get();
        $tire_sizes = TireSize::select("size")->where('company_id', $company)->groupBy("size")->get();
        $tire_statuses = TireStatus::select("status")->get();
        $tire_manufactures = TireManufacture::where('company_id', $company)->get();

        if ($request->ajax()) {
            // Mulai query
            $data = TireRunning::join('units', 'tire_runnings.unit_id', '=', 'units.id')
                ->join('sites', 'tire_runnings.site_id', '=', 'sites.id')
                ->join('tires', 'tire_runnings.tire_id', '=', 'tires.id')
                ->join('tire_sizes', 'tires.tire_size_id', '=', 'tire_sizes.id')
                ->join('tire_patterns', 'tire_sizes.tire_pattern_id', '=', 'tire_patterns.id')
                ->join('tire_statuses', 'tires.tire_status_id', '=', 'tire_statuses.id')
                ->leftJoin('tire_manufactures', 'tire_patterns.tire_manufacture_id', '=', 'tire_manufactures.id')
                ->leftJoin('tire_damages', 'tires.tire_damage_id', '=', 'tire_damages.id')
                ->select(
                    'tire_runnings.*',
                    'tires.serial_number',
                    'tires.lifetime_km',
                    'tires.lifetime_hm',
                    'tires.rtd',
                    'tire_sizes.otd',
                    'tire_sizes.size as tire_size',
                    'tire_patterns.pattern',
                    'tire_patterns.type_pattern',
                    'tire_statuses.status',
                    'sites.name as site_name',
                    'units.unit_number',
                    'tire_manufactures.name as manufacture',
                    'tire_damages.damage',
                    DB::raw('(tire_sizes.otd - tires.rtd) AS tur'),
                    DB::raw('CONCAT(tire_patterns.type_pattern, "-", tire_manufactures.name, "-", tire_patterns.pattern) AS manufacture_pattern'),
                )
                ->where('tire_runnings.company_id', Auth::user()->company_id);
            // $data = $data = TireRunning::with(["unit", "site", "tire_movement", "tire.tire_size.tire_pattern.manufacture", "tire.tire_status"])->where("company_id", Auth::user()->company_id);
            if ($tire_manufacture || $tire_pattern || $type_pattern) {
                $data = $data->whereHas("tire.tire_size.tire_pattern", function ($q) use ($tire_manufacture, $tire_pattern, $type_pattern) {
                    if ($tire_manufacture) {
                        $q->where("tire_manufacture_id", $tire_manufacture);
                    }
                    if ($tire_pattern) {
                        $q->where("pattern", $tire_pattern);
                    }
                    if ($type_pattern) {
                        $q->where("type_pattern", $type_pattern);
                    }
                });
            }
            if ($tire_size) {
                $data = $data->whereHas("tire.tire_size", function ($q) use ($tire_size) {
                    $q->where("size", $tire_size);
                });
            }
            if ($tire_status) {
                $data = $data->whereHas("tire.tire_status", function ($q) use ($tire_status) {
                    $q->where("status", $tire_status);
                });
            }
            $data = $data->orderBy("unit_id", "asc")->orderBy("position", "asc");

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('pattern', function ($row) {
                    return $row->pattern;
                })
                ->addColumn('serial_number', function ($row) {
                    return $row->serial_number;
                })
                ->addColumn('status', function ($row) {
                    return $row->status;
                })
                ->addColumn('site_name', function ($row) {
                    return $row->site_name;
                })
                ->addColumn('unit_number', function ($row) {
                    return $row->unit_number;
                })
                ->addColumn('lifetime_hm', function ($row) {
                    return number_format($row->lifetime_hm, 0, ',', '.');
                })
                ->addColumn('lifetime_km', function ($row) {
                    return number_format($row->lifetime_km, 0, ',', '.');
                })
                ->addColumn('rtd', function ($row) {
                    return number_format($row->rtd, 2, '.', ',');
                })
                ->addColumn('manufacture', function ($row) {
                    return $row->manufacture;
                })
                ->addColumn('manufacture_pattern', function ($row) {
                    return $row->manufacture_pattern;
                })
                ->addColumn('type', function ($row) {
                    return $row->type_pattern;
                })
                ->addColumn('damage', function ($row) {
                    return $row->damage;
                })
                ->addColumn('km_per_mm', function ($row) {
                    if (isset($row->otd) && isset($row->rtd)) {
                        $rtd = (int) $row->otd - (int) $row->rtd;
                        if ($rtd === 0) {
                            return null; // Atau return nilai default yang sesuai
                        }
                        return number_format((int) $row->lifetime_km / ($rtd), 2, ',', '.');
                    }
                    return null; // Atau nilai default jika relasi tidak lengkap
                })
                ->addColumn('tur', function ($row) {
                    return number_format($row->tur, 2, '.', ',');
                })
                ->make(true);
        }
        return view("admin.report.tire-running", compact('tirepattern', 'tire_manufactures', 'tire_sizes', 'tire_patterns', 'tire_pattern', 'tire_size', 'tire_manufacture', 'type_pattern', 'tire_statuses', 'tire_status'));
    }

    public function tireInventory(Request $request)
    {
        $tire_manufacture = $request->query("tire_manufacture");
        $tire_size = $request->query("tire_size");
        $tire_pattern = $request->query("tire_pattern");
        $type_pattern = $request->query("type_pattern");
        $tire_status = $request->query("tire_status");


        $company = auth()->user()->company_id;
        $tirepattern = TirePattern::with("manufacture")->where('company_id', $company)->get();
        $tire_patterns = TirePattern::select("pattern")->where('company_id', $company)->groupBy("pattern")->get();
        $tire_sizes = TireSize::select("size")->where('company_id', $company)->groupBy("size")->get();
        $tire_statuses = TireStatus::select("status")->get();
        $tire_manufactures = TireManufacture::where('company_id', $company)->get();

        if (!$request->ajax()) {
            $data = $data = TireMaster::with(["site", "tire_size.tire_pattern.manufacture", "tire_status"])->where("company_id", Auth::user()->company_id);
            if ($tire_manufacture || $tire_pattern || $type_pattern) {
                $data = $data->whereHas("tire_size.tire_pattern", function ($q) use ($tire_manufacture, $tire_pattern, $type_pattern) {
                    if ($tire_manufacture) {
                        $q->where("tire_manufacture_id", $tire_manufacture);
                    }
                    if ($tire_pattern) {
                        $q->where("pattern", $tire_pattern);
                    }
                    if ($type_pattern) {
                        $q->where("type_pattern", $type_pattern);
                    }
                });
            }
            if ($tire_size) {
                $data = $data->whereHas("tire_size", function ($q) use ($tire_size) {
                    $q->where("size", $tire_size);
                });
            }
            if ($tire_status) {
                $data = $data->whereHas("tire_status", function ($q) use ($tire_status) {
                    $q->where("status", $tire_status);
                });
            }
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('pattern', function ($row) {
                    return $row->tire_size->tire_pattern->pattern;
                })
                ->addColumn('serial_number', function ($row) {
                    return $row->serial_number;
                })
                ->addColumn('status', function ($row) {
                    return $row->tire_status->status;
                })
                ->addColumn('site_name', function ($row) {
                    return $row->site->name;
                })
                ->addColumn('lifetime_hm', function ($row) {
                    return $row->lifetime_hm;
                })
                ->addColumn('lifetime_km', function ($row) {
                    return $row->lifetime_km;
                })
                ->addColumn('rtd', function ($row) {
                    return $row->rtd;
                })
                ->addColumn('manufacture', function ($row) {
                    return $row->tire_size->tire_pattern->manufacture->name;
                })
                ->addColumn('manufacture_pattern', function ($row) {
                    return "{$row->tire_size->tire_pattern->type_pattern}-{$row->tire_size->tire_pattern->manufacture->name}-{$row->tire_size->tire_pattern->pattern}";
                })
                ->addColumn('type', function ($row) {
                    return $row->tire_size->tire_pattern->type_pattern;
                })
                ->addColumn('damage', function ($row) {
                    return $row->tire_damage?->damage;
                })
                ->make(true);
        }
        return view("admin.report.tire-running", compact('tirepattern', 'tire_manufactures', 'tire_sizes', 'tire_patterns', 'tire_pattern', 'tire_size', 'tire_manufacture', 'type_pattern', 'tire_statuses', 'tire_status'));
    }

    public function tireActivity(Request $request)
    {
        $current_year = date('Y');
        $date_range1 = range($current_year, $current_year + 3);
        $date_range2 = range($current_year, $current_year - 3);
        $date_range = array_merge($date_range1, $date_range2);
        $filter["date_range"] = array_unique($date_range);
        asort($filter["date_range"]);
        $filter["tahun"] = $request->query('tahun');
        if (Gate::any(['isSuperAdmin', 'isViewer', 'isManager'])) {
            $filter["site_name"] = $request->query('site');
        } else {
            $filter["site_name"] = $request->query('site') ?? auth()->user()->site->site_name;
        }
        $filter["model_type"] = $request->query('model_type');
        $filter["brand_tire"] = $request->query('brand_tire');
        $filter["type_pattern"] = $request->query('type_pattern');
        $filter["tire_size"] = $request->query('tire_size');
        $filter["month"] = $request->query('month') ?? Carbon::now()->format("m");
        $filter["week"] = $request->query('week') ?? Carbon::now()->weekOfYear;

        $filter["tire_pattern"] = $request->query('tire_pattern');
        $filter["tire_patterns"] = TirePattern::select('pattern')->groupBy('pattern')->get();
        $filter["site"] = Site::where("company_id", auth()->user()->company->id)->get();
        $filter["tire_sizes"] = TireSize::select('size')->groupBy('size')->get();
        $filter["type"] = UnitModel::select("type")->groupby('type')->get();
        $filter["manufacturer"] = TireManufacture::where('company_id', auth()->user()->company_id)->get();
        $filter["type_patterns"] = TirePattern::select('type_pattern')->where('company_id', auth()->user()->company_id)->groupBy('type_pattern')->get();

        // STOK
        $stok = TireMaster::select("tire_statuses.status")->selectRaw('COUNT(tire_statuses.status) as total')
            ->join('tire_statuses', 'tire_statuses.id', 'tires.tire_status_id')
            ->where("is_repairing", false)
            ->where("company_id", auth()->user()->company->id)
            ->whereNotIn("tires.id", DB::table('tire_runnings')->select("tire_id")->where("company_id", auth()->user()->company_id));

        $stok = $stok->whereHas('tire_size', function ($q) use ($filter) {
            $q->whereHas('tire_pattern', function ($q) use ($filter) {
                if ($filter["type_pattern"]) {
                    $q->where('type_pattern', $filter["type_pattern"]);
                }
                if ($filter["tire_pattern"]) {
                    $q->where('pattern', $filter["tire_pattern"]);
                }
                if ($filter["brand_tire"]) {
                    $q->whereHas('manufacture', function ($q) use ($filter) {
                        $q->where('name', $filter["brand_tire"]);
                    });
                }
                if ($filter["tire_size"]) {
                    $q->where('size', $filter["tire_size"]);
                }
            });
        });

        $stok = $stok->groupBy('tire_statuses.status')->get();

        $returning["stok_new"] = $stok->where("status", "NEW")->pluck('total')->first() ?? 0;
        $returning["stok_spare"] = $stok->where("status", "SPARE")->pluck('total')->first() ?? 0;
        $returning["stok_repair"] = $stok->where("status", "REPAIR")->pluck('total')->first() ?? 0;
        $returning["scrap"] = $stok->where("status", "SCRAP")->pluck('total')->first() ?? 0;

        // RUNNING
        $running = TireMaster::select('tire_statuses.status')->selectRaw('COUNT(tire_statuses.status) as total')
            ->join('tire_statuses', 'tire_statuses.id', 'tires.tire_status_id')
            ->where("company_id", auth()->user()->company->id)
            ->whereIn("tires.id", DB::table('tire_runnings')->select("tire_id")->where("company_id", auth()->user()->company_id));

        $running = $running->whereHas('tire_size', function ($q) use ($filter) {
            $q->whereHas('tire_pattern', function ($q) use ($filter) {
                if ($filter["type_pattern"]) {
                    $q->where('type_pattern', $filter["type_pattern"]);
                }
                if ($filter["tire_pattern"]) {
                    $q->where('pattern', $filter["tire_pattern"]);
                }
                if ($filter["brand_tire"]) {
                    $q->whereHas('manufacture', function ($q) use ($filter) {
                        $q->where('name', $filter["brand_tire"]);
                    });
                }
                if ($filter["tire_size"]) {
                    $q->where('size', $filter["tire_size"]);
                }
            });
        });
        $running = $running->groupBy('tire_statuses.status')->get();


        $returning["install_new"] = $running->where("status", "NEW")->pluck('total')->first() ?? 0;
        $returning["install_spare"] = $running->where("status", "SPARE")->pluck('total')->first() ?? 0;
        $returning["install_repair"] = $running->where("status", "REPAIR")->pluck('total')->first() ?? 0;

        // Scrap Tire
        // $returning["scrap"] = TireMaster::where("company_id", auth()->user()->company->id)->whereHas("tire_status", function ($query) {
        //     $query->where("status", "SCRAP");
        // })->count();

        // REPAIRING Tire
        $returning["repairing"] = TireMaster::where("company_id", auth()->user()->company->id)->where('is_repairing', true)->count();


        $returning["schedule"] = HistoryTireMovement::where("status_schedule", 'Schedule')->where('company_id', auth()->user()->company->id)->count();

        $returning["unschedule"] = HistoryTireMovement::where("status_schedule", 'Unschedule')->where('company_id', auth()->user()->company->id)->count();

        $tire_running = TireMaster::where("company_id", auth()->user()->company->id)
            ->whereIn("id", DB::table('tire_runnings')->select("tire_id")->where("company_id", auth()->user()->company_id))->get();
        $days["running_days"] = [
            "day1" => 0,
            "day2" => 0,
            "day3" => 0,
            "day4" => 0,
        ];
        foreach ($tire_running as $key => $tire) {
            switch ($tire) {
                case $tire->count_day <= 7 && $tire->count_day > 0:
                    $days["running_days"]["day1"] += 1;
                    break;

                case $tire->count_day <= 30 && $tire->count_day > 7:
                    $days["running_days"]["day2"] += 1;
                    break;

                case $tire->count_day <= 60 && $tire->count_day > 30:
                    $days["running_days"]["day3"] += 1;
                    break;

                case $tire->count_day > 60:
                    $days["running_days"]["day3"] += 1;
                    break;

                default:
                    break;
            }
        }

        $tire_stok = TireMaster::where("company_id", auth()->user()->company->id)
            ->whereNotIn("id", DB::table('tire_runnings')->select("tire_id")->where("company_id", auth()->user()->company_id))->get();

        $days["stok_days"] = [
            "day1" => 0,
            "day2" => 0,
            "day3" => 0,
            "day4" => 0,
        ];
        foreach ($tire_stok as $key => $tire) {
            switch ($tire) {
                case $tire->count_day <= 7 && $tire->count_day > 0:
                    $days["stok_days"]["day1"] += 1;
                    break;

                case $tire->count_day <= 30 && $tire->count_day > 7:
                    $days["stok_days"]["day2"] += 1;
                    break;

                case $tire->count_day <= 60 && $tire->count_day > 30:
                    $days["stok_days"]["day3"] += 1;
                    break;

                case $tire->count_day > 60:
                    $days["stok_days"]["day3"] += 1;
                    break;

                default:
                    break;
            }
        }


        return view("admin.report.activity", [...$returning, ...$filter, ...$days]);
    }


    public function tireTargetKm(Request $request)
    {
        $list_tire_target_km = TireTargetKm::where("company_id", auth()->user()->company->id)->get();
        $tiretargetkm = null;

        if ($id_tire_target_km = $request->query('tire_target_km_id'))
            $tiretargetkm = TireTargetKm::find($id_tire_target_km);

        return view("admin.report.tire-target-km", compact('tiretargetkm', 'list_tire_target_km'));
    }

    public function tireRtdPerUnit(Request $request)
    {
        $site = auth()->user()->site;
        $unitmodel_id = $request->query("unitmodel");
        $unitsite_id = $request->query("unitsite") ?? $site->id;
        $unitstatus_id = $request->query("unitstatus");

        $company = auth()->user()->company;

        $sites = Site::where('company_id', $company->id)->get();
        $unit_status = UnitStatus::all();
        $unit_model = UnitModel::with('tire_size')->where('company_id', $company->id)->get();

        $units = Unit::with('tire_runnings.tire.tire_size', 'unit_model');
        if ($unitmodel_id) {
            $units = $units->where('unit_model_id', $unitmodel_id);
        }
        if ($unitstatus_id) {
            $units = $units->where('unit_status_id', $unitstatus_id);
        }
        if ($unitsite_id) {
            $unit = $units->where('site_id', $unitsite_id);
        }
        $units = $units->orderBy('unit_number')->get();


        return view("admin.report.tire-rtd-per-unit", compact('unitmodel_id', 'unitsite_id', 'unitstatus_id', 'unit_status', 'unit_model', 'sites', 'units'));
    }

    public function reportTireCostByBrand(Request $request)
    {
        $tire_size = $request->query("tire_size");
        $start_date = $request->query("start_date");
        $end_date = $request->query("end_date");
        $company = auth()->user()->company_id;
        $status = $request->query("status");

        // dd($status);
        // Mendapatkan daftar ukuran ban yang unik untuk perusahaan
        $tire_sizes = TireSize::select("size")
            ->where('company_id', $company)
            ->groupBy("size")
            ->get();

        if ($request->ajax()) {
            // Query untuk mendapatkan total bulanan dari setiap unit berdasarkan kondisi tertentu
            $query = HistoryTireMovement::select(
                'tire_sizes.size',
                'tire_patterns.pattern',
                'tire_patterns.type_pattern',
                'tire_manufactures.name as manufaktur',
                DB::raw("COUNT(*) as qty"),
                DB::raw("SUM(history_tire_movements.price) as price"),
                DB::raw("(SUM(history_tire_movements.price/history_tire_movements.km_tire))/COUNT(*) as cpk"),
                DB::raw("(SUM(history_tire_movements.price/history_tire_movements.hm_tire))/COUNT(*) as cph"),
                DB::raw("MIN(history_tire_movements.price/history_tire_movements.km_tire) as min_cpk"),
                DB::raw("MIN(history_tire_movements.price/history_tire_movements.hm_tire) as min_cph"),
                DB::raw("MAX(history_tire_movements.price/history_tire_movements.km_tire) as max_cpk"),
                DB::raw("MAX(history_tire_movements.price/history_tire_movements.hm_tire) as max_cph")
            )
                ->leftJoin('units', 'history_tire_movements.unit', '=', 'units.unit_number')
                ->leftJoin('unit_models', 'unit_models.id', '=', 'units.unit_model_id')
                ->leftJoin('tires', 'tires.serial_number', '=', 'history_tire_movements.tire')
                ->leftJoin('tire_sizes', 'tire_sizes.id', '=', 'tires.tire_size_id')
                ->leftJoin('tire_patterns', 'tire_sizes.tire_pattern_id', '=', 'tire_patterns.id')
                ->leftJoin('tire_manufactures', 'tire_patterns.tire_manufacture_id', '=', 'tire_manufactures.id')
                ->where('history_tire_movements.company_id', $company)
                ->where('units.site_id', auth()->user()->site->id)
                ->groupBy('tire_sizes.size', 'tire_patterns.pattern', 'tire_patterns.type_pattern', 'tire_manufactures.name');

            if ($status) {
                $query->where('history_tire_movements.status', $status);
            }
            if ($tire_size) {
                $query->where('tire_sizes.size', $tire_size);
            }

            if ($start_date) {
                $query->whereDate('history_tire_movements.start_date', '>=', $start_date);
            }

            if ($end_date) {
                $query->whereDate('history_tire_movements.start_date', '<=', $end_date);
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn("size", function ($row) {
                    return $row->size ?? 'N/A';
                })
                ->addColumn("manufaktur", function ($row) {
                    return $row->manufaktur ?? 'N/A';
                })
                ->addColumn("pattern", function ($row) {
                    return $row->pattern ?? 'N/A';
                })
                ->addColumn("type_pattern", function ($row) {
                    return $row->type_pattern ?? 'N/A';
                })
                ->addColumn('qty', function ($row) {
                    return number_format($row->qty, 0, ',', '.');
                })
                ->addColumn('cpk', function ($row) {
                    return number_format($row->cpk, 0, ',', '.');
                })
                ->addColumn('cph', function ($row) {
                    return number_format($row->cph, 0, ',', '.');
                })
                ->addColumn('min_cpk', function ($row) {
                    return number_format($row->min_cpk, 0, ',', '.');
                })
                ->addColumn('min_cph', function ($row) {
                    return number_format($row->min_cph, 0, ',', '.');
                })
                ->addColumn('max_cpk', function ($row) {
                    return number_format($row->max_cpk, 0, ',', '.');
                })
                ->addColumn('max_cph', function ($row) {
                    return number_format($row->max_cph, 0, ',', '.');
                })
                ->addColumn('price', function ($row) {
                    return number_format($row->price, 0, ',', '.');
                })
                ->make(true);
        }

        return view("admin.report.tireCost", compact('tire_sizes', 'tire_size'));
    }

    public function reportTireCostByUnit(Request $request)
    {
        $tire_size = $request->query("tire_size");
        $start_date = $request->query("start_date");
        $end_date = $request->query("end_date");
        $status = $request->query("status");
        $company = auth()->user()->company_id;

        // Mendapatkan daftar ukuran ban yang unik untuk perusahaan
        $tire_sizes = TireSize::select("size")
            ->where('company_id', $company)
            ->groupBy("size")
            ->get();

        if ($request->ajax()) {
            // Query untuk mendapatkan total bulanan dari setiap unit berdasarkan kondisi tertentu
            $query = HistoryTireMovement::select(
                'units.unit_number',
                'unit_models.brand',
                'tire_sizes.size',
                'tire_patterns.pattern',
                'tire_patterns.type_pattern',
                'tire_manufactures.name as manufaktur',
                DB::raw("COUNT(*) as qty"), // Count distinct rows for each group
                DB::raw("SUM(history_tire_movements.price) as price")
            )
                ->leftJoin('units', 'history_tire_movements.unit', '=', 'units.unit_number')
                ->leftJoin('unit_models', 'unit_models.id', '=', 'units.unit_model_id')
                ->leftJoin('tires', 'tires.serial_number', '=', 'history_tire_movements.tire')
                ->leftJoin('tire_sizes', 'tire_sizes.id', '=', 'tires.tire_size_id')
                ->leftJoin('tire_patterns', 'tire_sizes.tire_pattern_id', '=', 'tire_patterns.id')
                ->leftJoin('tire_manufactures', 'tire_patterns.tire_manufacture_id', '=', 'tire_manufactures.id')
                // ->where('history_tire_movements.process', 'INSTALL')
                // ->where('history_tire_movements.status', 'SCRAP')
                ->where('history_tire_movements.price', '>', 0)
                ->where('history_tire_movements.company_id', $company)
                ->where('units.site_id', auth()->user()->site->id)
                ->groupBy(
                    'units.unit_number',
                    'unit_models.brand',
                    'tire_sizes.size',
                    'tire_patterns.pattern',
                    'tire_patterns.type_pattern',
                    'tire_manufactures.name'
                );

            if ($tire_size) {
                $query->where('tire_sizes.size', $tire_size);
            } else {
                $query->where('tire_sizes.size', '==', 'NEW');
            }

            if ($status) {
                $query->where('history_tire_movements.status', $status);
            }
            if ($start_date) {
                $query->whereDate('history_tire_movements.start_date', '>=', $start_date);
            }
            if ($end_date) {
                $query->whereDate('history_tire_movements.start_date', '<=', $end_date);
            }
            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('unit_number', function ($row) {
                    return $row->unit_number ?? 'N/A'; // Menampilkan 'N/A' jika brand null
                })
                ->addColumn("brand", function ($row) {
                    return $row->brand ?? 'N/A';
                })
                ->addColumn("size", function ($row) {
                    return $row->size ?? 'N/A';
                })
                ->addColumn("manufaktur", function ($row) {
                    return $row->manufaktur ?? 'N/A';
                })
                ->addColumn("pattern", function ($row) {
                    return $row->pattern ?? 'N/A';
                })
                ->addColumn("type_pattern", function ($row) {
                    return $row->type_pattern ?? 'N/A';
                })
                ->addColumn('qty', function ($row) {
                    return number_format($row->qty, 0, ',', '.'); // Format dengan pemisah ribuan
                })
                ->addColumn('price', function ($row) {
                    return number_format($row->price, 0, ',', '.'); // Format dengan pemisah ribuan
                })
                ->make(true);
        }
        return view("admin.report.tire-cost-unit", compact('tire_sizes', 'tire_size'));
    }

    public function reportTireCostComparation(Request $request, TireMaster $tire)
    {
        $year = $request->query('year') ?? Carbon::now()->format("Y");
        $company = auth()->user()->company;

        if ($request->ajax()) {
            $query = HistoryTireMovement::select(
                'tire_sizes.size as unit',
                DB::raw("SUM(CASE WHEN MONTH(history_tire_movements.start_date) = 1 AND status = 'NEW' THEN history_tire_movements.price ELSE 0 END) AS 'realized1'"),
                DB::raw("SUM(CASE WHEN MONTH(history_tire_movements.start_date) = 2 AND status = 'NEW' THEN history_tire_movements.price ELSE 0 END) AS 'realized2'"),
                DB::raw("SUM(CASE WHEN MONTH(history_tire_movements.start_date) = 3 AND status = 'NEW' THEN history_tire_movements.price ELSE 0 END) AS 'realized3'"),
                DB::raw("SUM(CASE WHEN MONTH(history_tire_movements.start_date) = 4 AND status = 'NEW' THEN history_tire_movements.price ELSE 0 END) AS 'realized4'"),
                DB::raw("SUM(CASE WHEN MONTH(history_tire_movements.start_date) = 5 AND status = 'NEW' THEN history_tire_movements.price ELSE 0 END) AS 'realized5'"),
                DB::raw("SUM(CASE WHEN MONTH(history_tire_movements.start_date) = 6 AND status = 'NEW' THEN history_tire_movements.price ELSE 0 END) AS 'realized6'"),
                DB::raw("SUM(CASE WHEN MONTH(history_tire_movements.start_date) = 7 AND status = 'NEW' THEN history_tire_movements.price ELSE 0 END) AS 'realized7'"),
                DB::raw("SUM(CASE WHEN MONTH(history_tire_movements.start_date) = 8 AND status = 'NEW' THEN history_tire_movements.price ELSE 0 END) AS 'realized8'"),
                DB::raw("SUM(CASE WHEN MONTH(history_tire_movements.start_date) = 9 AND status = 'NEW' THEN history_tire_movements.price ELSE 0 END) AS 'realized9'"),
                DB::raw("SUM(CASE WHEN MONTH(history_tire_movements.start_date) = 10 AND status = 'NEW' THEN history_tire_movements.price ELSE 0 END) AS 'realized10'"),
                DB::raw("SUM(CASE WHEN MONTH(history_tire_movements.start_date) = 11 AND status = 'NEW' THEN history_tire_movements.price ELSE 0 END) AS 'realized11'"),
                DB::raw("SUM(CASE WHEN MONTH(history_tire_movements.start_date) = 12 AND status = 'NEW' THEN history_tire_movements.price ELSE 0 END) AS 'realized12'"),
                DB::raw("SUM(CASE WHEN status = 'NEW' THEN history_tire_movements.price ELSE 0 END) AS 'total_realized'"),

                // Using MAX to retrieve forecast values per group
                DB::raw("MAX(forecast_tire_sizes.january) AS 'forecast1'"),
                DB::raw("MAX(forecast_tire_sizes.february) AS 'forecast2'"),
                DB::raw("MAX(forecast_tire_sizes.march) AS 'forecast3'"),
                DB::raw("MAX(forecast_tire_sizes.april) AS 'forecast4'"),
                DB::raw("MAX(forecast_tire_sizes.may) AS 'forecast5'"),
                DB::raw("MAX(forecast_tire_sizes.june) AS 'forecast6'"),
                DB::raw("MAX(forecast_tire_sizes.july) AS 'forecast7'"),
                DB::raw("MAX(forecast_tire_sizes.august) AS 'forecast8'"),
                DB::raw("MAX(forecast_tire_sizes.september) AS 'forecast9'"),
                DB::raw("MAX(forecast_tire_sizes.october) AS 'forecast10'"),
                DB::raw("MAX(forecast_tire_sizes.november) AS 'forecast11'"),
                DB::raw("MAX(forecast_tire_sizes.december) AS 'forecast12'"),
                DB::raw("MAX(forecast_tire_sizes.january) + MAX(forecast_tire_sizes.february) + MAX(forecast_tire_sizes.march) + MAX(forecast_tire_sizes.april) + MAX(forecast_tire_sizes.may) + MAX(forecast_tire_sizes.june) + MAX(forecast_tire_sizes.july) + MAX(forecast_tire_sizes.august) + MAX(forecast_tire_sizes.september) + MAX(forecast_tire_sizes.october) + MAX(forecast_tire_sizes.november) + MAX(forecast_tire_sizes.december) AS 'total_forecast'")
            )
                ->leftJoin('tires', 'tires.serial_number', '=', 'history_tire_movements.tire')
                ->leftJoin('tire_sizes', 'tire_sizes.id', '=', 'tires.tire_size_id')
                ->leftJoin('tire_patterns', 'tire_sizes.tire_pattern_id', '=', 'tire_patterns.id')
                ->leftJoin('tire_manufactures', 'tire_patterns.tire_manufacture_id', '=', 'tire_manufactures.id')
                ->leftJoin('sizes', 'sizes.name', '=', 'tire_sizes.size')
                ->leftJoin("forecast_tire_sizes", function ($join) use ($year, $company) {
                    $join->on("forecast_tire_sizes.tire_size_id", "=", "sizes.id")
                        ->where("forecast_tire_sizes.year", "=", $year)
                        ->where("forecast_tire_sizes.company_id", "=", $company->id);
                })
                ->whereYear("history_tire_movements.start_date", $year)
                ->where("history_tire_movements.company_id", $company->id)
                ->groupBy('tire_sizes.size');

            $result = $query->get();

            return DataTables::of($result)
                ->addIndexColumn()
                ->addColumn("forecast1", function ($row) {
                    return $row->forecast1 ?? 0;
                })
                ->addColumn("realized1", function ($row) {
                    return $row->realized1 ?? 0;
                })
                ->addColumn("result1", function ($row) {
                    $forecast1 = $row->forecast1 ?? 0;
                    $realized1 = $row->realized1 ?? 0;
                    return $forecast1 - $realized1;
                })
                ->addColumn("forecast2", function ($row) {
                    return $row->forecast2 ?? 0;
                })
                ->addColumn("realized2", function ($row) {
                    return $row->realized2 ?? 0;
                })
                ->addColumn("result2", function ($row) {
                    $forecast2 = $row->forecast2 ?? 0;
                    $realized2 = $row->realized2 ?? 0;
                    return $forecast2 - $realized2;
                })
                ->addColumn("forecast3", function ($row) {
                    return $row->forecast3 ?? 0;
                })
                ->addColumn("realized3", function ($row) {
                    return $row->realized3 ?? 0;
                })
                ->addColumn("result3", function ($row) {
                    $forecast3 = $row->forecast3 ?? 0;
                    $realized3 = $row->realized3 ?? 0;
                    return $forecast3 - $realized3;
                })
                ->addColumn("forecast4", function ($row) {
                    return $row->forecast4 ?? 0;
                })
                ->addColumn("realized4", function ($row) {
                    return $row->realized4 ?? 0;
                })
                ->addColumn("result4", function ($row) {
                    $forecast4 = $row->forecast4 ?? 0;
                    $realized4 = $row->realized4 ?? 0;
                    return $forecast4 - $realized4;
                })
                ->addColumn("forecast5", function ($row) {
                    return $row->forecast5 ?? 0;
                })
                ->addColumn("realized5", function ($row) {
                    return $row->realized5 ?? 0;
                })
                ->addColumn("result5", function ($row) {
                    $forecast5 = $row->forecast5 ?? 0;
                    $realized5 = $row->realized5 ?? 0;
                    return $forecast5 - $realized5;
                })
                ->addColumn("forecast6", function ($row) {
                    return $row->forecast6 ?? 0;
                })
                ->addColumn("realized6", function ($row) {
                    return $row->realized6 ?? 0;
                })
                ->addColumn("result6", function ($row) {
                    $forecast6 = $row->forecast6 ?? 0;
                    $realized6 = $row->realized6 ?? 0;
                    return $forecast6 - $realized6;
                })
                ->addColumn("forecast7", function ($row) {
                    return $row->forecast7 ?? 0;
                })
                ->addColumn("realized7", function ($row) {
                    return $row->realized7 ?? 0;
                })
                ->addColumn("result7", function ($row) {
                    $forecast7 = $row->forecast7 ?? 0;
                    $realized7 = $row->realized7 ?? 0;
                    return $forecast7 - $realized7;
                })
                ->addColumn("forecast8", function ($row) {
                    return $row->forecast8 ?? 0;
                })
                ->addColumn("realized8", function ($row) {
                    return $row->realized8 ?? 0;
                })
                ->addColumn("result8", function ($row) {
                    $forecast8 = $row->forecast8 ?? 0;
                    $realized8 = $row->realized8 ?? 0;
                    return $forecast8 - $realized8;
                })
                ->addColumn("forecast9", function ($row) {
                    return $row->forecast9 ?? 0;
                })
                ->addColumn("realized9", function ($row) {
                    return $row->realized9 ?? 0;
                })
                ->addColumn("result9", function ($row) {
                    $forecast9 = $row->forecast9 ?? 0;
                    $realized9 = $row->realized9 ?? 0;
                    return $forecast9 - $realized9;
                })
                ->addColumn("forecast10", function ($row) {
                    return $row->forecast10 ?? 0;
                })
                ->addColumn("realized10", function ($row) {
                    return $row->realized10 ?? 0;
                })
                ->addColumn("result10", function ($row) {
                    $forecast10 = $row->forecast10 ?? 0;
                    $realized10 = $row->realized10 ?? 0;
                    return $forecast10 - $realized10;
                })
                ->addColumn("forecast11", function ($row) {
                    return $row->forecast11 ?? 0;
                })
                ->addColumn("realized11", function ($row) {
                    return $row->realized11 ?? 0;
                })
                ->addColumn("result11", function ($row) {
                    $forecast11 = $row->forecast11 ?? 0;
                    $realized11 = $row->realized11 ?? 0;
                    return $forecast11 - $realized11;
                })
                ->addColumn("forecast12", function ($row) {
                    return $row->forecast12 ?? 0;
                })
                ->addColumn("realized12", function ($row) {
                    return $row->realized12 ?? 0;
                })
                ->addColumn("result12", function ($row) {
                    $forecast12 = $row->forecast12 ?? 0;
                    $realized12 = $row->realized12 ?? 0;
                    return $forecast12 - $realized12;
                })
                ->addColumn("total_forecast", function ($row) {
                    return $row->total_forecast ?? 0;
                })
                ->addColumn("total_realized", function ($row) {
                    return $row->total_realized ?? 0;
                })
                ->addColumn("result", function ($row) {
                    $totalForecast = $row->total_forecast ?? 0;
                    $totalRealized = $row->total_realized ?? 0;
                    return $totalForecast - $totalRealized;
                })
                ->make(true);
        }

        return view("admin.report.tire-cost-comparation", compact('year'));
    }

    public function reportHistoryTireScrap(Request $request)
    {
        $company = auth()->user()->company;
        $data = HistoryTireMovement::with(['tire_number', 'site', 'tire_damage', 'driver'])
            ->where('process', 'REMOVE')->where('status', 'SCRAP')->where('company_id', $company->id)
            ->orderBy('start_date', 'desc')
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
                ->addColumn("size", function ($row) {
                    return $row->tire_number->tire_size->size;
                })
                ->addColumn("manufaktur", function ($row) {
                    return $row->tire_number->tire_size->tire_pattern->manufacture->name;
                })
                ->addColumn("pattern", function ($row) {
                    return $row->tire_number->tire_size->tire_pattern->pattern;
                })
                ->addColumn("type_pattern", function ($row) {
                    return $row->tire_number->tire_size->tire_pattern->type_pattern;
                })
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
                ->addColumn("rtd", function ($row) {
                    return number_format($row->rtd, 0, ',', '.');
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
                ->addColumn("price", function ($row) {
                    return number_format($row->price, 0, ',', '.');
                })
                ->addColumn("photo", function ($row) {
                    if ($row->photo) {
                        $url = asset('storage/' . $row->photo);
                        return "<a href='#' class='photo-link' data-photo-url='$url'>View Photo</a>";
                    }
                    return 'No Photo';
                })
                ->rawColumns(['photo']) // Allows HTML rendering in the photo column
                ->make(true);
        }

        return view("admin.history.historyTireScrap");
    }
    public function reportTimeDailyActivity(Request $request, TireMaster $tire)
    {
        $year = $request->query('year') ?? Carbon::now()->format("Y");
        $company = auth()->user()->company;

        if ($request->ajax()) {
            // Query untuk mengambil data berdasarkan teknisi dan bulan
            $queryActivity = DailyActivity::select(
                'teknisis.nama as teknisi',
                // Agregasi total waktu per bulan dengan menggunakan CASE WHEN
                DB::raw("SUM(CASE WHEN MONTH(daily_activities.start_date) = 1 THEN TIMESTAMPDIFF(SECOND, daily_activities.start_date, daily_activities.end_date) ELSE 0 END) as total1"),
                DB::raw("SUM(CASE WHEN MONTH(daily_activities.start_date) = 1 THEN 1 ELSE 0 END) as total_activities1"),
                DB::raw("SUM(CASE WHEN MONTH(daily_activities.start_date) = 2 THEN TIMESTAMPDIFF(SECOND, daily_activities.start_date, daily_activities.end_date) ELSE 0 END) as total2"),
                DB::raw("SUM(CASE WHEN MONTH(daily_activities.start_date) = 2 THEN 1 ELSE 0 END) as total_activities2"),
                DB::raw("SUM(CASE WHEN MONTH(daily_activities.start_date) = 3 THEN TIMESTAMPDIFF(SECOND, daily_activities.start_date, daily_activities.end_date) ELSE 0 END) as total3"),
                DB::raw("SUM(CASE WHEN MONTH(daily_activities.start_date) = 3 THEN 1 ELSE 0 END) as total_activities3"),
                DB::raw("SUM(CASE WHEN MONTH(daily_activities.start_date) = 4 THEN TIMESTAMPDIFF(SECOND, daily_activities.start_date, daily_activities.end_date) ELSE 0 END) as total4"),
                DB::raw("SUM(CASE WHEN MONTH(daily_activities.start_date) = 4 THEN 1 ELSE 0 END) as total_activities4"),
                DB::raw("SUM(CASE WHEN MONTH(daily_activities.start_date) = 5 THEN TIMESTAMPDIFF(SECOND, daily_activities.start_date, daily_activities.end_date) ELSE 0 END) as total5"),
                DB::raw("SUM(CASE WHEN MONTH(daily_activities.start_date) = 5 THEN 1 ELSE 0 END) as total_activities5"),
                DB::raw("SUM(CASE WHEN MONTH(daily_activities.start_date) = 6 THEN TIMESTAMPDIFF(SECOND, daily_activities.start_date, daily_activities.end_date) ELSE 0 END) as total6"),
                DB::raw("SUM(CASE WHEN MONTH(daily_activities.start_date) = 6 THEN 1 ELSE 0 END) as total_activities6"),
                DB::raw("SUM(CASE WHEN MONTH(daily_activities.start_date) = 7 THEN TIMESTAMPDIFF(SECOND, daily_activities.start_date, daily_activities.end_date) ELSE 0 END) as total7"),
                DB::raw("SUM(CASE WHEN MONTH(daily_activities.start_date) = 7 THEN 1 ELSE 0 END) as total_activities7"),
                DB::raw("SUM(CASE WHEN MONTH(daily_activities.start_date) = 8 THEN TIMESTAMPDIFF(SECOND, daily_activities.start_date, daily_activities.end_date) ELSE 0 END) as total8"),
                DB::raw("SUM(CASE WHEN MONTH(daily_activities.start_date) = 8 THEN 1 ELSE 0 END) as total_activities8"),
                DB::raw("SUM(CASE WHEN MONTH(daily_activities.start_date) = 9 THEN TIMESTAMPDIFF(SECOND, daily_activities.start_date, daily_activities.end_date) ELSE 0 END) as total9"),
                DB::raw("SUM(CASE WHEN MONTH(daily_activities.start_date) = 9 THEN 1 ELSE 0 END) as total_activities9"),
                DB::raw("SUM(CASE WHEN MONTH(daily_activities.start_date) = 10 THEN TIMESTAMPDIFF(SECOND, daily_activities.start_date, daily_activities.end_date) ELSE 0 END) as total10"),
                DB::raw("SUM(CASE WHEN MONTH(daily_activities.start_date) = 10 THEN 1 ELSE 0 END) as total_activities10"),
                DB::raw("SUM(CASE WHEN MONTH(daily_activities.start_date) = 11 THEN TIMESTAMPDIFF(SECOND, daily_activities.start_date, daily_activities.end_date) ELSE 0 END) as total11"),
                DB::raw("SUM(CASE WHEN MONTH(daily_activities.start_date) = 11 THEN 1 ELSE 0 END) as total_activities11"),
                DB::raw("SUM(CASE WHEN MONTH(daily_activities.start_date) = 12 THEN TIMESTAMPDIFF(SECOND, daily_activities.start_date, daily_activities.end_date) ELSE 0 END) as total12"),
                DB::raw("SUM(CASE WHEN MONTH(daily_activities.start_date) = 12 THEN 1 ELSE 0 END) as total_activities12")
            )
                ->join('teknisis', 'daily_activities.teknisi_id', '=', 'teknisis.id')
                ->whereYear('daily_activities.start_date', $year)
                ->where('daily_activities.company_id', auth()->user()->company->id)
                ->groupBy('teknisis.nama')
                ->orderBy('teknisis.nama', 'ASC') // Menyusun berdasarkan nama teknisi
                ->get();

            // Group dan map data berdasarkan teknisi dan bulan
            $result = $queryActivity->map(function ($activity) {
                $data = [
                    'teknisi' => $activity->teknisi,
                ];

                // Set default total dan average untuk setiap bulan (1-12)
                for ($i = 1; $i <= 12; $i++) {
                    $data["total$i"] = $activity["total$i"] ?? 0;
                    // Menghitung rata-rata per bulan (dalam detik)
                    $data["average$i"] = $activity["total_activities$i"] > 0
                        ? $activity["total$i"] / $activity["total_activities$i"] // Average per bulan
                        : 0;
                }

                return $data;
            });

            // Return the data in DataTables format
            return DataTables::of($result)
                ->addIndexColumn()
                ->make(true);
        }

        // Return the main view with the selected year
        return view("admin.report.time-daily-activity", compact('year'));
    }
}
