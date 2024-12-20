<?php

namespace App\Http\Controllers;

use App\Models\DailyActivity;
use App\Models\HistoryTireMovement;
use App\Models\Site;
use App\Models\TireDamage;
use App\Models\TireMaster as Tire;
use App\Models\DailyInspect as TireInspection;
use App\Models\DailyInspect;
use App\Models\TireMovement;
use App\Models\TireSize;
use App\Models\TireStatus;
use App\Models\Unit;
use App\Models\UnitModel;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use InvalidArgumentException;
use Illuminate\Database\Eloquent\Builder;

class GrafikController extends Controller
{
    public function checkPressureHd(Request $request)
    {
        $current_year = date('Y');
        $date_range1 = range($current_year, $current_year + 3);
        $date_range2 = range($current_year, $current_year - 3);
        $date_range = array_merge($date_range1, $date_range2);
        $date_range = array_unique($date_range);
        asort($date_range);
        $tahun = $request->query('tahun');
        if (Gate::any(['isSuperAdmin', 'isViewer', 'isManager'])) {
            $name = $request->query('site');
        } else {
            $name = $request->query('site') ?? auth()->user()->site->name;
        }
        $model_type = $request->query('model_type');
        $brand_tire = $request->query('brand_tire');
        $type_pattern = $request->query('type_pattern');
        $tire_size = $request->query('tire_size') ?? '12.00R24';
        $tire_pattern = $request->query('tire_pattern');
        $month = $request->query('month');
        $month = $request->query('month');
        $week = $request->query('week');
        $running_id = TireStatus::where("status", "running")->pluck("id")->first();

        $recomendation_pressure = RecomendationPressure::where('tire_size', $tire_size)->first();

        if ($recomendation_pressure == null) {
            $data['act'] = [];
            $data['target'] = [];
            $data['max'] = 100;
            $data['acv'] = [];
            return $data;
        }
        if ($tahun) {
            if ($month) {
                $date = Carbon::parse("$tahun-$month");
                $day = $date->daysInMonth;
                $j = $i = 0;
                do {
                    $j = $i + (int) $recomendation_pressure->total_pressure_check_day_range;
                    if ($j + $recomendation_pressure->total_pressure_check_day_range > $day) {
                        $ranges["$i-" . $day] = $day;
                    } else {
                        $ranges["$i-" . $j - 1] = $j;
                    }
                    $i = $j;
                } while ($j + $recomendation_pressure->total_pressure_check_day_range < $day);
            } else {
                $ranges = [
                    'JAN' => 1,
                    'FEB' => 2,
                    'MAR' => 3,
                    'APR' => 4,
                    'MEY' => 5,
                    'JUN' => 6,
                    'JUL' => 7,
                    'AUG' => 8,
                    'SEP' => 9,
                    'OCT' => 10,
                    'NOV' => 11,
                    'DES' => 12,
                ];
            }
        }
        //ambil semua unit yang memiliki munit model untuk mengambil ukuran ban
        $unit = Unit::whereNotNull('unit_model_id');
        if ($tire_size) {
            $unit = $unit->whereHas('unit_model', function ($query) use ($tire_size, $model_type) {
                if ($model_type) {
                    $query->where('type', $model_type);
                }
                $query->whereHas('tire_size', function ($q) use ($tire_size) {
                    $q->where('size', $tire_size);
                });
            });
        }

        if ($name) {
            $unit = $unit->whereHas("site", function ($q) use ($name) {
                $q->where("name", $name);
            });
        }
        //filter total unit ban terpasang lebih 75%
        $unit = $unit->get()->filter(function ($value, $key) use ($running_id) {
            $total_slot_ban = $value->unit_model->tire_quantity;
            $total_ban_terpasang = $value->tire_movements->where("tire_status_id", $running_id)->count();
            return $total_ban_terpasang / $total_slot_ban >= 0.75;
        });

        $unit_array = $unit->pluck('unit_number')->toArray();
        $history = TireInspection::select('unit_number', 'date')->with("tire")->whereIn('unit_number', $unit_array);
        if ($tahun) {
            $history = $history->whereyear('date', $tahun);
            if ($month) {
                $history = $history->whereMonth('date', $month);
            }
        }
        $history = $history->whereHas('tire', function ($q) use ($brand_tire, $type_pattern, $tire_pattern, $tire_size) {

            $q->whereHas('tire_size', function ($q) use ($brand_tire, $type_pattern, $tire_pattern, $tire_size) {
                $q->whereNull('tires.deleted_at');
                $q->distinct();
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
        });
        $history = $history
            ->groupBy([DB::raw('date'), 'unit_number'])
            ->get()
            ->map(function ($user) use ($ranges, $month) {
                if ($month) {
                    $day = $user->date->format('d');
                    foreach ($ranges as $key => $breakpoint) {
                        if ($breakpoint >= $day) {
                            $user->range = $key;
                            break;
                        }
                    }
                } else {
                    $month = $user->date->format('m');
                    foreach ($ranges as $key => $breakpoint) {
                        if ($breakpoint >= $month) {
                            $user->range = $key;
                            break;
                        }
                    }
                }

                return $user;
            })
            ->mapToGroups(function ($user, $key) {
                return [$user->range => $user];
            })
            ->map(function ($group) {
                return count($group);
            })
            ->toArray();

        $total = 0;
        $total_target = 0;
        if ($tahun) {
            if ($month) {
                foreach ($unit as $key => $value) {
                    if ($rec_pressure = $value->unit_model->tire_size->recomendation_pressure->total_pressure_check ?? null) {
                        $total_target += (int) $rec_pressure ?? 0;
                    }
                }
            } else {
                foreach ($unit as $key => $value) {
                    if ($rec_pressure = $value->unit_model->tire_size->recomendation_pressure->total_pressure_check ?? null) {
                        $times = 0;
                        $range = 0;
                        do {
                            $range += $value->unit_model->tire_size->recomendation_pressure->total_pressure_check_day_range ?? 0;
                            if ($range == 0) {
                                break;
                            }
                            $times += 1;
                        } while ($range + $value->unit_model->tire_size->recomendation_pressure->total_pressure_check_day_range < 31);
                        $total_target += (int) $rec_pressure * $times ?? 0;
                    }
                }
            }
        }

        foreach ($ranges as $key => $value) {
            $act[] = $history[$key] ?? 0;
            $total += $history[$key] ?? 0;
            $data['target'][] = $total_target;
            $data['label'][] = $key;
        }

        $data['act'] = $act;
        $max = max($data['target']);

        $bulat = pow(10, strlen($max) - 1);

        if ($tahun) {
            if ($month) {
                $data['act'][] = $total;
                $data['target'][] = $total_target * count($ranges);
                $data['label'][] = $date->isoFormat('MMM');
                $data['max'] = ceil(($total_target * count($ranges)) / $bulat) * $bulat;
            } else {
                $data['max'] = ceil($max / $bulat) * $bulat;
            }
        }

        for ($i = 0; $i < count($data['target']); $i++) {
            $data['acv'][$i] = $data['target'][$i] == 0 ? 0 : round(($data['act'][$i] / $data['target'][$i]) * 100, 1);
        }

        return $data;
    }

    public function checkRTD(Request $request)
    {
        $current_year = date('Y');
        $date_range1 = range($current_year, $current_year + 3);
        $date_range2 = range($current_year, $current_year - 3);
        $date_range = array_merge($date_range1, $date_range2);
        $date_range = array_unique($date_range);
        asort($date_range);
        $tahun = $request->query('tahun');
        if (Gate::any(['isSuperAdmin', 'isViewer', 'isManager'])) {
            $name = $request->query('site');
        } else {
            $name = $request->query('site') ?? auth()->user()->site->name;
        }
        $model_type = $request->query('model_type');
        $brand_tire = $request->query('brand_tire');
        $type_pattern = $request->query('type_pattern');
        $tire_pattern = $request->query('tire_pattern');
        $tire_size = $request->query('tire_size') ?? '12.00R24';
        $month = $request->query('month');
        $month = $request->query('month');
        $week = $request->query('week');

        $running_id = TireStatus::where("status", "running")->pluck("id")->first();

        $recomendation_rtd = RecomendationPressure::where('tire_size', $tire_size)->first();

        if ($recomendation_rtd == null) {
            $data['act'] = [];
            $data['target'] = [];
            $data['max'] = 100;
            $data['acv'] = [];
            return $data;
        }
        if ($tahun) {
            if ($month) {
                $date = Carbon::parse("$tahun-$month");
                $day = $date->daysInMonth;
                $j = $i = 0;
                do {
                    $j = $i + (int) $recomendation_rtd->total_rtd_check_day_range;
                    if ($j + $recomendation_rtd->total_rtd_check_day_range > $day) {
                        $ranges["$i-" . $day] = $day;
                    } else {
                        $ranges["$i-" . $j - 1] = $j;
                    }
                    $i = $j;
                } while ($j + $recomendation_rtd->total_rtd_check_day_range < $day);
            } else {
                $ranges = [
                    'JAN' => 1,
                    'FEB' => 2,
                    'MAR' => 3,
                    'APR' => 4,
                    'MEY' => 5,
                    'JUN' => 6,
                    'JUL' => 7,
                    'AUG' => 8,
                    'SEP' => 9,
                    'OCT' => 10,
                    'NOV' => 11,
                    'DES' => 12,
                ];
            }
        }

        $unit = Unit::whereNotNull('unit_model_id');
        if ($tire_size) {
            $unit = $unit->whereHas('unit_model', function ($query) use ($tire_size, $model_type) {
                if ($model_type) {
                    $query->where('type', $model_type);
                }
                $query->whereHas('tire_size', function ($q) use ($tire_size) {
                    $q->where('size', $tire_size);
                });
            });
        }
        if ($name) {
            $unit = $unit->whereHas("site", function ($q) use ($name) {
                $q->where("name", $name);
            });
        }
        $unit = $unit->get()->filter(function ($value, $key) use ($running_id) {
            $total_slot_ban = $value->unit_model->tire_quantity;
            $total_ban_terpasang = $value->tire_movements->where("tire_status_id", $running_id)->count();
            return $total_ban_terpasang / $total_slot_ban >= 0.75;
        });

        $unit_array = $unit->pluck('unit_number')->toArray();
        $history = TireInspection::select('unit_number', 'date')->whereIn('unit_number', $unit_array);
        if ($tahun) {
            $history = $history->whereyear('date', $tahun);
            if ($month) {
                $history = $history->whereMonth('date', $month);
            }
        }
        $history = $history->whereHas('tire', function ($q) use ($brand_tire, $type_pattern, $tire_pattern, $tire_size) {
            $q->whereHas('tire_size', function ($q) use ($brand_tire, $type_pattern, $tire_pattern, $tire_size) {
                $q->whereNull('tires.deleted_at');
                $q->distinct();
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
        });
        $history = $history
            ->groupBy([DB::raw('date'), 'unit_number'])
            ->get()
            ->map(function ($user) use ($ranges, $month) {
                if ($month) {
                    $day = $user->date->format('d');
                    foreach ($ranges as $key => $breakpoint) {
                        if ($breakpoint >= $day) {
                            $user->range = $key;
                            break;
                        }
                    }
                } else {
                    $month = $user->date->format('m');
                    foreach ($ranges as $key => $breakpoint) {
                        if ($breakpoint >= $month) {
                            $user->range = $key;
                            break;
                        }
                    }
                }

                return $user;
            })
            ->mapToGroups(function ($user, $key) {
                return [$user->range => $user];
            })
            ->map(function ($group) {
                return count($group);
            })
            ->toArray();

        $total = 0;
        $total_target = 0;
        if ($tahun) {
            if ($month) {
                foreach ($unit as $key => $value) {
                    if ($rec_rtd = $value->unit_model->tire_size->recomendation_pressure->total_rtd_check ?? null) {
                        $total_target += (int) $rec_rtd ?? 0;
                    }
                }
            } else {
                foreach ($unit as $key => $value) {
                    if ($rec_rtd = $value->unit_model->tire_size->recomendation_pressure->total_rtd_check ?? null) {
                        $times = 0;
                        $range = 0;
                        do {
                            $range += $value->unit_model->tire_size->recomendation_pressure->total_rtd_check_day_range ?? 0;
                            if ($range == 0) {
                                break;
                            }
                            $times += 1;
                        } while ($range + $value->unit_model->tire_size->recomendation_pressure->total_rtd_check_day_range < 31);
                        $total_target += (int) $rec_rtd * $times ?? 0;
                    }
                }
            }
        }

        foreach ($ranges as $key => $value) {
            $act[] = $history[$key] ?? 0;
            $total += $history[$key] ?? 0;
            $data['target'][] = $total_target;
            $data['label'][] = $key;
        }
        $data['act'] = $act;
        $max = max($data['target']);

        $bulat = pow(10, strlen($max) - 1);

        if ($tahun) {
            if ($month) {
                $data['act'][] = $total;
                $data['target'][] = $total_target * count($ranges);
                $data['label'][] = $date->isoFormat('MMM');
                $data['max'] = ceil(($total_target * count($ranges)) / $bulat) * $bulat;
            } else {
                $data['max'] = ceil($max / $bulat) * $bulat;
            }
        }

        for ($i = 0; $i < count($data['target']); $i++) {
            $data['acv'][$i] = $data['target'][$i] == 0 ? 0 : round(($data['act'][$i] / $data['target'][$i]) * 100, 1);
        }

        return $data;
    }
    public function checkPressureSupport()
    {
        $recomendation_pressure = RecomendationPressure::where('type', 'LV')->first();

        if ($recomendation_pressure == null) {
            $data['act'] = [];
            $data['target'] = [];
            $data['max'] = 100;
            $data['acv'] = [];
            return $data;
        }

        $ranges = [
            // the start of each day-range.
            'week 1' => 7,
            'week 1' => 14,
            'week 1' => 21,
            'week 4' => 31,
        ];
        $unit = Unit::whereHas('type', function ($query) use ($recomendation_pressure) {
            $query->whereHas('tire_size', function ($q) use ($recomendation_pressure) {
                $q->whereIn('size', ['265/75R16', '11.00R22.5', '10.00R20', '11.00R20', '3.00-15']);
            });
        })->get();
        $unit_array = $unit->pluck('id')->toArray();
        $history = TireInspection::select('unit_number', 'date')
            ->whereIn('unit_number', $unit_array)
            ->whereMonth('date', 07)
            ->groupBy([DB::raw('date'), 'unit_number'])
            ->get()
            ->map(function ($user) use ($ranges) {
                $day = $user->date->format('d');

                foreach ($ranges as $key => $breakpoint) {
                    if ($breakpoint >= $day) {
                        $user->range = $key;
                        break;
                    }
                }

                return $user;
            })
            ->mapToGroups(function ($user, $key) {
                return [$user->range => $user];
            })
            ->map(function ($group) {
                return count($group);
            })
            ->toArray();
        $total = 0;
        foreach ($history as $key => $value) {
            $total += $value;
        }

        $total_target = 0;
        foreach ($unit as $key => $value) {
            if ($rec_pressure = $value->type->tire_size->recomendation_pressure->total_pressure_check ?? null) {
                $total_target += (int) $rec_pressure ?? 0;
            }
        }
        $act[0] = $history['week 1'] ?? 0;
        $act[1] = $history['week 2'] ?? 0;
        $act[2] = $history['week 3'] ?? 0;
        $act[3] = $history['week 4'] ?? 0;
        $act[4] = $total;
        $data['act'] = $act;
        $data['target'] = [$total_target, $total_target, $total_target, $total_target, $total_target * 4];
        $data['max'] = $total_target * 4 + 20;

        for ($i = 0; $i < 5; $i++) {
            $acv[$i] = $data['target'][$i] == 0 ? 0 : round(($data['act'][$i] / $data['target'][$i]) * 100, 1);
        }

        $data['acv'] = $acv;
        return $data;
    }

    public function tireInflation()
    {
        $low = 90;
        $over = 130;
        $ranges = [
            'low' => 90,
            'normal' => 130,
            'over' => 1000,
        ];
        $history = TireInspection::whereNotNull('pressure')
            ->get()
            ->map(function ($user) use ($ranges) {
                $inflation = $user->pressure;

                foreach ($ranges as $key => $breakpoint) {
                    if ($breakpoint >= $inflation) {
                        $user->range = $key;
                        break;
                    }
                }

                return $user;
            })
            ->mapToGroups(function ($user, $key) {
                return [$user->range => $user];
            })
            ->map(function ($group) {
                return count($group);
            })
            ->toArray();
        $data['low'] = $history['low'] ?? 0;
        $data['normal'] = $history['normal'] ?? 0;
        $data['over'] = $history['over'] ?? 0;
        return $data;
    }

    public function tireInventory(Request $request)
    {
        $current_year = date('Y');
        $date_range1 = range($current_year, $current_year + 3);
        $date_range2 = range($current_year, $current_year - 3);
        $date_range = array_merge($date_range1, $date_range2);
        $date_range = array_unique($date_range);
        asort($date_range);
        $tahun = $request->query('tahun');
        if (Gate::any(['isSuperAdmin', 'isViewer', 'isManager'])) {
            $name = $request->query('site');
        } else {
            $name = $request->query('site') ?? auth()->user()->site->name;
        }
        $model_type = $request->query('model_type');
        $brand_tire = $request->query('brand_tire');
        $tire_size = $request->query('tire_size');
        $tire_pattern = $request->query('tire_pattern');
        $type_pattern = $request->query('type_pattern');
        $month = $request->query('month');
        $week = $request->query('week');
        $ranges = [
            '<10000' => 10000,
            '10001-20000' => 20000,
            '20001-30000' => 30000,
            '30001-40000' => 40000,
            '40001-50000' => 50000,
            '50001-60000' => 60000,
        ];

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

        $arr_tire_size = TireSize::select('size')
            ->groupBy('size')
            ->pluck('size')
            ->toArray();
        if (in_array($tire_size, $arr_tire_size)) {
            $tire_sizes = $tire_size ? [$tire_size] : ['27.00R49', '12.00R24', '24.00R35'];
        } else {
            $tire_sizes = ['27.00R49', '12.00R24', '24.00R35'];
        }

        foreach ($tire_sizes as $key => $size) {
            $history = Tire::leftJoin(DB::raw("(select max(id) as id, tire from history_tire_movements group by tire) as sl"), function ($q) {
                $q->on('sl.tire', '=', 'tires.serial_number');
            });
            $history = $history->leftJoin('history_tire_movements', 'sl.id', '=', 'history_tire_movements.id');
            $history = $history->whereNotNull('tires.lifetime_hm')->whereHas('tire_size', function ($q) use ($size) {
                $q->where('size', $size);
            });
            $history = $history->where('tires.tire_status_id', 1);

            if ($tahun) {
                if ($month) {
                    if ($week) {
                        $history = $history->whereBetween('history_tire_movements.start_date', ["$tahun-$month-{$ranges_week[$week][0]}", "$tahun-$month-{$ranges_week[$week][1]}"]);
                    } else {
                        $history = $history->whereMonth('history_tire_movements.start_date', $month);
                    }
                } else {
                    $history = $history->whereYear('history_tire_movements.start_date', $tahun);
                }
            }

            $history = $history->whereHas('tire_size', function ($q) use ($brand_tire, $tire_pattern, $type_pattern) {
                $q->whereHas('tire_pattern', function ($q) use ($brand_tire, $tire_pattern, $type_pattern) {
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

            if ($name) {
                $history = $history->whereHas('site', function ($q) use ($name) {
                    $q->where('name', $name);
                });
            }

            $history = $history
                ->get()
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
                })
                ->map(function ($group) {
                    return count($group);
                })
                ->toArray();
            $d = [];
            foreach ($ranges as $k => $value) {
                $d['name'] = $size;
                $d['type'] = 'bar';
                $d['data'][] = $history[$k] ?? 0;
            }
            $data['value'][] = $d;
        }

        $max = 0;
        foreach ($data['value'] as $key => $value) {
            if ($max < max($value['data'])) {
                $max = max($value['data']);
            }
        }

        $bulat = pow(10, strlen($max) - 1);

        $data['max'] = ceil($max / $bulat) * $bulat;
        $data['size'] = $tire_sizes;

        return $data;
    }

    public function tireConsumptionByModelUnit(Request $request)
    {
        // $current_year = date('Y');
        // $date_range1 = range($current_year, $current_year+3);
        // $date_range2 = range($current_year, $current_year-3);
        // $date_range = array_merge($date_range1,$date_range2);
        // $date_range = array_unique($date_range);
        // asort($date_range);
        $tahun = $request->query('tahun');
        if (Gate::any(['isSuperAdmin', 'isViewer', 'isManager'])) {
            $name = $request->query('site');
        } else {
            $name = $request->query('site') ?? auth()->user()->site->name;
        }
        $model_type = $request->query('model_type');
        $brand_tire = $request->query('brand_tire');
        $type_pattern = $request->query('type_pattern');
        $tire_pattern = $request->query('tire_pattern');
        $tire_size = $request->query('tire_size');
        $month = $request->query('month');
        $week = $request->query('week');

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

        if ($name) {
            $site = Site::where('name', $name)->get();
        } else {
            $site = Site::all();
        }
        $arr_unit_model = UnitModel::select('type')
            ->groupBy('type')
            ->pluck('type')
            ->toArray();
        $data['value']['running'] = [];
        $data['value']['scrap'] = [];
        $data['model'] = [];

        foreach ($site as $key => $item) {
            //tire running
            $tire_running = TireMovement::select('unit_models.type')
                ->selectRaw('COUNT(unit_models.type) as total')
                ->join('units', 'tire_movements.unit_number', '=', 'units.unit_number')
                ->join('unit_models', 'unit_models.id', '=', 'units.unit_model_id')
                ->where('tire_movements.site_id', $item->id)
                ->whereNull('tire_movements.deleted_at');
            if ($model_type) {
                $tire_running = $tire_running->where('unit_models.type', $model_type);
            }
            $tire_running = $tire_running->whereHas('tire', function ($q) use ($brand_tire, $type_pattern, $tire_pattern, $tire_size, $tahun, $month, $ranges, $week) {
                // $q->whereNull('deleted_at');
                if ($tahun) {
                    if ($month) {
                        if ($week) {
                            $q->whereBetween('date', ["$tahun-$month-{$ranges[$week][0]}", "$tahun-$month-{$ranges[$week][1]}"]);
                        } else {
                            $q->whereMonth('date', $month);
                        }
                    } else {
                        $q->whereYear('date', $tahun);
                    }
                }
                $q->whereHas('tire_size', function ($q) use ($brand_tire, $type_pattern, $tire_pattern, $tire_size) {
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
            });

            $tire_running = $tire_running
                ->whereHas('tire_status', function ($query) {
                    $query->where('status', 'running');
                })
                ->whereIn('unit_models.type', $arr_unit_model)
                ->groupBy('unit_models.type')
                ->orderBy('unit_models.type')
                ->get()
                ->toArray();
            //tire scrap
            $tire_scrap = TireMovement::select('unit_models.type')
                ->selectRaw('COUNT(unit_models.type) as total')
                ->join('units', 'tire_movements.unit_number', '=', 'units.unit_number')
                ->join('unit_models', 'unit_models.id', '=', 'units.unit_model_id')
                ->where('tire_movements.site_id', $item->id)
                ->whereNull('tire_movements.deleted_at');

            if ($model_type) {
                $tire_scrap = $tire_scrap->where('unit_models.type', $model_type);
            }
            $tire_scrap = $tire_scrap->whereHas('tire', function ($q) use ($brand_tire, $type_pattern, $tire_pattern, $tire_size, $tahun, $month, $ranges, $week) {
                if ($tahun) {
                    if ($month) {
                        if ($week) {
                            $q->whereBetween('date', ["$tahun-$month-{$ranges[$week][0]}", "$tahun-$month-{$ranges[$week][1]}"]);
                        } else {
                            $q->whereMonth('date', $month);
                        }
                    } else {
                        $q->whereYear('date', $tahun);
                    }
                }
                $q->whereHas('tire_size', function ($q) use ($brand_tire, $type_pattern, $tire_pattern, $tire_size) {
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
            });

            $tire_scrap = $tire_scrap
                ->whereHas('tire_status', function ($query) {
                    $query->where('status', 'scrap');
                })
                ->whereIn('unit_models.type', $arr_unit_model)
                ->groupBy('unit_models.type')
                ->orderBy('unit_models.type')
                ->get()
                ->toArray();

            foreach ($arr_unit_model as $key => $value) {
                if (!(array_search($value, array_column($tire_running, 'type')) === false) || !(array_search($value, array_column($tire_scrap, 'type')) === false)) {
                    $data['value']['running'][] = array_search($value, array_column($tire_running, 'type')) === false ? 0 : $tire_running[array_search($value, array_column($tire_running, 'type'))]['total'] ?? 0;
                    $data['value']['scrap'][] = array_search($value, array_column($tire_scrap, 'type')) === false ? 0 : $tire_scrap[array_search($value, array_column($tire_scrap, 'type'))]['total'] ?? 0;
                    $data['model'][] = "$item->name-$value";
                }
            }
        }

        $max = 0;
        foreach ($data['value'] as $key => $value) {
            if ($value != []) {
                if ($max < max($value)) {
                    $max = max($value);
                }
            }
        }
        $bulat = strlen($max) == 1 ? pow(10, strlen($max)) : pow(10, strlen($max) - 1);
        $data['max'] = ceil($max / $bulat) * $bulat;
        return $data;
    }

    public function tireCostPerHM(Request $request)
    {
        $current_year = date('Y');
        $date_range1 = range($current_year, $current_year + 3);
        $date_range2 = range($current_year, $current_year - 3);
        $date_range = array_merge($date_range1, $date_range2);
        $date_range = array_unique($date_range);
        asort($date_range);
        $tahun = $request->query('tahun');
        if (Gate::any(['isSuperAdmin', 'isViewer', 'isManager'])) {
            $name = $request->query('site');
        } else {
            $name = $request->query('site') ?? auth()->user()->site->name;
        }
        $model_type = $request->query('model_type');
        $brand_tire = $request->query('brand_tire');
        $tire_pattern = $request->query('tire_pattern');
        $type_pattern = $request->query('type_pattern');
        $tire_size = $request->query('tire_size');
        $month = $request->query('month');
        $week = $request->query('week');

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

        if ($name) {
            $site = Site::where('name', $name)->get();
        } else {
            $site = Site::all();
        }

        $arr_unit_model = UnitModel::select('type')
            ->groupBy('type')
            ->pluck('type')
            ->toArray();

        $data = [];
        $data['value'] = [];
        $data['model'] = [];

        foreach ($site as $key => $item) {
            $tire = HistoryTireMovement::select('unit_models.type')
                ->selectRaw('AVG(tires.price) as harga')
                ->selectRaw('AVG(tires.lifetime) as avg_lifetime')
                ->join('units', 'history_tire_movements.unit_number', '=', 'units.unit_number')
                ->join('tires', 'history_tire_movements.tire_serial_number', '=', 'tires.serial_number')
                ->join('unit_models', 'unit_models.id', '=', 'units.unit_model_id')
                ->where('units.jenis', 'hm')
                ->where('history_tire_movements.site_id', $item->id);

            if ($tahun) {
                if ($month) {
                    if ($week) {
                        $tire = $tire->whereBetween('history_tire_movements.start_date', ["$tahun-$month-{$ranges[$week][0]}", "$tahun-$month-{$ranges[$week][1]}"]);
                    } else {
                        $tire = $tire->whereMonth('history_tire_movements.start_date', $month);
                    }
                } else {
                    $tire = $tire->whereYear('history_tire_movements.start_date', $tahun);
                }
            }
            if ($model_type) {
                $tire = $tire->whereHas('unit', function ($q) use ($model_type) {
                    $q->whereHas('unit_model', function ($q) use ($model_type) {
                        $q->where('type', $model_type);
                    });
                });
            }
            $tire = $tire->whereHas('tire', function ($q) use ($brand_tire, $type_pattern, $tire_pattern, $tire_size) {
                $q->whereHas('tire_size', function ($q) use ($brand_tire, $type_pattern, $tire_pattern, $tire_size) {
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
            });
            $tire = $tire
                ->whereHas('tire_status', function ($query) {
                    $query->where('status', 'scrap');
                })
                ->whereIn('unit_models.type', $arr_unit_model)
                ->groupBy('unit_models.type')
                ->orderBy('unit_models.type')
                ->take(10)
                ->get()
                ->toArray();

            foreach ($arr_unit_model as $key => $value) {
                if (!(array_search($value, array_column($tire, 'type')) === false)) {
                    $avg_price = array_search($value, array_column($tire, 'type')) === false ? 0 : $tire[array_search($value, array_column($tire, 'type'))]['harga'];
                    $avg_lifetime = array_search($value, array_column($tire, 'type')) === false ? 0 : $tire[array_search($value, array_column($tire, 'type'))]['avg_lifetime'];
                    $data['value'][] = $avg_lifetime == 0 ? 0 : round($avg_price / $avg_lifetime) ?? 0;
                    $data['model'][] = "$item->name-$value";
                }
            }
        }
        $max = 0;
        if ($data['value'] != []) {
            $max = max($data['value']);
        }
        $bulat = pow(10, strlen($max) - 1);

        $data['max'] = ceil($max / $bulat) * $bulat;
        return $data;
    }

    public function tireCostPerKM(Request $request)
    {

        $current_year = date('Y');
        $date_range1 = range($current_year, $current_year + 3);
        $date_range2 = range($current_year, $current_year - 3);
        $date_range = array_merge($date_range1, $date_range2);
        $date_range = array_unique($date_range);
        asort($date_range);
        $tahun = $request->query('tahun');
        if (Gate::any(['isSuperAdmin', 'isViewer', 'isManager'])) {
            $name = $request->query('site');
        } else {
            $name = $request->query('site') ?? auth()->user()->site->name;
        }
        $model_type = $request->query('model_type');
        $brand_tire = $request->query('brand_tire');
        $tire_pattern = $request->query('tire_pattern');
        $type_pattern = $request->query('type_pattern');
        $tire_size = $request->query('tire_size');
        $month = $request->query('month');
        $week = $request->query('week');

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

        if ($name) {
            $site = Site::where('name', $name)->get();
        } else {
            $site = Site::all();
        }
        $arr_unit_model = UnitModel::select('type')
            ->groupBy('type')
            ->pluck('type')
            ->toArray();
        $data = [];
        $data['value'] = [];
        $data['model'] = [];
        foreach ($site as $key => $item) {
            $tire = HistoryTireMovement::select('unit_models.type')
                ->selectRaw('AVG(tires.price) as harga')
                ->selectRaw('AVG(tires.lifetime) as avg_lifetime')
                ->join('units', 'history_tire_movements.unit_number', '=', 'units.unit_number')
                ->join('tires', 'history_tire_movements.tire_serial_number', '=', 'tires.serial_number')
                ->join('unit_models', 'unit_models.id', '=', 'units.unit_model_id')
                ->where('units.jenis', 'km')
                ->where('history_tire_movements.site_id', $item->id);
            if ($tahun) {
                if ($month) {
                    if ($week) {
                        $tire = $tire->whereBetween('history_tire_movements.start_date', ["$tahun-$month-{$ranges[$week][0]}", "$tahun-$month-{$ranges[$week][1]}"]);
                    } else {
                        $tire = $tire->whereMonth('history_tire_movements.start_date', $month);
                    }
                } else {
                    $tire = $tire->whereYear('history_tire_movements.start_date', $tahun);
                }
            }
            if ($model_type) {
                $tire = $tire->whereHas('unit', function ($q) use ($model_type) {
                    $q->whereHas('unit_model', function ($q) use ($model_type) {
                        $q->where('type', $model_type);
                    });
                });
            }
            $tire = $tire->whereHas('tire', function ($q) use ($brand_tire, $type_pattern, $tire_pattern, $tire_size) {
                $q->whereHas('tire_size', function ($q) use ($brand_tire, $type_pattern, $tire_pattern, $tire_size) {
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
            });
            $tire = $tire
                ->whereHas('tire_status', function ($query) {
                    $query->where('status', 'scrap');
                })
                ->whereIn('unit_models.type', $arr_unit_model)
                ->groupBy('unit_models.type')
                ->orderBy('unit_models.type')
                ->take(10)
                ->get()
                ->toArray();

            foreach ($arr_unit_model as $key => $value) {
                if (!(array_search($value, array_column($tire, 'type')) === false)) {
                    $avg_price = array_search($value, array_column($tire, 'type')) === false ? 0 : $tire[array_search($value, array_column($tire, 'type'))]['harga'];
                    $avg_lifetime = array_search($value, array_column($tire, 'type')) === false ? 0 : $tire[array_search($value, array_column($tire, 'type'))]['avg_lifetime'];
                    $data['value'][] = round($avg_price / $avg_lifetime) ?? 0;
                    $data['model'][] = "$item->name-$value";
                }
            }
        }
        $max = 0;
        if ($data['value'] != []) {
            $max = max($data['value']);
        }

        $bulat = pow(10, strlen($max) - 1);

        $data['max'] = ceil($max / $bulat) * $bulat;
        if ($data['max'] == 0) {
            $data['max'] = 100;
        }
        return $data;
    }

    public function tireCostPerHMByPattern(Request $request)
    {
        $current_year = date('Y');
        $date_range1 = range($current_year, $current_year + 3);
        $date_range2 = range($current_year, $current_year - 3);
        $date_range = array_merge($date_range1, $date_range2);
        $date_range = array_unique($date_range);
        asort($date_range);
        $tahun = $request->query('tahun');
        if (Gate::any(['isSuperAdmin', 'isViewer', 'isManager'])) {
            $name = $request->query('site');
        } else {
            $name = $request->query('site') ?? auth()->user()->site->name;
        }
        $model_type = $request->query('model_type');
        $brand_tire = $request->query('brand_tire');
        $tire_pattern = $request->query('tire_pattern');
        $type_pattern = $request->query('type_pattern');
        $tire_size = $request->query('tire_size');
        $month = $request->query('month');
        $week = $request->query('week');

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

        if ($name) {
            $site = Site::where('name', $name)->get();
        } else {
            $site = Site::all();
        }
        $tire = Tire::where('serial_number', 'A19')->first();

        $data['pattern'] = [];
        $data['value'] = [];
        $data['max'] = 0;
        foreach ($site as $key => $item) {
            $tire = Tire::select('tire_patterns.pattern', 'tire_manufactures.name', 'tire_patterns.type_pattern')
                ->selectRaw('AVG(tire_sizes.price) as harga')
                ->selectRaw('AVG(tires.lifetime_hm) as avg_lifetime')
                ->join('tire_sizes', 'tires.tire_size_id', '=', 'tire_sizes.id')
                ->join('tire_patterns', 'tire_sizes.tire_pattern_id', '=', 'tire_patterns.id')
                ->join('tire_manufactures', 'tire_patterns.tire_manufacture_id', '=', 'tire_manufactures.id')
                ->leftJoin(DB::raw("(select max(id) as id, tire from history_tire_movements group by tire) as sl"), function ($q) {
                    $q->on('sl.tire', '=', 'tires.serial_number');
                })
                ->leftJoin('history_tire_movements', 'sl.id', '=', 'history_tire_movements.id')
                ->where('tires.site_id', $item->id);
            if ($tahun) {
                if ($month) {
                    if ($week) {
                        $tire = $tire->whereBetween('history_tire_movements.start_date', ["$tahun-$month-{$ranges[$week][0]}", "$tahun-$month-{$ranges[$week][1]}"]);
                    } else {
                        $tire = $tire->whereMonth('history_tire_movements.start_date', $month);
                    }
                } else {
                    $tire = $tire->whereYear('history_tire_movements.start_date', $tahun);
                }
            }

            // if($model_type){
            //     $tire = $tire->whereHas('unit', function($q) use ($model_type){
            //         $q->whereHas('unit_model', function($q) use ($model_type){
            //             $q->where('type', $model_type);
            //         });
            //     });
            // }
            $tire = $tire->whereHas('tire_size', function ($q) use ($brand_tire, $type_pattern, $tire_pattern, $tire_size) {
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
            $tire = $tire
                ->whereHas('tire_status', function ($query) {
                    $query->where('status', 'scrap');
                })
                ->groupBy(['tire_patterns.pattern', 'tire_manufactures.name', 'tire_patterns.type_pattern'])
                ->orderBy('tire_patterns.pattern')
                ->get();
            // if($model_type){
            //     $tire = $tire->filter(function($v, $k){
            //         return $v->
            //     });
            // }
            foreach ($tire as $key => $value) {
                $data['pattern'][] = "$value->type_pattern-$value->name-$value->pattern";
                $data['value'][] = round($value->avg_lifetime == 0 ? 0 : (int) $value->harga / (int) $value->avg_lifetime);
            }
        }
        $max = 0;
        if ($data['value'] != []) {
            $max = max($data['value']);
        }

        $bulat = pow(10, strlen($max) - 1);

        $data['max'] = ceil($max / $bulat) * $bulat;
        if ($data['max'] == 0) {
            $data['max'] = 100;
        }
        return $data;
    }
    public function tireCostPerKMByPattern(Request $request)
    {
        $current_year = date('Y');
        $date_range1 = range($current_year, $current_year + 3);
        $date_range2 = range($current_year, $current_year - 3);
        $date_range = array_merge($date_range1, $date_range2);
        $date_range = array_unique($date_range);
        asort($date_range);
        $tahun = $request->query('tahun');
        if (Gate::any(['isSuperAdmin', 'isViewer', 'isManager'])) {
            $name = $request->query('site');
        } else {
            $name = $request->query('site') ?? auth()->user()->site->name;
        }
        $model_type = $request->query('model_type');
        $tire_pattern = $request->query('tire_pattern');
        $type_pattern = $request->query('type_pattern');
        $brand_tire = $request->query('brand_tire');
        $tire_size = $request->query('tire_size');
        $month = $request->query('month');
        $week = $request->query('week');

        if ($name) {
            $site = Site::where('name', $name)->get();
        } else {
            $site = Site::all();
        }

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

        $data['pattern'] = [];
        $data['value'] = [];
        $data['max'] = 0;
        foreach ($site as $key => $item) {
            $tire = Tire::select('tire_patterns.pattern', 'tire_manufactures.name', 'tire_patterns.type_pattern')
                ->selectRaw('AVG(tire_sizes.price) as harga')
                ->selectRaw('AVG(tires.lifetime_km) as avg_lifetime')
                ->join('tire_sizes', 'tires.tire_size_id', '=', 'tire_sizes.id')
                ->join('tire_patterns', 'tire_sizes.tire_pattern_id', '=', 'tire_patterns.id')
                ->join('tire_manufactures', 'tire_patterns.tire_manufacture_id', '=', 'tire_manufactures.id')
                ->leftJoin(DB::raw("(select max(id) as id, tire from history_tire_movements group by tire) as sl"), function ($q) {
                    $q->on('sl.tire', '=', 'tires.serial_number');
                })
                ->where('tires.site_id', $item->id);
            $tire = $tire->leftJoin('history_tire_movements', 'sl.id', '=', 'history_tire_movements.id');
            if ($tahun) {
                if ($month) {
                    if ($week) {
                        $tire = $tire->whereBetween('history_tire_movements.start_date', ["$tahun-$month-{$ranges[$week][0]}", "$tahun-$month-{$ranges[$week][1]}"]);
                    } else {
                        $tire = $tire->whereMonth('history_tire_movements.start_date', $month);
                    }
                } else {
                    $tire = $tire->whereYear('history_tire_movements.start_date', $tahun);
                }
            }
            // if($model_type){
            //     $tire = $tire->whereHas('unit', function($q) use ($model_type){
            //         $q->whereHas('unit_model', function($q) use ($model_type){
            //             $q->where('type', $model_type);
            //         });
            //     });
            // }
            $tire = $tire->whereHas('tire_size', function ($q) use ($brand_tire, $tire_pattern, $type_pattern) {
                $q->whereHas('tire_pattern', function ($q) use ($brand_tire, $tire_pattern, $type_pattern) {
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
            $tire = $tire
                ->whereHas('tire_status', function ($query) {
                    $query->where('status', 'scrap');
                })
                ->groupBy(['tire_patterns.pattern', 'tire_manufactures.name', 'tire_patterns.type_pattern'])
                ->orderBy('tire_patterns.pattern')
                ->get();
            foreach ($tire as $key => $value) {
                $data['pattern'][] = "$value->type_pattern-$value->name-$value->pattern";
                $data['value'][] = round($value->avg_lifetime == 0 ? 0 : (int) $value->harga / (int) $value->avg_lifetime);
            }
        }
        $data['max'] = 0;
        $max = 0;
        if (!empty($data['value'])) {
            $max = max($data['value']);
        }
        $bulat = pow(10, strlen($max) - 1);
        $data['max'] = ceil($max / $bulat) * $bulat;

        if ($data['max'] == 0) {
            $data['max'] = 100;
        }
        return $data;
    }

    public function tireScrapInjuryCause(Request $request)
    {
        $current_year = date('Y');
        $company = auth()->user()->company;
        $date_range1 = range($current_year, $current_year + 3);
        $date_range2 = range($current_year, $current_year - 3);
        $date_range = array_merge($date_range1, $date_range2);
        $date_range = array_unique($date_range);
        asort($date_range);
        $tahun = $request->query('tahun');
        if (Gate::any(['isSuperAdmin', 'isViewer', 'isManager'])) {
            $name = $request->query('site');
        } else {
            $name = $request->query('site') ?? auth()->user()->site->name;
        }
        $model_type = $request->query('model_type');
        $brand_tire = $request->query('brand_tire');
        $type_pattern = $request->query('type_pattern');
        $tire_pattern = $request->query('tire_pattern');
        $tire_size = $request->query('tire_size');
        $month = $request->query('month');
        $week = $request->query('week');

        $site = Site::all();

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
        // foreach ($site as $key => $item) {
        // $tire = TireMovement::select('tire_damages.cause')
        //     ->selectRaw('COUNT(tire_damages.cause) as total')
        //     ->join('tire_damages', 'tire_movements.tire_damage_id', '=', 'tire_damages.id')
        //     ->join('tires', 'tire_movements.tire_serial_number', '=', 'tires.serial_number');

        $tire = Tire::select('tire_damages.cause')
            ->selectRaw('COUNT(tire_damages.cause) as total')
            ->join('tire_damages', 'tires.tire_damage_id', '=', 'tire_damages.id')
            ->leftJoin(DB::raw("(select max(id) as id, tire from history_tire_movements group by tire) as sl"), function ($q) {
                $q->on('sl.tire', '=', 'tires.serial_number');
            });
        $tire = $tire->leftJoin('history_tire_movements', 'sl.id', '=', 'history_tire_movements.id');
        $tire = $tire->where('tires.company_id', $company->id);
        if ($model_type) {
            $tire = $tire->whereHas('unit', function ($q) use ($model_type) {
                $q->whereHas('unit_model', function ($q) use ($model_type) {
                    $q->where('type', $model_type);
                });
            });
        }
        if ($name) {
            $tire = $tire->whereHas('site', function ($q) use ($name) {
                $q->where('name', $name);
            });
        }

        if ($tahun) {
            if ($month) {
                if ($week) {
                    $tire = $tire->whereBetween('history_tire_movements.start_date', ["$tahun-$month-{$ranges[$week][0]}", "$tahun-$month-{$ranges[$week][1]}"]);
                } else {
                    $tire = $tire->whereMonth('history_tire_movements.start_date', $month);
                }
            } else {
                $tire = $tire->whereYear('history_tire_movements.start_date', $tahun);
            }
        }
        $tire = $tire->whereHas('tire_size', function ($q) use ($brand_tire, $type_pattern, $tire_pattern, $tire_size) {
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
        $tire = $tire->whereHas('tire_status', function ($query) {
            $query->where('status', 'scrap');
        });


        $tire = $tire
            ->groupBy('tire_damages.cause')
            ->get();

        foreach ($tire as $item) {
            $data['data'][] = $item->total;
            $data['xaxis'][] = $item->cause;
        }

        return $data;
    }

    public function tireScrapInjury(Request $request)
    {
        $current_year = date('Y');
        $company = auth()->user()->company;
        $date_range1 = range($current_year, $current_year + 3);
        $date_range2 = range($current_year, $current_year - 3);
        $date_range = array_merge($date_range1, $date_range2);
        $date_range = array_unique($date_range);
        asort($date_range);
        $tahun = $request->query('tahun');
        if (Gate::any(['isSuperAdmin', 'isViewer', 'isManager'])) {
            $name = $request->query('site');
        } else {
            $name = $request->query('site') ?? auth()->user()->site->name;
        }
        $model_type = $request->query('model_type');
        $brand_tire = $request->query('brand_tire');
        $type_pattern = $request->query('type_pattern');
        $tire_pattern = $request->query('tire_pattern');
        $tire_size = $request->query('tire_size');
        $month = $request->query('month');
        $week = $request->query('week');

        $site = Site::all();

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

        $data['damage'] = [];
        $data['value'] = [];
        $data['max'] = 0;
        // foreach ($site as $key => $item) {
        $tire = Tire::select('tire_damages.damage')
            ->selectRaw('COUNT(tire_damages.damage) as total')
            ->leftJoin(DB::raw("(select max(id) as id, tire from history_tire_movements group by tire) as sl"), function ($q) {
                $q->on('sl.tire', '=', 'tires.serial_number');
            })
            ->join('tire_damages', 'tires.tire_damage_id', '=', 'tire_damages.id');

        $tire = $tire->leftJoin('history_tire_movements', 'sl.id', '=', 'history_tire_movements.id');

        // $tire = TireMovement::select('tire_damages.damage_name')
        //     ->selectRaw('COUNT(tire_damages.damage_name) as total')
        //     ->join('tire_damages', 'tire_movements.tire_damage_id', '=', 'tire_damages.id')
        //     ->join('tires', 'tire_movements.tire_serial_number', '=', 'tires.serial_number');
        $tire = $tire->where('tires.company_id', $company->id);

        if ($name) {
            $tire = $tire->whereHas('site', function ($q) use ($name) {
                $q->where('name', $name);
            });
        }

        if ($tahun) {
            if ($month) {
                if ($week) {
                    $tire = $tire->whereBetween('history_tire_movements.start_date', ["$tahun-$month-{$ranges[$week][0]}", "$tahun-$month-{$ranges[$week][1]}"]);
                } else {
                    $tire = $tire->whereMonth('history_tire_movements.start_date', $month);
                }
            } else {
                $tire = $tire->whereYear('history_tire_movements.start_date', $tahun);
            }
        }
        $tire = $tire->whereHas('tire_size', function ($q) use ($brand_tire, $type_pattern, $tire_pattern, $tire_size) {
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

        $tire = $tire
            ->whereHas('tire_status', function ($query) {
                $query->where('status', 'scrap');
            })
            ->groupBy('tire_damages.damage')
            ->get();

        foreach ($tire as $key => $value) {
            $data['damage'][] = $value->damage;
            $data['value'][] = $value->total;
        }
        // }
        $data['max'] = 0;
        $max = 0;
        if (!empty($data['value'])) {
            $max = max($data['value']);
        }
        $bulat = pow(10, strlen($max) - 1);
        $data['max'] = ceil($max / $bulat) * $bulat;
        return $data;
    }

    public function tireCauseDamage(Request $request)
    {
        $current_year = date('Y');
        $company = auth()->user()->company;
        $date_range1 = range($current_year, $current_year + 3);
        $date_range2 = range($current_year, $current_year - 3);
        $date_range = array_merge($date_range1, $date_range2);
        $date_range = array_unique($date_range);
        asort($date_range);
        $tahun = $request->query('tahun');
        $name = $request->query('site') ?? auth()->user()->site->name;
        $model_type = $request->query('model_type');
        $brand_tire = $request->query('brand_tire');
        $type_pattern = $request->query('type_pattern');
        $tire_pattern = $request->query('tire_pattern');
        $tire_size = $request->query('tire_size');
        $month = $request->query('month');
        $week = $request->query('week');


        $data['damage'] = [];
        $data['value'] = [];
        $data['max'] = 0;
        // foreach ($site as $key => $item) {
        // $tire = TireDamage::select('tire_damages.damage')
        $tire = TireDamage::select('tire_manufactures.name', 'tire_damages.damage', 'tire_damages.cause')
            ->selectRaw('COUNT(tire_manufactures.name) as total')
            // ->selectRaw('COUNT(tire_damages.damage) as total')

            ->join('history_tire_movements', 'history_tire_movements.tire_damage_id', '=', 'tire_damages.id')
            ->join('tires', 'tires.serial_number', '=', 'history_tire_movements.tire')
            ->join('tire_sizes', 'tire_sizes.id', '=', 'tires.tire_size_id')
            ->join('tire_patterns', 'tire_patterns.id', '=', 'tire_sizes.tire_pattern_id')
            ->join('tire_manufactures', 'tire_manufactures.id', '=', 'tire_patterns.tire_manufacture_id');

        $tire = $tire->whereIn('history_tire_movements.status', ['REPAIR', 'SCRAP']);
        $tire = $tire->where('history_tire_movements.company_id', $company->id);

        // dd($tire->get());

        if ($name) {
            $tire = $tire->join('sites', 'tires.site_id', '=', 'sites.id')->where('sites.name', $name);
        }
        if ($tahun) {
            if ($month) {
                if ($week) {
                    $tire = $tire->whereRaw("EXTRACT(week from history_tire_movements.start_date) = $week");
                } else {
                    $tire = $tire->whereMonth('history_tire_movements.start_date', $month);
                }
            } else {
                $tire = $tire->whereYear('history_tire_movements.start_date', $tahun);
            }
        }


        if ($tire_size) {
            $tire = $tire->where('tire_sizes.sizes', $tire_size);
        }
        if ($type_pattern) {
            $tire = $tire->where('tire_patterns.type_pattern', $type_pattern);
        }
        if ($tire_pattern) {
            $tire = $tire->where('tire_patterns.pattern', $tire_pattern);
        }
        if ($brand_tire) {
            $tire = $tire->where('tire_manufactures.name', $brand_tire);
        }


        $tire = $tire->groupBy('tire_manufactures.name', "tire_damages.damage", "tire_damages.cause")->get();

        $data = [];

        // Create an array to store unique 'name' values
        $nameValues = $tire->pluck('name')->unique()->values()->toArray();
        // Iterate through the original data
        foreach ($tire as $item) {
            $name = $item['name'];
            $damage = $item['damage'];
            $total = $item['total'];

            if (!isset($data[$damage])) {
                $data[$damage] = ['name' => $damage, 'data' => array_fill(0, count($nameValues), 0)];
            }

            // Find the index of the 'name' value in $nameValues
            $nameIndex = array_search($name, $nameValues);

            // Update the 'data' array with the 'total' value at the correct index
            $data[$damage]['data'][$nameIndex] = ($data[$damage]['data'][$nameIndex] ?? 0) + $total;
        }

        // Reindex the array to start from index 0
        $data = array_values($data);

        $result['data'] = $data;
        $result['xaxis'] = $nameValues;

        return $result;
    }

    public function tireCauseDamageInjury(Request $request)
    {
        $current_year = date('Y');
        $company = auth()->user()->company;
        $date_range1 = range($current_year, $current_year + 3);
        $date_range2 = range($current_year, $current_year - 3);
        $date_range = array_merge($date_range1, $date_range2);
        $date_range = array_unique($date_range);
        asort($date_range);
        $tahun = $request->query('tahun');
        $name = $request->query('site') ?? auth()->user()->site->name;
        $model_type = $request->query('model_type');
        $brand_tire = $request->query('brand_tire');
        $type_pattern = $request->query('type_pattern');
        $tire_pattern = $request->query('tire_pattern');
        $tire_size = $request->query('tire_size');
        $month = $request->query('month');
        $week = $request->query('week');


        $data['damage'] = [];
        $data['value'] = [];
        $data['max'] = 0;
        // foreach ($site as $key => $item) {
        // $tire = TireDamage::select('tire_damages.damage')
        $tire = TireDamage::select('tire_damages.cause')
            ->selectRaw('COUNT(tire_damages.cause) as total')
            // ->selectRaw('COUNT(tire_damages.damage) as total')

            ->join('history_tire_movements', 'history_tire_movements.tire_damage_id', '=', 'tire_damages.id')
            ->join('tires', 'tires.serial_number', '=', 'history_tire_movements.tire')
            ->join('tire_sizes', 'tire_sizes.id', '=', 'tires.tire_size_id')
            ->join('tire_patterns', 'tire_patterns.id', '=', 'tire_sizes.tire_pattern_id')
            ->join('tire_manufactures', 'tire_manufactures.id', '=', 'tire_patterns.tire_manufacture_id');

        $tire = $tire->whereIn('history_tire_movements.status', ['REPAIR', 'SCRAP']);
        $tire = $tire->where('history_tire_movements.company_id', $company->id);

        // dd($tire->get());

        if ($name) {
            $tire = $tire->join('sites', 'tires.site_id', '=', 'sites.id')->where('sites.name', $name);
        }
        if ($tahun) {
            if ($month) {
                if ($week) {
                    $tire = $tire->whereRaw("EXTRACT(week from history_tire_movements.start_date) = $week");
                } else {
                    $tire = $tire->whereMonth('history_tire_movements.start_date', $month);
                }
            } else {
                $tire = $tire->whereYear('history_tire_movements.start_date', $tahun);
            }
        }


        if ($tire_size) {
            $tire = $tire->where('tire_sizes.sizes', $tire_size);
        }
        if ($type_pattern) {
            $tire = $tire->where('tire_patterns.type_pattern', $type_pattern);
        }
        if ($tire_pattern) {
            $tire = $tire->where('tire_patterns.pattern', $tire_pattern);
        }
        if ($brand_tire) {
            $tire = $tire->where('tire_manufactures.name', $brand_tire);
        }


        $tire = $tire->groupBy("tire_damages.cause")->get();
        $data = [];
        foreach ($tire as $item) {
            $data['data'][] = $item->total;
            $data['xaxis'][] = $item->cause;
        }

        return $data;
    }

    public function brandUsage(Request $request)
    {
        $current_year = date('Y');
        $date_range1 = range($current_year, $current_year + 3);
        $date_range2 = range($current_year, $current_year - 3);
        $date_range = array_merge($date_range1, $date_range2);
        $date_range = array_unique($date_range);
        asort($date_range);
        $tahun = $request->query('tahun');
        if (Gate::any(['isSuperAdmin', 'isViewer', 'isManager'])) {
            $name = $request->query('site');
        } else {
            $name = $request->query('site') ?? auth()->user()->site->name;
        }
        $model_type = $request->query('model_type');
        $brand_tire = $request->query('brand_tire');
        $tire_size = $request->query('tire_size');
        $month = $request->query('month');
        $week = $request->query('week');
        $type_pattern = $request->query('type_pattern');
        $tire_pattern = $request->query('tire_pattern');
        $ranges_week = [
            1 => [1, 7],
            2 => [8, 14],
            3 => [15, 21],
        ];
        $tire = Tire::select('tire_manufactures.name as x')
            ->selectRaw('COUNT(tire_manufactures.name) y')
            ->join('tire_sizes', 'tires.tire_size_id', '=', 'tire_sizes.id')
            ->join('tire_patterns', 'tire_sizes.tire_pattern_id', '=', 'tire_patterns.id')
            ->join('tire_manufactures', 'tire_patterns.tire_manufacture_id', '=', 'tire_manufactures.id')
            ->leftJoin(DB::raw("(select max(id) as id, tire_serial_number from history_tire_movements group by tire_serial_number) as sl"), function ($q) {
                $q->on('sl.tire_serial_number', '=', 'tires.serial_number');
            });

        $tire = $tire->leftJoin('history_tire_movements', 'sl.id', '=', 'history_tire_movements.id');
        $tire = $tire->where('tires.tire_status_id', 1);
        $tire = $tire->whereNull('tires.deleted_at');
        if ($type_pattern) {
            $tire = $tire->where('tire_patterns.type_pattern', $type_pattern);
        }
        if ($tire_pattern) {
            $tire = $tire->where('tire_patterns.pattern', $tire_pattern);
        }
        if ($tire_size) {
            $tire = $tire->where('tire_sizes.size', $tire_size);
        }
        if ($tahun) {
            if ($month) {
                if ($week) {
                    $tire = $tire->whereBetween('history_tire_movements.start_date', ["$tahun-$month-{$ranges_week[$week][0]}", "$tahun-$month-{$ranges_week[$week][1]}"]);
                } else {
                    $tire = $tire->whereMonth('history_tire_movements.start_date', $month);
                }
            } else {
                $tire = $tire->whereYear('history_tire_movements.start_date', $tahun);
            }
        }
        // if ($tahun) {
        //     $tire = $tire->whereYear('history_tire_movements.start_date', $tahun);
        //     if ($month) {
        //         $tire = $tire->whereMonth('history_tire_movements.start_date', $month);
        //     }
        // }
        if ($name) {
            $tire = $tire->whereHas('site', function ($q) use ($name) {
                $q->where('name', $name);
            });
        }
        // if ($brand_tire) {
        //     $q->where('tire_manufactures.name', $brand_tire);
        // }

        $tire = $tire
            ->groupBy('tire_manufactures.name')
            ->orderBy('y', 'desc')
            ->get()
            ->toArray();
        return $tire;
    }

    public function tireLifetimeAverageKM(Request $request)
    {
        $company = auth()->user()->company;
        $tahun = $request->query('tahun');
        $name = $request->query('site') ?? auth()->user()->site->name;
        $model_type = $request->query('model_type');
        $brand_tire = $request->query('brand_tire');
        $type_pattern = $request->query('type_pattern');
        $tire_pattern = $request->query('tire_pattern');
        $tire_size = $request->query('tire_size');
        $month = $request->query('month');
        $week = $request->query('week');

        $site = Site::where("company_id", $company->id)->get();

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

        $data['type_pattern'] = [];
        $data['brand_size'] = [];
        $data['value'] = [];
        $data['max'] = 0;
        // foreach ($site as $key => $item) {
        $tire = Tire::select(
            'tire_patterns.type_pattern',
            'tire_manufactures.name',
            'tire_sizes.size',
            'tire_patterns.pattern',
            DB::raw('round(AVG(tires.lifetime_km ),1) as avg_lifetime_km'),
            DB::raw('round(AVG(tires.lifetime_km / (tire_sizes.otd - tires.rtd)), 1) as avg_km_per_mm'),
            DB::raw('round(AVG(tire_sizes.otd - tires.rtd), 1) as avg_tur')
        );
        $tire = $tire->leftJoin('tire_sizes', 'tires.tire_size_id', '=', 'tire_sizes.id');
        $tire = $tire->leftJoin('tire_patterns', 'tire_sizes.tire_pattern_id', '=', 'tire_patterns.id');
        $tire = $tire->leftJoin('tire_manufactures', 'tire_patterns.tire_manufacture_id', '=', 'tire_manufactures.id');
        $tire = $tire->leftJoin(DB::raw("(select max(id) as id, tire from history_tire_movements group by tire) as sl"), function ($q) {
            $q->on('sl.tire', '=', 'tires.serial_number');
        });
        $tire = $tire->leftJoin('history_tire_movements', 'sl.id', '=', 'history_tire_movements.id');
        if ($name) {
            $tire = $tire->whereHas('site', function ($q) use ($name) {
                $q->where('name', $name);
            });
        }
        $tire = $tire->whereIn("tires.id", DB::table('tire_runnings')->select("tire_id")->where("company_id", auth()->user()->company_id));
        $tire = $tire->where('lifetime_km', '>', 0);

        if ($tahun) {
            if ($month) {
                if ($week) {
                    $tire = $tire->whereBetween('history_tire_movements.start_date', ["$tahun-$month-{$ranges[$week][0]}", "$tahun-$month-{$ranges[$week][1]}"]);
                } else {
                    $tire = $tire->whereMonth('history_tire_movements.start_date', $month);
                }
            } else {
                $tire = $tire->whereYear('history_tire_movements.start_date', $tahun);
            }
        }

        $tire = $tire->whereHas('tire_size', function ($q) use ($brand_tire, $type_pattern, $tire_size) {
            if ($tire_size) {
                $q->where('size', $tire_size);
            }
            $q->whereHas("tire_pattern", function ($q) use ($brand_tire, $type_pattern) {
                if ($type_pattern) {
                    $q->where('type_pattern', $type_pattern);
                }
                if ($brand_tire) {
                    $q->whereHas("manufacture", function ($q) use ($brand_tire) {
                        $q->where('name', $brand_tire);
                    });
                }
            });
        });

        $tire = $tire
            ->groupBy('tire_patterns.type_pattern', 'tire_sizes.size', 'tire_manufactures.name', 'tire_patterns.pattern')
            ->orderBy('tire_patterns.type_pattern', 'ASC')
            ->get();
        $returning = [];
        $returning["value"][0]["name"] = "KM";
        $returning["value"][0]["type"] = "bar";
        $returning["value"][1]["name"] = "TUR";
        $returning["value"][1]["type"] = "line";
        $returning["value"][2]["name"] = "KM/MM";
        $returning["value"][2]["type"] = "bar";

        foreach ($tire as $key => $item) {
            $returning["value"][0]["data"][] = $item->avg_lifetime_km;
            $returning["value"][1]["data"][] = $item->avg_tur;
            $returning["value"][2]["data"][] = $item->avg_km_per_mm;
            $returning["xaxis"][] = "$item->size-$item->name-$item->pattern";
        }

        $tire = $tire->map(function ($tire) {
            return [
                'type_pattern' => $tire->type_pattern,
                'size' => $tire->size,
            ];
        });
        // dd($returning);
        return $returning;
    }

    public function tireLifetimeAverageHM(Request $request)
    {
        $company = auth()->user()->company;
        $tahun = $request->query('tahun');
        $name = $request->query('site') ?? auth()->user()->site->name;
        $model_type = $request->query('model_type');
        $brand_tire = $request->query('brand_tire');
        $type_pattern = $request->query('type_pattern');
        $tire_pattern = $request->query('tire_pattern');
        $tire_size = $request->query('tire_size');
        $month = $request->query('month');
        $week = $request->query('week');

        $site = Site::where("company_id", $company->id)->get();

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

        $data['type_pattern'] = [];
        $data['brand_size'] = [];
        $data['value'] = [];
        $data['max'] = 0;
        // foreach ($site as $key => $item) {
        $tire = Tire::select(
            'tire_patterns.type_pattern',
            'tire_manufactures.name',
            'tire_sizes.size',
            'tire_patterns.pattern',
            DB::raw('round(AVG(tires.lifetime_hm ),1) as avg_lifetime_hm'),
            DB::raw('round(AVG(tires.lifetime_hm / (tire_sizes.otd - tires.rtd)), 1) as avg_km_per_mm'),
            DB::raw('round(AVG(tire_sizes.otd - tires.rtd), 1) as avg_tur')
        );
        $tire = $tire->leftJoin('tire_sizes', 'tires.tire_size_id', '=', 'tire_sizes.id');
        $tire = $tire->leftJoin('tire_patterns', 'tire_sizes.tire_pattern_id', '=', 'tire_patterns.id');
        $tire = $tire->leftJoin('tire_manufactures', 'tire_patterns.tire_manufacture_id', '=', 'tire_manufactures.id');
        $tire = $tire->leftJoin(DB::raw("(select max(id) as id, tire from history_tire_movements group by tire) as sl"), function ($q) {
            $q->on('sl.tire', '=', 'tires.serial_number');
        });
        $tire = $tire->leftJoin('history_tire_movements', 'sl.id', '=', 'history_tire_movements.id');
        if ($name) {
            $tire = $tire->whereHas('site', function ($q) use ($name) {
                $q->where('name', $name);
            });
        }
        $tire = $tire->whereIn("tires.id", DB::table('tire_runnings')->select("tire_id")->where("company_id", auth()->user()->company_id));
        $tire = $tire->where('lifetime_hm', '>', 0);

        if ($tahun) {
            if ($month) {
                if ($week) {
                    $tire = $tire->whereBetween('history_tire_movements.start_date', ["$tahun-$month-{$ranges[$week][0]}", "$tahun-$month-{$ranges[$week][1]}"]);
                } else {
                    $tire = $tire->whereMonth('history_tire_movements.start_date', $month);
                }
            } else {
                $tire = $tire->whereYear('history_tire_movements.start_date', $tahun);
            }
        }

        $tire = $tire->whereHas('tire_size', function ($q) use ($brand_tire, $type_pattern, $tire_size) {
            if ($tire_size) {
                $q->where('size', $tire_size);
            }
            $q->whereHas("tire_pattern", function ($q) use ($brand_tire, $type_pattern) {
                if ($type_pattern) {
                    $q->where('type_pattern', $type_pattern);
                }
                if ($brand_tire) {
                    $q->whereHas("manufacture", function ($q) use ($brand_tire) {
                        $q->where('name', $brand_tire);
                    });
                }
            });
        });

        $tire = $tire
            ->groupBy('tire_patterns.type_pattern', 'tire_sizes.size', 'tire_manufactures.name', 'tire_patterns.pattern')
            ->orderBy('tire_patterns.type_pattern', 'ASC')
            ->get();
        $returning = [];
        $returning["value"][0]["name"] = "HM";
        $returning["value"][0]["type"] = "bar";
        $returning["value"][1]["name"] = "TUR";
        $returning["value"][1]["type"] = "line";
        $returning["value"][2]["name"] = "HM/MM";
        $returning["value"][2]["type"] = "bar";

        foreach ($tire as $key => $item) {
            $returning["value"][0]["data"][] = $item->avg_lifetime_hm;
            $returning["value"][1]["data"][] = $item->avg_tur;
            $returning["value"][2]["data"][] = $item->avg_km_per_mm;
            $returning["xaxis"][] = "$item->size-$item->name-$item->pattern";
        }

        $tire = $tire->map(function ($tire) {
            return [
                'type_pattern' => $tire->type_pattern,
                'size' => $tire->size,
            ];
        });
        return $returning;
    }

    //SCRAP
    public function tireLifetimeAverageScrapKM(Request $request)
    {
        $company = auth()->user()->company;
        $tahun = $request->query('tahun');
        $name = $request->query('site') ?? auth()->user()->site->name;
        $model_type = $request->query('model_type');
        $brand_tire = $request->query('brand_tire');
        $type_pattern = $request->query('type_pattern');
        $tire_pattern = $request->query('tire_pattern');
        $tire_size = $request->query('tire_size');
        $month = $request->query('month');
        $week = $request->query('week');

        $site = Site::where("company_id", $company->id)->get();

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

        $data['type_pattern'] = [];
        $data['brand_size'] = [];
        $data['value'] = [];
        $data['max'] = 0;
        // foreach ($site as $key => $item) {
        $tire = Tire::select(
            'tire_patterns.type_pattern',
            'tire_manufactures.name',
            'tire_sizes.size',
            'tire_patterns.pattern',
            DB::raw('round(AVG(tires.lifetime_km ),1) as avg_lifetime_km'),
            DB::raw('round(AVG(tires.lifetime_km / (tire_sizes.otd - tires.rtd)), 1) as avg_km_per_mm'),
            DB::raw('round(AVG(tire_sizes.otd - tires.rtd), 1) as avg_tur')
        );
        $tire = $tire->leftJoin('tire_sizes', 'tires.tire_size_id', '=', 'tire_sizes.id');
        $tire = $tire->leftJoin('tire_patterns', 'tire_sizes.tire_pattern_id', '=', 'tire_patterns.id');
        $tire = $tire->leftJoin('tire_manufactures', 'tire_patterns.tire_manufacture_id', '=', 'tire_manufactures.id');
        $tire = $tire->leftJoin(DB::raw("(select max(id) as id, tire from history_tire_movements group by tire) as sl"), function ($q) {
            $q->on('sl.tire', '=', 'tires.serial_number');
        });
        $tire = $tire->leftJoin('history_tire_movements', 'sl.id', '=', 'history_tire_movements.id');

        $tire = $tire->whereHas('tire_status', function ($q) {
            $q->where('status', 'SCRAP');
        });
        $tire = $tire->whereHas('site', function ($q) {
            $q->where('company_id', auth()->user()->company_id);
        });
        $tire = $tire->where('lifetime_km', '>', 0);

        if ($tahun) {
            if ($month) {
                if ($week) {
                    $tire = $tire->whereBetween('history_tire_movements.start_date', ["$tahun-$month-{$ranges[$week][0]}", "$tahun-$month-{$ranges[$week][1]}"]);
                } else {
                    $tire = $tire->whereMonth('history_tire_movements.start_date', $month);
                }
            } else {
                $tire = $tire->whereYear('history_tire_movements.start_date', $tahun);
            }
        }

        $tire = $tire->whereHas('tire_size', function ($q) use ($brand_tire, $type_pattern, $tire_size) {
            if ($tire_size) {
                $q->where('size', $tire_size);
            }
            $q->whereHas("tire_pattern", function ($q) use ($brand_tire, $type_pattern) {
                if ($type_pattern) {
                    $q->where('type_pattern', $type_pattern);
                }
                if ($brand_tire) {
                    $q->whereHas("manufacture", function ($q) use ($brand_tire) {
                        $q->where('name', $brand_tire);
                    });
                }
            });
        });

        $tire = $tire
            ->groupBy('tire_patterns.type_pattern', 'tire_sizes.size', 'tire_manufactures.name', 'tire_patterns.pattern')
            ->orderBy('tire_patterns.type_pattern', 'ASC')
            ->get();

        $returning = [];
        $returning["value"][0]["name"] = "KM";
        $returning["value"][0]["type"] = "bar";
        $returning["value"][1]["name"] = "TUR";
        $returning["value"][1]["type"] = "line";
        $returning["value"][2]["name"] = "KM/MM";
        $returning["value"][2]["type"] = "bar";

        foreach ($tire as $key => $item) {
            $returning["value"][0]["data"][] = $item->avg_lifetime_km;
            $returning["value"][1]["data"][] = $item->avg_tur;
            $returning["value"][2]["data"][] = $item->avg_km_per_mm;
            $returning["xaxis"][] = "$item->size-$item->name-$item->pattern";
        }

        $tire = $tire->map(function ($tire) {
            return [
                'type_pattern' => $tire->type_pattern,
                'size' => $tire->size,
            ];
        });
        return $returning;
    }

    public function tireLifetimeAverageScrapHM(Request $request)
    {
        $company = auth()->user()->company;
        $tahun = $request->query('tahun');
        $name = $request->query('site') ?? auth()->user()->site->name;
        $model_type = $request->query('model_type');
        $brand_tire = $request->query('brand_tire');
        $type_pattern = $request->query('type_pattern');
        $tire_pattern = $request->query('tire_pattern');
        $tire_size = $request->query('tire_size');
        $month = $request->query('month');
        $week = $request->query('week');

        $site = Site::where("company_id", $company->id)->get();

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

        $data['type_pattern'] = [];
        $data['brand_size'] = [];
        $data['value'] = [];
        $data['max'] = 0;
        // foreach ($site as $key => $item) {
        $tire = Tire::select(
            'tire_patterns.type_pattern',
            'tire_manufactures.name',
            'tire_sizes.size',
            'tire_patterns.pattern',
            DB::raw('round(AVG(tires.lifetime_hm ),1) as avg_lifetime_hm'),
            DB::raw('round(AVG(tires.lifetime_hm / (tire_sizes.otd - tires.rtd)), 1) as avg_km_per_mm'),
            DB::raw('round(AVG(tire_sizes.otd - tires.rtd), 1) as avg_tur')
        );
        $tire = $tire->leftJoin('tire_sizes', 'tires.tire_size_id', '=', 'tire_sizes.id');
        $tire = $tire->leftJoin('tire_patterns', 'tire_sizes.tire_pattern_id', '=', 'tire_patterns.id');
        $tire = $tire->leftJoin('tire_manufactures', 'tire_patterns.tire_manufacture_id', '=', 'tire_manufactures.id');
        $tire = $tire->leftJoin(DB::raw("(select max(id) as id, tire from history_tire_movements group by tire) as sl"), function ($q) {
            $q->on('sl.tire', '=', 'tires.serial_number');
        });
        $tire = $tire->leftJoin('history_tire_movements', 'sl.id', '=', 'history_tire_movements.id');
        if ($name) {
            $tire = $tire->whereHas('site', function ($q) use ($name) {
                $q->where('name', $name);
            });
        }
        $tire = $tire->whereHas('tire_status', function ($q) {
            $q->where('status', 'SCRAP');
        });
        $tire = $tire->whereHas('site', function ($q) {
            $q->where('company_id', auth()->user()->company_id);
        });
        $tire = $tire->where('lifetime_hm', '>', 0);

        if ($tahun) {
            if ($month) {
                if ($week) {
                    $tire = $tire->whereBetween('history_tire_movements.start_date', ["$tahun-$month-{$ranges[$week][0]}", "$tahun-$month-{$ranges[$week][1]}"]);
                } else {
                    $tire = $tire->whereMonth('history_tire_movements.start_date', $month);
                }
            } else {
                $tire = $tire->whereYear('history_tire_movements.start_date', $tahun);
            }
        }

        $tire = $tire->whereHas('tire_size', function ($q) use ($brand_tire, $type_pattern, $tire_size) {
            if ($tire_size) {
                $q->where('size', $tire_size);
            }
            $q->whereHas("tire_pattern", function ($q) use ($brand_tire, $type_pattern) {
                if ($type_pattern) {
                    $q->where('type_pattern', $type_pattern);
                }
                if ($brand_tire) {
                    $q->whereHas("manufacture", function ($q) use ($brand_tire) {
                        $q->where('name', $brand_tire);
                    });
                }
            });
        });

        $tire = $tire
            ->groupBy('tire_patterns.type_pattern', 'tire_sizes.size', 'tire_manufactures.name', 'tire_patterns.pattern')
            ->orderBy('tire_patterns.type_pattern', 'ASC')
            ->get();

        $returning = [];
        $returning["value"][0]["name"] = "HM";
        $returning["value"][0]["type"] = "bar";
        $returning["value"][1]["name"] = "TUR";
        $returning["value"][1]["type"] = "line";
        $returning["value"][2]["name"] = "HM/MM";
        $returning["value"][2]["type"] = "bar";

        foreach ($tire as $key => $item) {
            $returning["value"][0]["data"][] = $item->avg_lifetime_hm;
            $returning["value"][1]["data"][] = $item->avg_tur;
            $returning["value"][2]["data"][] = $item->avg_km_per_mm;
            $returning["xaxis"][] = "$item->size-$item->name-$item->pattern";
        }

        $tire = $tire->map(function ($tire) {
            return [
                'type_pattern' => $tire->type_pattern,
                'size' => $tire->size,
            ];
        });
        return $returning;
    }

    // AKM

    public function tireFitment(Request $request)
    {
        function getMonthsInRange($from = null, $to = null)
        {
            $today = Carbon::now(); // Current date
            // If $to is not provided, set it to the current date
            $to = $to ? Carbon::parse($to) : Carbon::parse("{$today->format('Y')}-12-01");

            // If $from is not provided, set it to six months ago
            $from = $from ? Carbon::parse($from) : Carbon::parse("{$today->format('Y')}-01-01");

            // Ensure $from is not greater than $to
            if ($from->gt($to)) {
                throw new InvalidArgumentException('$from date must be less than or equal to $to date');
            }
            // Calculate the number of months in the range
            $totalMonths = $from->diffInMonths($to);

            // Throw an exception if total months is greater than 12
            if ($totalMonths > 12) {
                throw new InvalidArgumentException('The total number of months in the range must not exceed 12.');
            }


            $months = [];
            while ($from->format("Y-m") <= $to->format("Y-m")) {
                // Format the date as "Y-Mon"
                $formattedDate = $from->format("M");
                $months[] = $formattedDate;

                // Move to the next month
                $from->addMonth();
            }
            return $months;
        }

        $current_year = date('Y');
        $date_range1 = range($current_year, $current_year + 3);
        $date_range2 = range($current_year, $current_year - 3);
        $date_range = array_merge($date_range1, $date_range2);
        $date_range = array_unique($date_range);
        asort($date_range);
        $tahun = $request->query('tahun');
        if (Gate::any(['isSuperAdmin', 'isViewer', 'isManager'])) {
            $site = $request->query('site');
        } else {
            $site = $request->query('site') ?? auth()->user()->site->name;
        }
        $model_type = $request->query('model_type');
        $from = $request->query('from') ?? null;
        $to = $request->query('to');
        $brand_tire = $request->query('brand_tire');
        $tire_size = $request->query('tire_size');
        $tire_pattern = $request->query('tire_pattern');
        $type_pattern = $request->query('type_pattern');
        $month = $request->query('month');
        $week = $request->query('week');

        $company = auth()->user()->company;

        $ranges = getMonthsInRange($from, $to);


        $tire_status = ['NEW', 'SPARE', 'REPAIR', 'ROTATION'];

        foreach ($tire_status as $key => $status) {
            // $history = Tire::leftJoin(DB::raw("(select max(id) as id, tire from history_tire_movements group by tire) as sl"), function ($q) {
            //     $q->on('sl.tire', '=', 'tires.serial_number');
            // });
            // $history = $history->leftJoin('history_tire_movements', 'sl.id', '=', 'history_tire_movements.id');
            $history = Tire::where('tires.company_id', $company->id)->join('history_tire_movements', function ($join) use ($status, $company) {
                $join->on('tires.serial_number', '=', 'history_tire_movements.tire')
                    ->where('history_tire_movements.process', '=', 'INSTALL')
                    ->where('history_tire_movements.company_id', $company->id)
                    ->where('history_tire_movements.status', '=', $status);
            });


            // $history = $history->whereRaw("DATE_FORMAT(history_tire_movements.start_date, '%Y-%m') BETWEEN ? AND ?", [Carbon::parse(reset($ranges))->format("Y-m"), Carbon::parse(end($ranges))->format("Y-m")]);

            if ($tahun) {

                $history = $history->whereYear('history_tire_movements.start_date', $tahun);
            }


            $history = $history->whereHas('tire_size', function ($q) use ($brand_tire, $tire_pattern, $type_pattern) {
                $q->whereHas('tire_pattern', function ($q) use ($brand_tire, $tire_pattern, $type_pattern) {
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



            if ($site) {
                $history = $history->whereHas('site', function ($q) use ($site) {
                    $q->where('name', $site);
                });
            }

            $history = $history
                ->get()
                ->map(function ($tire) use ($ranges, $tahun) {
                    $start_date = $tire->start_date;
                    foreach ($ranges as $key => $breakpoint) {
                        if (Carbon::parse("$tahun $breakpoint")->format('Y-m') == Carbon::parse($start_date)->format('Y-m')) { // check for year and month equal
                            $tire->range = $key;
                            break;
                        }
                    }

                    return $tire;
                })
                ->mapToGroups(function ($tire, $key) {
                    return [$tire->range => $tire];
                })
                ->map(function ($group) {
                    return count($group);
                })
                ->toArray();

            $d = [];
            foreach ($ranges as $k => $value) {
                $d['name'] = $status;
                $d['type'] = 'line';
                $d['data'][] = $history[$k] ?? 0;
            }
            $data['value'][] = $d;
        }


        $max = 0;
        foreach ($data['value'] as $key => $value) {
            if ($max < max($value['data'])) {
                $max = max($value['data']);
            }
        }

        $bulat = pow(10, strlen($max) - 1);

        $data['max'] = ceil($max / $bulat) * $bulat;
        $data['status'] = $tire_status;
        $data['xaxis'] = $ranges;

        return $data;
    }

    public function tireFitmentMonth(Request $request)
    {
        $year = $request->query('year') ?? Carbon::now()->format("Y");
        if (Gate::any(['isSuperAdmin', 'isViewer', 'isManager'])) {
            $site = $request->query('site');
        } else {
            $site = $request->query('site') ?? auth()->user()->site->name;
        }
        $model_type = $request->query('model_type');
        $brand_tire = $request->query('brand_tire');
        $tire_size = $request->query('tire_size');
        $tire_pattern = $request->query('tire_pattern');
        $type_pattern = $request->query('type_pattern');
        $axisX = $request->query('axisX') ?? 'week';
        $month = $request->query('month') ?? Carbon::now()->format('m');
        $firstweek = Carbon::parse("$year-$month-1")->weekOfYear;
        $lastweek = Carbon::parse("$year-$month-1")->endOfMonth()->weekOfYear;

        $company = auth()->user()->company;

        $tire_status = ['NEW', 'SPARE', 'REPAIR', 'ROTATION'];

        $history = HistoryTireMovement::select("history_tire_movements.status")->selectRaw("EXTRACT($axisX from start_date) as $axisX")->selectRaw("count(*) as total")
            ->join('tires', 'tires.serial_number', '=', 'history_tire_movements.tire')
            ->where('history_tire_movements.process', '=', 'INSTALL')
            ->where('tires.company_id', $company->id)
            ->whereBetween(HistoryTireMovement::raw('EXTRACT(WEEK from history_tire_movements.start_date)'), [$firstweek, $lastweek]);

        $history = $history->whereHas('tire_number.tire_size', function ($q) use ($brand_tire, $tire_pattern, $type_pattern, $tire_size) {
            $q->whereHas('tire_pattern', function ($q) use ($brand_tire, $tire_pattern, $type_pattern, $tire_size) {
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
                if ($tire_size) {
                    $q->where('size', $tire_size);
                }
            });
        });

        if ($site) {
            $history = $history->whereHas('tire_number.site', function ($q) use ($site) {
                $q->where('name', $site);
            });
        }
        $history = $history->groupBy('history_tire_movements.status', $axisX);

        $result = [];
        $week = [];
        $carbonMonth = Carbon::parse("$year-$month-1");
        $carbonMonthLast = Carbon::parse("$year-$month-1");
        // dd($history->dd(), $carbonMonth, $carbonMonthLast);

        // Initialize data array with default values
        foreach ($tire_status as $status) {
            $result["value"][] = [
                'name' => $status,
                'type' => $axisX == 'week' ? "bar" : 'line',
                'data' => $axisX == 'week' ? array_fill(0, $lastweek - $firstweek + 1, 0) : array_fill(0, $carbonMonth->daysInMonth, 0),
            ];
        }


        // Process each entry in the original data
        foreach ($history->get() as $entry) {
            // Convert week and year to a Carbon instance
            if ($axisX == 'week')
                $carbonDate = Carbon::now()->setISODate(2023, $entry[$axisX]);
            if ($axisX == 'day')
                $carbonDate = Carbon::parse("$year-$month-$entry[$axisX]");

            // Find the index of the status in the result array
            $index = array_search($entry['status'], $tire_status);
            // Update the corresponding data value
            if ($axisX == 'week')
                $result["value"][$index]['data'][$carbonDate->weekOfYear % $carbonMonth->weekOfYear] += $entry['total'];
            if ($axisX == 'day')
                $result["value"][$index]['data'][$carbonDate->day % $carbonMonth->daysInMonth] += $entry['total'];
        }

        $ranges = [];
        if ($axisX == 'week')
            for ($i = $firstweek; $i <= $lastweek; $i++) {
                $ranges[] = "week $i";
            }
        if ($axisX == 'day')
            for ($i = 1; $i <= $carbonMonth->daysInMonth; $i++) {
                $ranges[] = "$i";
            }


        $max = 0;
        foreach ($result['value'] as $key => $value) {
            if ($max < max($value['data'])) {
                $max = max($value['data']);
            }
        }

        $bulat = pow(10, strlen($max) - 1);

        $result['max'] = ceil($max / $bulat) * $bulat;
        $result['status'] = $tire_status;
        $result['xaxis'] = $ranges;

        return $result;
    }
    public function tireFitmentWeek(Request $request)
    {
        $year = $request->query('year') ?? Carbon::now()->format("Y");
        if (Gate::any(['isSuperAdmin', 'isViewer', 'isManager'])) {
            $site = $request->query('site');
        } else {
            $site = $request->query('site') ?? auth()->user()->site->name;
        }
        $model_type = $request->query('model_type');
        $brand_tire = $request->query('brand_tire');
        $tire_size = $request->query('tire_size');
        $tire_pattern = $request->query('tire_pattern');
        $type_pattern = $request->query('type_pattern');
        $week = $request->query('week') ?? Carbon::now()->weekOfYear;

        $company = auth()->user()->company;

        $tire_status = ['NEW', 'SPARE', 'REPAIR', 'ROTATION'];
        $hari = ["Senin", "Selasa", "Rabu", "Kamis", "Jum'at", "Sabtu", "Minggu"];

        $history = HistoryTireMovement::select("history_tire_movements.status")->selectRaw("DAYOFWEEK(start_date) as day")->selectRaw("count(*) as total")
            ->join('tires', 'tires.serial_number', '=', 'history_tire_movements.tire')
            ->where('history_tire_movements.process', '=', 'INSTALL')
            ->where('tires.company_id', $company->id)
            ->where(HistoryTireMovement::raw('EXTRACT(WEEK from history_tire_movements.start_date)'), $week);

        $history = $history->whereHas('tire_number.tire_size', function ($q) use ($brand_tire, $tire_pattern, $type_pattern, $tire_size) {
            $q->whereHas('tire_pattern', function ($q) use ($brand_tire, $tire_pattern, $type_pattern, $tire_size) {
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
                if ($tire_size) {
                    $q->where('size', $tire_size);
                }
            });
        });

        if ($site) {
            $history = $history->whereHas('tire_number.site', function ($q) use ($site) {
                $q->where('name', $site);
            });
        }

        $history = $history->groupBy('history_tire_movements.status', 'day');

        $result = [];
        // dd($history->dd(), $carbonMonth, $carbonMonthLast);

        // Initialize data array with default values
        foreach ($tire_status as $status) {
            $result["value"][] = [
                'name' => $status,
                'type' => "bar",
                'data' => array_fill(0, 7, 0),
            ];
        }

        // Process each entry in the original data
        foreach ($history->get() as $entry) {
            // Convert week and year to a Carbon instance

            // Find the index of the status in the result array
            $index = array_search($entry['status'], $tire_status);

            // Update the corresponding data value +5 untuk membuat hari senin jadi awal minggu
            $result["value"][$index]['data'][($entry->day + 5) % 7] += $entry['total'];
        }

        $weeks = [];
        for ($i = 0; $i <= 6; $i++) {
            $weeks[] = $hari[$i];
        }

        $result['status'] = $tire_status;
        $result['xaxis'] = $weeks;

        return $result;
    }

    public function tireRemoved(Request $request)
    {
        function getMonthsInRange($from = null, $to = null)
        {
            $today = Carbon::now(); // Current date

            // If $to is not provided, set it to the current date
            $to = $to ? Carbon::parse($to) : Carbon::parse("{$today->format('Y')}-12-01");

            // If $from is not provided, set it to six months ago
            $from = $from ? Carbon::parse($from) : Carbon::parse("{$today->format('Y')}-01-01");

            // Ensure $from is not greater than $to
            if ($from->gt($to)) {
                throw new InvalidArgumentException('$from date must be less than or equal to $to date');
            }
            // Calculate the number of months in the range
            $totalMonths = $from->diffInMonths($to);

            // Throw an exception if total months is greater than 12
            if ($totalMonths > 12) {
                throw new InvalidArgumentException('The total number of months in the range must not exceed 12.');
            }


            $months = [];
            while ($from->format("Y-m") <= $to->format("Y-m")) {
                // Format the date as "Y-Mon"
                $formattedDate = $from->format("M");
                $months[] = $formattedDate;
                // Move to the next month
                $from->addMonth();
            }
            return $months;
        }

        $current_year = date('Y');
        $date_range1 = range($current_year, $current_year + 3);
        $date_range2 = range($current_year, $current_year - 3);
        $date_range = array_merge($date_range1, $date_range2);
        $date_range = array_unique($date_range);
        asort($date_range);
        $tahun = $request->query('tahun');
        if (Gate::any(['isSuperAdmin', 'isViewer', 'isManager'])) {
            $site = $request->query('site');
        } else {
            $site = $request->query('site') ?? auth()->user()->site->name;
        }
        $model_type = $request->query('model_type');
        $from = $request->query('from') ?? null;
        $to = $request->query('to');
        $brand_tire = $request->query('brand_tire');
        $tire_size = $request->query('tire_size');
        $tire_pattern = $request->query('tire_pattern');
        $type_pattern = $request->query('type_pattern');
        $month = $request->query('month');
        $week = $request->query('week');

        $company = auth()->user()->company;

        $ranges = getMonthsInRange($from, $to);

        $tire_status = ['SPARE', 'REPAIR', 'ROTATION', 'SCRAP'];

        foreach ($tire_status as $key => $status) {
            // $history = Tire::leftJoin(DB::raw("(select max(id) as id, tire from history_tire_movements group by tire) as sl"), function ($q) {
            //     $q->on('sl.tire', '=', 'tires.serial_number');
            // });
            // $history = $history->leftJoin('history_tire_movements', 'sl.id', '=', 'history_tire_movements.id');
            $history = Tire::where('tires.company_id', $company->id)->join('history_tire_movements', function ($join) use ($status) {
                $join->on('tires.serial_number', '=', 'history_tire_movements.tire')
                    ->where('history_tire_movements.process', '=', 'REMOVE')
                    ->where('history_tire_movements.status', '=', $status);
            });

            $history = $history->whereRaw("DATE_FORMAT(history_tire_movements.start_date, '%Y-%m') BETWEEN ? AND ?", [Carbon::parse(reset($ranges))->format("Y-m"), Carbon::parse(end($ranges))->format("Y-m")]);

            if ($tahun) {
                $history = $history->whereYear('history_tire_movements.start_date', $tahun);
            }

            $history = $history->whereHas('tire_size', function ($q) use ($brand_tire, $tire_pattern, $type_pattern) {
                $q->whereHas('tire_pattern', function ($q) use ($brand_tire, $tire_pattern, $type_pattern) {
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

            if ($site) {
                $history = $history->whereHas('site', function ($q) use ($site) {
                    $q->where('name', $site);
                });
            }

            $history = $history
                ->get()
                ->map(function ($tire) use ($ranges, $tahun) {
                    $start_date = $tire->start_date;

                    foreach ($ranges as $key => $breakpoint) {
                        if (Carbon::parse("$tahun $breakpoint")->format('Y-m') == Carbon::parse($start_date)->format('Y-m')) { // check for year and month equal
                            $tire->range = $key;
                            break;
                        }
                    }

                    return $tire;
                })
                ->mapToGroups(function ($tire, $key) {
                    return [$tire->range => $tire];
                })
                ->map(function ($group) {
                    return count($group);
                })
                ->toArray();
            $d = [];
            foreach ($ranges as $k => $value) {
                $d['name'] = $status;
                $d['type'] = 'line';
                $d['data'][] = $history[$k] ?? 0;
            }
            $data['value'][] = $d;
        }

        $max = 0;
        foreach ($data['value'] as $key => $value) {
            if ($max < max($value['data'])) {
                $max = max($value['data']);
            }
        }

        $bulat = pow(10, strlen($max) - 1) == 1 ? 10 : pow(10, strlen($max) - 1);

        $data['max'] = ceil($max / $bulat) * $bulat;
        $data['status'] = $tire_status;
        $data['xaxis'] = $ranges;

        return $data;
    }

    public function tireRemovedMonth(Request $request)
    {
        $year = $request->query('year') ?? Carbon::now()->format("Y");
        if (Gate::any(['isSuperAdmin', 'isViewer', 'isManager'])) {
            $site = $request->query('site');
        } else {
            $site = $request->query('site') ?? auth()->user()->site->name;
        }
        $model_type = $request->query('model_type');
        $brand_tire = $request->query('brand_tire');
        $tire_size = $request->query('tire_size');
        $tire_pattern = $request->query('tire_pattern');
        $type_pattern = $request->query('type_pattern');
        $axisX = $request->query('axisX') ?? 'week';
        $month = $request->query('month') ?? Carbon::now()->format('m');
        $firstweek = Carbon::parse("$year-$month-1")->weekOfYear;
        $lastweek = Carbon::parse("$year-$month-1")->endOfMonth()->weekOfYear;

        $company = auth()->user()->company;

        $tire_status = ['SPARE', 'REPAIR', 'ROTATION', 'SCRAP'];

        $history = HistoryTireMovement::select("history_tire_movements.status")->selectRaw("EXTRACT($axisX from start_date) as $axisX")->selectRaw("count(*) as total")
            ->join('tires', 'tires.serial_number', '=', 'history_tire_movements.tire')
            ->where('history_tire_movements.process', '=', 'REMOVE')
            ->where('tires.company_id', $company->id)
            ->whereBetween(HistoryTireMovement::raw('EXTRACT(WEEK from history_tire_movements.start_date)'), [$firstweek, $lastweek]);

        $history = $history->whereHas('tire_number.tire_size', function ($q) use ($brand_tire, $tire_pattern, $type_pattern, $tire_size) {
            $q->whereHas('tire_pattern', function ($q) use ($brand_tire, $tire_pattern, $type_pattern, $tire_size) {
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
                if ($tire_size) {
                    $q->where('size', $tire_size);
                }
            });
        });

        if ($site) {
            $history = $history->whereHas('tire_number.site', function ($q) use ($site) {
                $q->where('name', $site);
            });
        }
        $history = $history->groupBy('history_tire_movements.status', $axisX);

        $result = [];
        $week = [];
        $carbonMonth = Carbon::parse("$year-$month-1");
        $carbonMonthLast = Carbon::parse("$year-$month-1");
        // dd($history->dd(), $carbonMonth, $carbonMonthLast);

        // Initialize data array with default values
        foreach ($tire_status as $status) {
            $result["value"][] = [
                'name' => $status,
                'type' => $axisX == 'week' ? "bar" : 'line',
                'data' => $axisX == 'week' ? array_fill(0, $lastweek - $firstweek + 1, 0) : array_fill(0, $carbonMonth->daysInMonth, 0),
            ];
        }


        // Process each entry in the original data
        foreach ($history->get() as $entry) {
            // Convert week and year to a Carbon instance
            if ($axisX == 'week')
                $carbonDate = Carbon::now()->setISODate(2023, $entry[$axisX]);
            if ($axisX == 'day')
                $carbonDate = Carbon::parse("$year-$month-$entry[$axisX]");

            // Find the index of the status in the result array
            $index = array_search($entry['status'], $tire_status);
            // Update the corresponding data value
            if ($axisX == 'week')
                $result["value"][$index]['data'][$carbonDate->weekOfYear % $carbonMonth->weekOfYear] += $entry['total'];
            if ($axisX == 'day')
                $result["value"][$index]['data'][$carbonDate->day % $carbonMonth->daysInMonth] += $entry['total'];
        }

        $ranges = [];
        if ($axisX == 'week')
            for ($i = $firstweek; $i <= $lastweek; $i++) {
                $ranges[] = "week $i";
            }
        if ($axisX == 'day')
            for ($i = 1; $i <= $carbonMonth->daysInMonth; $i++) {
                $ranges[] = "$i";
            }


        $max = 0;
        foreach ($result['value'] as $key => $value) {
            if ($max < max($value['data'])) {
                $max = max($value['data']);
            }
        }

        $bulat = pow(10, strlen($max) - 1);

        $result['max'] = ceil($max / $bulat) * $bulat;
        $result['status'] = $tire_status;
        $result['xaxis'] = $ranges;

        return $result;
    }
    public function tireRemovedWeek(Request $request)
    {
        $year = $request->query('year') ?? Carbon::now()->format("Y");
        if (Gate::any(['isSuperAdmin', 'isViewer', 'isManager'])) {
            $site = $request->query('site');
        } else {
            $site = $request->query('site') ?? auth()->user()->site->name;
        }
        $model_type = $request->query('model_type');
        $brand_tire = $request->query('brand_tire');
        $tire_size = $request->query('tire_size');
        $tire_pattern = $request->query('tire_pattern');
        $type_pattern = $request->query('type_pattern');
        $week = $request->query('week') ?? Carbon::now()->weekOfYear;

        $company = auth()->user()->company;

        $tire_status = ['SPARE', 'REPAIR', 'ROTATION', 'SCRAP'];
        $hari = ["Senin", "Selasa", "Rabu", "Kamis", "Jum'at", "Sabtu", "Minggu"];

        $history = HistoryTireMovement::select("history_tire_movements.status")->selectRaw("DAYOFWEEK(start_date) as day")->selectRaw("count(*) as total")
            ->join('tires', 'tires.serial_number', '=', 'history_tire_movements.tire')
            ->where('history_tire_movements.process', '=', 'REMOVE')
            ->where('tires.company_id', $company->id)
            ->where(HistoryTireMovement::raw('EXTRACT(WEEK from history_tire_movements.start_date)'), $week);

        $history = $history->whereHas('tire_number.tire_size', function ($q) use ($brand_tire, $tire_pattern, $type_pattern, $tire_size) {
            $q->whereHas('tire_pattern', function ($q) use ($brand_tire, $tire_pattern, $type_pattern, $tire_size) {
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
                if ($tire_size) {
                    $q->where('size', $tire_size);
                }
            });
        });

        if ($site) {
            $history = $history->whereHas('tire_number.site', function ($q) use ($site) {
                $q->where('name', $site);
            });
        }

        $history = $history->groupBy('history_tire_movements.status', 'day');

        $result = [];
        // dd($history->dd(), $carbonMonth, $carbonMonthLast);

        // Initialize data array with default values
        foreach ($tire_status as $status) {
            $result["value"][] = [
                'name' => $status,
                'type' => "bar",
                'data' => array_fill(0, 7, 0),
            ];
        }

        // Process each entry in the original data
        foreach ($history->get() as $entry) {
            // Convert week and year to a Carbon instance

            // Find the index of the status in the result array
            $index = array_search($entry['status'], $tire_status);

            // Update the corresponding data value +5 untuk membuat hari senin jadi awal minggu
            $result["value"][$index]['data'][($entry->day + 5) % 7] += $entry['total'];
        }

        $weeks = [];
        for ($i = 0; $i <= 6; $i++) {
            $weeks[] = $hari[$i];
        }

        $result['status'] = $tire_status;
        $result['xaxis'] = $weeks;

        return $result;
    }
    public function tireNewMovement(Request $request)
    {
        $year = $request->query('tahun') ?? date('Y');
        $tireSize = $request->query('tire_size');

        // Base query to get monthly totals for each unit
        $query = HistoryTireMovement::select(
            'history_tire_movements.unit',
            DB::raw("DATE_FORMAT(history_tire_movements.start_date, '%Y-%m') as month"),
            DB::raw("COUNT(*) as total")
        )
            ->join('units', 'history_tire_movements.unit', '=', 'units.unit_number')
            ->join('unit_models', 'unit_models.id', '=', 'units.unit_model_id') // Join to unit_model table
            ->join('tire_sizes', 'tire_sizes.id', '=', 'unit_models.tire_size_id') // Join to tire_size for filtering
            ->whereYear('history_tire_movements.start_date', $year)
            ->where('history_tire_movements.process', 'INSTALL')
            ->where('history_tire_movements.status', 'NEW')
            ->where('history_tire_movements.company_id', auth()->user()->company->id);

        // Apply tire_size filter if specified
        if ($tireSize) {
            $query->where('tire_sizes.size', $tireSize);
        }

        // Execute the query with grouping by unit and month
        $tireMovements = $query->groupBy('history_tire_movements.unit', 'month')
            ->orderBy('month', 'ASC')
            ->get();


        // Prepare data structure for the chart
        $data = [];
        $units = $tireMovements->pluck('unit')->unique()->values()->all(); // Get unique units

        $months = [
            'January',
            'February',
            'March',
            'April',
            'May',
            'June',
            'July',
            'August',
            'September',
            'October',
            'November',
            'December'
        ];

        // Initialize data for each month
        $monthlyData = array_fill(0, 12, array_fill_keys($units, 0));

        // Populate data for each unit and month
        foreach ($tireMovements as $movement) {
            $unitId = $movement->unit;
            $monthIndex = date('n', strtotime($movement->month)) - 1;
            $total = $movement->total;

            // Set the total for the specific month and unit
            $monthlyData[$monthIndex][$unitId] = $total;
        }
        // Reformat data for ApexCharts (each month as a series)
        $series = [];
        foreach ($months as $index => $month) {
            $series[] = [
                'name' => $month,
                'data' => array_values($monthlyData[$index])
            ];
        }

        return [
            'data' => $series, // Series data with months as names
            'xaxis' => array_map(function ($unit) {
                return "$unit";
            }, $units) // Unit names for x-axis
        ];
    }

    public function leadTimeJob(Request $request)
    {
        $year = $request->query('tahun') ?? date('Y');
        
        // Base query to get total time (start_date - end_date) from history_tire_movements
        $queryHistory = HistoryTireMovement::select(
            DB::raw("DATE_FORMAT(history_tire_movements.start_date, '%Y-%m') as month"),
            DB::raw("SUM(TIMESTAMPDIFF(SECOND, history_tire_movements.start_date, history_tire_movements.end_date)) as total_time")
        )
        ->whereYear('history_tire_movements.start_date', $year)
        ->where('history_tire_movements.company_id', auth()->user()->company->id);
        
        // Base query to get total time from daily_activity
        $queryActivity = DailyActivity::select(
            DB::raw("DATE_FORMAT(daily_activities.start_date, '%Y-%m') as month"),
            DB::raw("SUM(TIMESTAMPDIFF(SECOND, daily_activities.start_date, daily_activities.end_date)) as total_time")
        )
        ->whereYear('daily_activities.start_date', $year)
        ->where('daily_activities.company_id', auth()->user()->company->id);
        
        // Base query to get total time from daily_monitoring
        $queryMonitoring = DailyInspect::select(
            DB::raw("DATE_FORMAT(daily_inspects.start_date, '%Y-%m') as month"),
            DB::raw("SUM(TIMESTAMPDIFF(SECOND, daily_inspects.start_date, daily_inspects.end_date)) as total_time")
        )
        ->whereYear('daily_inspects.start_date', $year)
        ->where('daily_inspects.company_id', auth()->user()->company->id);
        
        // Combine all queries and group by month
        $tireMovements = $queryHistory->groupBy('month')
            ->union($queryActivity->groupBy('month'))
            ->union($queryMonitoring->groupBy('month'))
            ->orderBy('month', 'ASC')
            ->get();
        
        // Prepare data structure for the chart
        $months = [
            'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December'
        ];
    
        $monthlyData = array_fill(0, 12, 0);  // Initialize data for each month
        $averageData = array_fill(0, 12, 0);  // Initialize average data for each month
    
        // Populate data for each month
        foreach ($tireMovements as $movement) {
            $monthIndex = date('n', strtotime($movement->month)) - 1;
            $totalTime = $movement->total_time;
    
            $monthlyData[$monthIndex] += $totalTime;
            // Calculate average time (in minutes)
            $averageData[$monthIndex] = $totalTime / 60;  // Convert to minutes
        }
    
        // Convert total time (in seconds) to minutes for chart
        $series = [
            [
                'name' => 'Total Time (minutes)',
                'data' => array_map(function ($time) {
                    return $time / 60; // Convert to minutes
                }, $monthlyData)
            ],
            [
                'name' => 'Average Time (minutes)',
                'data' => array_map(function ($time) {
                    return $time / 60; // Convert to minutes
                }, $averageData)
            ]
        ];
    
        return [
            'data' => $series,
            'xaxis' => $months // Month names for x-axis
        ];
    }    
}
