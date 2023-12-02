<?php

namespace App\Http\Controllers;

use App\Models\HistoryTireMovement;
use App\Models\Site;
use App\Models\TireManufacture;
use App\Models\TireMaster;
use App\Models\TirePattern;
use App\Models\TireRunning;
use App\Models\TireSize;
use App\Models\UnitModel;
use Carbon\Carbon;
use DB;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        abort_if(auth()->user()->company == null, Response::HTTP_FORBIDDEN, 'Some ERROR please contact the administrator');
        $year = Carbon::now()->format('Y');
        $month = Carbon::now()->format('m');
        // STOK
        $stok_new = TireMaster::where("company_id", auth()->user()->company->id)
            ->where("is_repairing", false)
            ->whereNotIn("id", DB::table('tire_runnings')->select("tire_id")->where("company_id", auth()->user()->company_id))
            ->whereHas("tire_status", function ($query) {
                $query->where("status", "NEW");
            })->count();

        $stok_spare = TireMaster::where("company_id", auth()->user()->company->id)
            ->where("is_repairing", false)
            ->whereNotIn("id", DB::table('tire_runnings')->select("tire_id")->where("company_id", auth()->user()->company_id))
            ->whereHas("tire_status", function ($query) {
                $query->where("status", "SPARE");
            })->count();

        $stok_repair = TireMaster::where("company_id", auth()->user()->company->id)
            ->where("is_repairing", false)
            ->whereNotIn("id", DB::table('tire_runnings')->select("tire_id")->where("company_id", auth()->user()->company_id))
            ->whereHas("tire_status", function ($query) {
                $query->where("status", "REPAIR");
            })->count();

        // RUNNING
        $install_new = TireMaster::where("company_id", auth()->user()->company->id)
            ->whereIn("id", DB::table('tire_runnings')->select("tire_id")->where("company_id", auth()->user()->company_id))
            ->whereHas("tire_status", function ($query) {
                $query->where("status", "NEW");
            })
            ->count();

        $install_spare = TireMaster::where("company_id", auth()->user()->company->id)
            ->whereIn("id", DB::table('tire_runnings')->select("tire_id")->where("company_id", auth()->user()->company_id))
            ->whereHas("tire_status", function ($query) {
                $query->where("status", "SPARE");
            })->count();

        $install_repair = TireMaster::where("company_id", auth()->user()->company->id)
            ->whereIn("id", DB::table('tire_runnings')->select("tire_id")->where("company_id", auth()->user()->company_id))
            ->whereHas("tire_status", function ($query) {
                $query->where("status", "REPAIR");
            })->count();


        // Scrap Tire
        $scrap = TireMaster::where("company_id", auth()->user()->company->id)->whereHas("tire_status", function ($query) {
            $query->where("status", "SCRAP");
        })->count();

        // REPAIRING Tire
        $repairing = TireMaster::where("company_id", auth()->user()->company->id)->where('is_repairing', true)->count();

        // SCHEDULE
        $schedule = HistoryTireMovement::where("status_schedule", 'Schedule')->where('company_id', auth()->user()->company->id)->count();

        // UNSCHEDULE
        $unschedule = HistoryTireMovement::where("status_schedule", 'Unschedule')->where('company_id', auth()->user()->company->id)->count();

        // $tire_running = TireRunning::where("company_id", auth()->user()->company->id)->get();
        $tire_running = TireMaster::where("company_id", auth()->user()->company->id)
            ->whereIn("id", DB::table('tire_runnings')->select("tire_id")->where("company_id", auth()->user()->company_id))->get();
        $running_days = [
            "day1" => 0,
            "day2" => 0,
            "day3" => 0,
            "day4" => 0,
        ];
        foreach ($tire_running as $key => $tire) {
            switch ($tire) {
                case $tire->count_day <= 7 && $tire->count_day > 0:
                    $running_days["day1"] += 1;
                    break;

                case $tire->count_day <= 30 && $tire->count_day > 7:
                    $running_days["day2"] += 1;
                    break;

                case $tire->count_day <= 60 && $tire->count_day > 30:
                    $running_days["day3"] += 1;
                    break;

                case $tire->count_day > 60 :
                    $running_days["day3"] += 1;
                    break;

                default:
                    break;
            }
        }

        $tire_stok = TireMaster::where("company_id", auth()->user()->company->id)
            ->whereNotIn("id", DB::table('tire_runnings')->select("tire_id")->where("company_id", auth()->user()->company_id))->get();

        $stok_days = [
            "day1" => 0,
            "day2" => 0,
            "day3" => 0,
            "day4" => 0,
        ];
        foreach ($tire_stok as $key => $tire) {
            switch ($tire) {
                case $tire->count_day <= 7 && $tire->count_day > 0:
                    $stok_days["day1"] += 1;
                    break;

                case $tire->count_day <= 30 && $tire->count_day > 7:
                    $stok_days["day2"] += 1;
                    break;

                case $tire->count_day <= 60 && $tire->count_day > 30:
                    $stok_days["day3"] += 1;
                    break;

                case $tire->count_day > 60 :
                    $stok_days["day3"] += 1;
                    break;

                default:
                    break;
            }
        }

        return view("admin.dashboard", compact("stok_new", "stok_repair", "stok_spare", "install_new", "install_repair", "install_spare", "scrap", 'repairing', 'schedule', 'unschedule', 'running_days', 'stok_days'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function dashboard(Request $request)
    {
        $current_year = date('Y');
        $date_range1 = range($current_year, $current_year + 3);
        $date_range2 = range($current_year, $current_year - 3);
        $date_range = array_merge($date_range1, $date_range2);
        $date_range = array_unique($date_range);
        asort($date_range);

        $tahun = $request->query('tahun');
        if (Gate::any(['isSuperAdmin', 'isViewer', 'isManager'])) {
            $site_name = $request->query('site');
        } else {
            $site_name = $request->query('site') ?? auth()->user()->site->site_name;
        }

        $tire_new_install = HistoryTireMovement::where('tire_status_id', 2);
        $model_type = $request->query('model_type');
        $brand_tire = $request->query('brand_tire');
        $type_pattern = $request->query('type_pattern');
        $tire_size = $request->query('tire_size');
        $tire_pattern = $request->query('tire_pattern');
        $month = $request->query('month');
        $week = $request->query('week');
        $tire_sizes = TireSize::select('size')->groupBy('size')->get();
        $site = Site::all();
        $type = UnitModel::select("type")->groupby('type')->get();
        $result_passing = [
            'tahun' => $tahun,
            'site' => $site_name,
            'model_type' => $model_type,
            'brand_tire' => $brand_tire,
            'type_pattern' => $type_pattern,
            'tire_size' => $tire_size,
            'month' => $month,
            'week' => $week,
            'tire_pattern' => $tire_pattern,
        ];
        // $result_passing = serialize($result_passing);
        // dd($result_passing);

        $ranges = [
            1 => [1, 7],
            2 => [8, 14],
            3 => [15, 21],
        ];
        if ($week == 4) {
            if ($month) {
                $month_carbon = Carbon::parse("$tahun-$month");
                $days = $month_carbon->daysInMonth;
                $ranges[4] = [22, $days];
            }
        }
        $manufacturer = TireManufacture::all();
        $type_patterns = TirePattern::select('type_pattern')->groupBy('type_pattern')->get();
        $tire_patterns = TirePattern::select('pattern')->groupBy('pattern')->get();
        $tires = TireMaster::select('tire_statuses.status')
            ->selectRaw('COUNT(tires.id) total')
            ->leftJoin('tire_statuses', 'tires.tire_status_id', '=', 'tire_statuses.id')
            ->leftJoin(DB::raw("(select max(id) as id, tire_serial_number from history_tire_movements group by tire_serial_number) as sl"), function ($q) {
                $q->on('sl.tire_serial_number', '=', 'tires.serial_number');
            });
        $tires = $tires->leftJoin('history_tire_movements', 'sl.id', '=', 'history_tire_movements.id');
        $tires = $tires->whereNull('tires.deleted_at');
        if ($tahun) {
            if ($month) {
                if ($week) {
                    $tires = $tires->whereBetween('history_tire_movements.date', ["$tahun-$month-{$ranges[$week][0]}", "$tahun-$month-{$ranges[$week][1]}"]);
                    $tire_new_install = $tire_new_install->whereBetween("date", ["$tahun-$month-{$ranges[$week][0]}", "$tahun-$month-{$ranges[$week][1]}"]);
                } else {
                    $tires = $tires->whereMonth('history_tire_movements.date', $month);
                    $tire_new_install = $tire_new_install->whereMonth("date", $month);
                }
            } else {
                $tires = $tires->whereYear('history_tire_movements.date', $tahun);
                $tire_new_install = $tire_new_install->whereYear("date", $tahun);
            }
        }

        if ($site_name) {
            $tires = $tires->wherehas("site", function ($q) use ($site_name) {
                $q->where('site_name', $site_name);
            });
            $tire_new_install = $tire_new_install->wherehas("site", function ($q) use ($site_name) {
                $q->where('site_name', $site_name);
            });
        }
        $tires = $tires->whereHas('tire_size', function ($q) use ($brand_tire, $type_pattern, $tire_size) {
            if ($tire_size) {
                $q->where('size', $tire_size);
            }
            $q->whereHas("tire_pattern", function ($q) use ($brand_tire, $type_pattern) {
                if ($type_pattern) {
                    $q->where('type_pattern', $type_pattern);
                }
                if ($brand_tire) {
                    $q->whereHas("tire_manufacturer", function ($q) use ($brand_tire) {
                        $q->where('name', $brand_tire);
                    });
                }
            });
        });
        $tire_new_install = $tire_new_install->whereHas('tire', function ($q) use ($brand_tire, $type_pattern, $tire_size) {
            if ($tire_size) {
                $q->whereHas('tire_size', function ($z) use ($tire_size, $brand_tire, $type_pattern, ) {
                    $z->where('size', $tire_size);
                    $z->whereHas("tire_pattern", function ($q) use ($brand_tire, $type_pattern) {
                        if ($type_pattern) {
                            $q->where('type_pattern', $type_pattern);
                        }
                        if ($brand_tire) {
                            $q->whereHas("tire_manufacturer", function ($q) use ($brand_tire) {
                                $q->where('name', $brand_tire);
                            });
                        }
                    });
                });
            }

        });


        $tires = $tires->groupBy('tire_statuses.status')
            ->get();
        // dd($tires);
        // dd($tires);
        $tire_status = $tires ?? 0;
        // dd($tire_status);
        foreach ($tires as $key => $value) {
            $tire_status[$value->status] = $value->total;
        }

        $tire_lifetime = TireMaster::select('size')
            ->selectRaw("AVG(size) avg_lifetime")
            ->join('tire_sizes', 'tires.tire_size_id', '=', 'tire_sizes.id')
            ->leftJoin(DB::raw("(select max(id) as id, tire_serial_number from history_tire_movements group by tire_serial_number) as sl"), function ($q) {
                $q->on('sl.tire_serial_number', '=', 'tires.serial_number');
            })
            ->where('tire_sizes.size', '24.00R35');
        $tire_lifetime = $tire_lifetime->leftJoin('history_tire_movements', 'sl.id', '=', 'history_tire_movements.id');
        if ($tahun) {
            $tire_lifetime = $tire_lifetime->whereYear("history_tire_movements.date", $tahun);
            if ($month) {
                $tire_lifetime = $tire_lifetime->whereMonth("history_tire_movements.date", $month);
            }
        }
        if ($site_name) {
            $tire_lifetime = $tire_lifetime->wherehas("site", function ($q) use ($site_name) {
                $q->where('site_name', $site_name);
            });
        }
        $tire_lifetime = $tire_lifetime->whereHas('tire_size', function ($q) use ($brand_tire, $type_pattern, $tire_size) {
            if ($tire_size) {
                $q->where('size', $tire_size);
            }
            $q->whereHas("tire_pattern", function ($q) use ($brand_tire, $type_pattern) {
                if ($type_pattern) {
                    $q->where('type_pattern', $type_pattern);
                }
                if ($brand_tire) {
                    $q->whereHas("tire_manufacturer", function ($q) use ($brand_tire) {
                        $q->where('name', $brand_tire);
                    });
                }
            });
        });
        $tire_lifetime = $tire_lifetime->groupBy('tire_sizes.size')
            ->pluck('avg_lifetime')
            ->first();
        $tire_new_install = $tire_new_install->count();

        return view('dashboard', compact('result_passing', 'tire_status', 'tire_lifetime', "tahun", "site_name", "model_type", "brand_tire", "type_pattern", "tire_size", "month", "week", "site", "type", "manufacturer", "type_patterns", 'tire_sizes', 'tire_pattern', 'tire_patterns', 'tire_new_install', 'date_range'));
    }

    public function tirePerformance(Request $request)
    {
        $company = auth()->user()->company;
        $current_year = date('Y');
        $date_range1 = range($current_year, $current_year + 3);
        $date_range2 = range($current_year, $current_year - 3);
        $date_range = array_merge($date_range1, $date_range2);
        $date_range = array_unique($date_range);
        asort($date_range);
        $tahun = $request->query('tahun');
        $site_name = $request->query('site') ?? auth()->user()->site->site_name;
        $model_type = $request->query('model_type');
        $brand_tire = $request->query('brand_tire');
        $type_pattern = $request->query('type_pattern');
        $tire_size = $request->query('tire_size');
        $month = $request->query('month');
        $week = $request->query('week');
        $tire_pattern = $request->query('tire_pattern');

        $tire_patterns = TirePattern::select('pattern')->where("company_id", $company->id)->groupBy('pattern')->get();
        $site = Site::where("company_id", $company->id)->get();
        $tire_sizes = TireSize::select('size')->where("company_id", $company->id)->groupBy('size')->get();
        $type = UnitModel::select("type")->where("company_id", $company->id)->groupby('type')->get();
        $manufacturer = TireManufacture::where("company_id", $company->id)->get();
        $type_patterns = TirePattern::select('type_pattern')->where("company_id", $company->id)->groupBy('type_pattern')->get();

        return view('admin.grafik.performance', compact('site', 'tahun', 'site_name', 'month', 'week', 'tire_sizes', 'tire_size', 'brand_tire', 'model_type', 'type', 'manufacturer', 'type_pattern', 'type_patterns', 'tire_pattern', 'tire_patterns', 'date_range'));
    }

    public function tireMaintenance(Request $request)
    {
        $company = auth()->user()->company;
        $current_year = date('Y');
        $date_range1 = range($current_year, $current_year + 3);
        $date_range2 = range($current_year, $current_year - 3);
        $date_range = array_merge($date_range1, $date_range2);
        $date_range = array_unique($date_range);
        asort($date_range);
        $tahun = $request->query('tahun') ?? Carbon::now()->format('Y');
        if (Gate::any(['isSuperAdmin', 'isViewer', 'isManager'])) {
            $site_name = $request->query('site');
        } else {
            $site_name = $request->query('site') ?? auth()->user()->site->site_name;
        }
        $model_type = $request->query('model_type');
        $brand_tire = $request->query('brand_tire');
        $type_pattern = $request->query('type_pattern');
        $tire_size = $request->query('tire_size');
        $month = $request->query('month');
        $week = $request->query('week');
        $tire_pattern = $request->query('tire_pattern');

        $tire_patterns = TirePattern::select('pattern')->groupBy('pattern')->get();
        $site = Site::where("company_id", $company->id)->get();
        $tire_sizes = TireSize::select('size')->groupBy('size')->get();
        $type = UnitModel::select("type")->groupby('type')->get();
        $manufacturer = TireManufacture::all();
        $type_patterns = TirePattern::select('type_pattern')->groupBy('type_pattern')->get();
        $ranges_week = [
            1 => [1, 7],
            2 => [8, 14],
            3 => [15, 21],
        ];

        if ($week == 4) {
            if ($month) {
                $month_carbon = Carbon::parse("$tahun-$month");
                $days = $month_carbon->daysInMonth;
                $ranges_week[4] = [22, $days];
            }
        }

        $ranges = [
            '<10000' => 10000,
            '10001-20000' => 20000,
            '20001-30000' => 30000,
            '30001-40000' => 40000,
            '40001-50000' => 50000,
            '50001-60000' => 60000,
        ];

        // select('tires.*', )
        // ->leftJoin("tire_movements", )
        $history = TireMaster::where("tires.type_measure", 'km')
            ->whereNotNull('tires.lifetime')
            ->whereHas("tire_status", function ($q) {
                $q->where("status", "running");
            })
            ->whereNull('tires.deleted_at')
            ->leftJoin(DB::raw("(select max(id) as id, tire_serial_number from history_tire_movements group by tire_serial_number) as sl"), function ($q) {
                $q->on('sl.tire_serial_number', '=', 'tires.serial_number');
            })
            ->with('tire_damage');
        $history = $history->leftJoin('history_tire_movements', 'sl.id', '=', 'history_tire_movements.id');
        if ($tire_size) {
            $history = $history->whereHas('tire_size', function ($q) use ($tire_size) {
                $q->where('size', $tire_size);
            });
        }

        $history = $history->whereHas('tire_size', function ($q) use ($brand_tire, $type_pattern, $tire_pattern) {
            $q->whereHas("tire_pattern", function ($q) use ($brand_tire, $type_pattern, $tire_pattern) {
                if ($type_pattern) {
                    $q->where('type_pattern', $type_pattern);
                }
                if ($tire_pattern) {
                    $q->where('pattern', $tire_pattern);
                }
                if ($brand_tire) {
                    $q->whereHas("tire_manufacturer", function ($q) use ($brand_tire) {
                        $q->where('name', $brand_tire);
                    });
                }
            });
        });

        if ($site_name) {
            $history = $history->whereHas('site', function ($q) use ($site_name) {
                $q->where('site_name', $site_name);
            });
        }


        if ($tahun) {
            if ($month) {
                if ($week) {
                    $history = $history->whereBetween('history_tire_movements.date', ["$tahun-$month-{$ranges_week[$week][0]}", "$tahun-$month-{$ranges_week[$week][1]}"]);
                } else {
                    $history = $history->whereMonth('history_tire_movements.date', $month);
                }
            } else {
                $history = $history->whereYear('history_tire_movements.date', $tahun);
            }
        }
        $history = $history->get()
            ->map(function ($user) use ($ranges) {
                $lifetime = $user->lifetime;

                foreach ($ranges as $key => $breakpoint) {
                    if ($breakpoint >= $lifetime) {
                        $user->range = $key;
                        break;
                    }
                }

                return $user;
            })
            ->mapToGroups(function ($user, $key) {
                return [$user->range => $user];
            });
        foreach ($history as $key => $value) {
            $history[$key] = $value->mapToGroups(function ($v, $k) {
                return [($v->tire_damage->rating ?? '') => $v];
            })->map(function ($grouped) {
                return count($grouped);
            });
        }
        $tire_conditional_km = $history->toArray();

        $history = TireMaster::where("tires.type_measure", 'hm')
            ->whereNotNull('tires.lifetime')
            ->whereHas("tire_status", function ($q) {
                $q->where("status", "running");
            })
            ->whereNull('tires.deleted_at')
            ->leftJoin(DB::raw("(select max(id) as id, tire_serial_number from history_tire_movements group by tire_serial_number) as sl"), function ($q) {
                $q->on('sl.tire_serial_number', '=', 'tires.serial_number');
            })

            ->with('tire_damage');
        $history = $history->leftJoin('history_tire_movements', 'sl.id', '=', 'history_tire_movements.id');
        if ($tire_size) {
            $history = $history->whereHas('tire_size', function ($q) use ($tire_size) {
                $q->where('size', $tire_size);
            });
        }

        $history = $history->whereHas('tire_size', function ($q) use ($brand_tire, $type_pattern, $tire_pattern) {
            $q->whereHas("tire_pattern", function ($q) use ($brand_tire, $type_pattern, $tire_pattern) {
                if ($type_pattern) {
                    $q->where('type_pattern', $type_pattern);
                }
                if ($tire_pattern) {
                    $q->where('pattern', $tire_pattern);
                }
                if ($brand_tire) {
                    $q->whereHas("tire_manufacturer", function ($q) use ($brand_tire) {
                        $q->where('name', $brand_tire);
                    });
                }
            });
        });

        if ($site_name) {
            $history = $history->whereHas('site', function ($q) use ($site_name) {
                $q->where('site_name', $site_name);
            });
        }

        if ($tahun) {
            if ($month) {
                if ($week) {
                    $history = $history->whereBetween('history_tire_movements.date', ["$tahun-$month-{$ranges_week[$week][0]}", "$tahun-$month-{$ranges_week[$week][1]}"]);
                } else {
                    $history = $history->whereMonth('history_tire_movements.date', $month);
                }
            } else {
                $history = $history->whereYear('history_tire_movements.date', $tahun);
            }
        }
        $history = $history->get()
            ->map(function ($user) use ($ranges) {
                $lifetime = $user->lifetime;

                foreach ($ranges as $key => $breakpoint) {
                    if ($breakpoint >= $lifetime) {
                        $user->range = $key;
                        break;
                    }
                }

                return $user;
            })
            ->mapToGroups(function ($user, $key) {
                return [$user->range => $user];
            });
        foreach ($history as $key => $value) {
            $history[$key] = $value->mapToGroups(function ($v, $k) {
                return [($v->tire_damage->rating ?? '') => $v];
            })->map(function ($grouped) {
                return count($grouped);
            });
        }
        $tire_conditional_hm = $history->toArray();

        return view('admin.grafik.maintenance', compact('site', 'tahun', 'site_name', 'month', 'week', 'tire_sizes', 'tire_size', 'brand_tire', 'model_type', 'type', 'manufacturer', 'type_pattern', 'type_patterns', 'tire_conditional_hm', 'tire_conditional_km', 'tire_pattern', 'tire_patterns', 'date_range'));
    }

    public function tireScrap(Request $request)
    {
        $current_year = date('Y');
        $date_range1 = range($current_year, $current_year + 3);
        $date_range2 = range($current_year, $current_year - 3);
        $date_range = array_merge($date_range1, $date_range2);
        $date_range = array_unique($date_range);
        asort($date_range);
        $tahun = $request->query('tahun');
        if (Gate::any(['isSuperAdmin', 'isViewer', 'isManager'])) {
            $site_name = $request->query('site');
        } else {
            $site_name = $request->query('site') ?? auth()->user()->site->site_name;
        }
        $model_type = $request->query('model_type');
        $brand_tire = $request->query('brand_tire');
        $type_pattern = $request->query('type_pattern');
        $tire_size = $request->query('tire_size');
        $month = $request->query('month');
        $week = $request->query('week');
        $tire_pattern = $request->query('tire_pattern');
        $tire_patterns = TirePattern::select('pattern')->groupBy('pattern')->get();
        $site = Site::all();
        $tire_sizes = TireSize::select('size')->groupBy('size')->get();
        $type = UnitModel::select("type")->groupby('type')->get();
        $manufacturer = TireManufacture::all();
        $type_patterns = TirePattern::select('type_pattern')->groupBy('type_pattern')->get();

        return view('admin.grafik.scrap', compact('site', 'tahun', 'site_name', 'month', 'week', 'tire_sizes', 'tire_size', 'brand_tire', 'model_type', 'type', 'manufacturer', 'type_pattern', 'type_patterns', 'tire_pattern', 'tire_patterns', 'date_range'));
    }
}
