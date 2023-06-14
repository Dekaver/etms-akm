<?php

namespace App\Http\Controllers;

use App\Models\TireManufacture;
use App\Models\TirePattern;
use App\Models\TireSize;
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


        $company = auth()->user()->company;
        $tirepattern = TirePattern::with("manufacture")->where('company_id', $company->id)->get();
        $tire_patterns = TirePattern::select("pattern")->where('company_id', $company->id)->groupBy("pattern")->get();
        $tire_sizes = TireSize::select("size")->where('company_id', $company->id)->groupBy("size")->get();
        $tire_manufactures = TireManufacture::where('company_id', $company->id)->get();

        if ($request->ajax()) {
            $data = TireSize::where('company_id', $company->id);
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
}
