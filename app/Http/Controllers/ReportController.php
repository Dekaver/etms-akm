<?php

namespace App\Http\Controllers;

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
use DB;
use Gate;
use Illuminate\Http\Request;
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
                    return $row->scrap_count;
                })
                ->addColumn('spare', function ($row) {
                    return $row->spare_count;
                })
                ->addColumn('running', function ($row) {
                    return $row->running_count;
                })
                ->addColumn('new', function ($row) {
                    return $row->new_count;
                })
                ->addColumn('repair', function ($row) {
                    return $row->repair_count;
                })
                ->addColumn('inventory', function ($row) {
                    return $row->new_count + $row->spare_count;
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
                    'tire_sizes.size as tire_size',
                    'tire_patterns.pattern',
                    'tire_patterns.type_pattern',
                    'tire_statuses.status',
                    'sites.name as site_name',
                    'units.unit_number',
                    'tire_manufactures.name as manufacture',
                    'tire_damages.damage',
                    DB::raw('(tire_sizes.otd - tires.rtd) as rtd') // Misalnya jika `otd` dan `rtd` tersedia
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
                    return $row->tire?->tire_size?->tire_pattern?->pattern;
                })
                ->addColumn('serial_number', function ($row) {
                    return $row->tire?->serial_number;
                })
                ->addColumn('status', function ($row) {
                    return $row->tire?->tire_status?->status;
                })
                ->addColumn('site_name', function ($row) {
                    return $row->site?->name;
                })
                ->addColumn('unit_number', function ($row) {
                    return $row->unit?->unit_number;
                })
                ->addColumn('lifetime_hm', function ($row) {
                    return $row->tire?->lifetime_hm;
                })
                ->addColumn('lifetime_km', function ($row) {
                    return $row->tire?->lifetime_km;
                })
                ->addColumn('rtd', function ($row) {
                    return $row->tire?->rtd;
                })
                ->addColumn('manufacture', function ($row) {
                    return $row->tire?->tire_size?->tire_pattern?->manufacture?->name;
                })
                ->addColumn('manufacture_pattern', function ($row) {
                    return "{$row->tire?->tire_size?->tire_pattern?->type_pattern}-{$row->tire?->tire_size?->tire_pattern?->manufacture?->name}-{$row->tire?->tire_size?->tire_pattern?->pattern}";
                })
                ->addColumn('type', function ($row) {
                    return $row->tire?->tire_size?->tire_pattern?->type_pattern;
                })
                ->addColumn('damage', function ($row) {
                    return $row->tire?->tire_damage?->damage;
                })
                ->addColumn('km_per_mm', function ($row) {
                    if (!empty($row->tire) && !empty($row->tire?->tire_size) && isset($row->tire?->rtd)) {
                        $rtd = (int) $row->tire?->tire_size?->otd - (int) $row->tire?->rtd;
                        if ($rtd == 0) {
                            return null; // Atau return nilai default yang sesuai
                        }
                        return round((int) $row->tire?->lifetime_km / ($rtd || 1), 1);
                    }
                    return null; // Atau nilai default jika relasi tidak lengkap
                })
                ->addColumn('tur', function ($row) {
                    return $row->tire?->tur;
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
}
