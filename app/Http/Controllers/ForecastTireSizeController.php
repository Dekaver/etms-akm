<?php

namespace App\Http\Controllers;

use App\Models\ForecastTireSize;
use App\Models\Size;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ForecastTireSizeController extends Controller
{
    public function index(Request $request)
    {
        $company = auth()->user()->company;
        $size = Size::where("company_id", auth()->user()->company->id)->get();
        if ($request->ajax()) {
            $data = ForecastTireSize::with('size')->where('company_id', $company->id)->orderBy('year', 'desc')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('tire_size', function ($row) {
                    return $row->size->name;
                })
                ->addColumn('year', function ($row) {
                    return $row->year;
                })
                ->addColumn('january', function ($row) {
                    return number_format($row->january, 0, ',', '.');
                })
                ->addColumn('february', function ($row) {
                    return number_format($row->february, 0, ',', '.');
                })
                ->addColumn('march', function ($row) {
                    return number_format($row->march, 0, ',', '.');
                })
                ->addColumn('april', function ($row) {
                    return number_format($row->april, 0, ',', '.');
                })
                ->addColumn('may', function ($row) {
                    return number_format($row->may, 0, ',', '.');
                })
                ->addColumn('june', function ($row) {
                    return number_format($row->june, 0, ',', '.');
                })
                ->addColumn('july', function ($row) {
                    return number_format($row->july, 0, ',', '.');
                })
                ->addColumn('august', function ($row) {
                    return number_format($row->august, 0, ',', '.');
                })
                ->addColumn('september', function ($row) {
                    return number_format($row->september, 0, ',', '.');
                })
                ->addColumn('october', function ($row) {
                    return number_format($row->october, 0, ',', '.');
                })
                ->addColumn('november', function ($row) {
                    return number_format($row->november, 0, ',', '.');
                })
                ->addColumn('december', function ($row) {
                    return number_format($row->december, 0, ',', '.');
                })
                ->addColumn('total_forecast', function ($row) {
                    return number_format($row->annual_forecast, 0, ',', '.');
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = "<a class='me-3 text-warning' href='#'
                                    data-bs-target='#form-modal' data-bs-toggle='modal' data-id='$row->id'>
                                    <img src='assets/img/icons/edit.svg' alt='img'>
                                </a>
                                <a class='confirm-text' href='javascript:void(0);' data-bs-toggle='modal'
                                    data-bs-target='#deleteModal' data-id='$row->id'
                                    data-action='" . route('forecast.destroy', $row->id) . "'
                                    data-message='Forecast for " . $row->year . "'>
                                    <img src='assets/img/icons/delete.svg' alt='img'>
                                </a>";
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view("admin.master.forecast.index", compact("size"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("admin.master.forecast.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $company = auth()->user()->company;
        // Bersihkan tanda koma untuk setiap input bulan
        $request->merge([
            'january' => str_replace(',', '', $request->january),
            'february' => str_replace(',', '', $request->february),
            'march' => str_replace(',', '', $request->march),
            'april' => str_replace(',', '', $request->april),
            'may' => str_replace(',', '', $request->may),
            'june' => str_replace(',', '', $request->june),
            'july' => str_replace(',', '', $request->july),
            'august' => str_replace(',', '', $request->august),
            'september' => str_replace(',', '', $request->september),
            'october' => str_replace(',', '', $request->october),
            'november' => str_replace(',', '', $request->november),
            'december' => str_replace(',', '', $request->december),
        ]);

        $request->validate([
            "tire_size_id" => "required",
            "year" => "required|integer",
            "january" => "required|numeric",
            "february" => "required|numeric",
            "march" => "required|numeric",
            "april" => "required|numeric",
            "may" => "required|numeric",
            "june" => "required|numeric",
            "july" => "required|numeric",
            "august" => "required|numeric",
            "september" => "required|numeric",
            "october" => "required|numeric",
            "november" => "required|numeric",
            "december" => "required|numeric",
        ]);

        ForecastTireSize::create([
            "company_id" => $company->id,
            "tire_size_id" => $request->tire_size_id,
            "year" => $request->year,
            "january" => $request->january,
            "february" => $request->february,
            "march" => $request->march,
            "april" => $request->april,
            "may" => $request->may,
            "june" => $request->june,
            "july" => $request->july,
            "august" => $request->august,
            "september" => $request->september,
            "october" => $request->october,
            "november" => $request->november,
            "december" => $request->december,
        ]);

        return redirect()->back()->with("success", "Forecast Created");
    }

    /**
     * Display the specified resource.
     */
    public function show(ForecastTireSize $forecastTireSize)
    {
        return view("admin.master.forecast.show", compact("forecastTireSize"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $forecastTireSize = ForecastTireSize::find($id);
        return $forecastTireSize;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->merge([
            'january' => str_replace(',', '', $request->january),
            'february' => str_replace(',', '', $request->february),
            'march' => str_replace(',', '', $request->march),
            'april' => str_replace(',', '', $request->april),
            'may' => str_replace(',', '', $request->may),
            'june' => str_replace(',', '', $request->june),
            'july' => str_replace(',', '', $request->july),
            'august' => str_replace(',', '', $request->august),
            'september' => str_replace(',', '', $request->september),
            'october' => str_replace(',', '', $request->october),
            'november' => str_replace(',', '', $request->november),
            'december' => str_replace(',', '', $request->december),
        ]);
        
        $request->validate([
            "tire_size_id" => "required",
            "year" => "required|integer",
            "january" => "required|numeric",
            "february" => "required|numeric",
            "march" => "required|numeric",
            "april" => "required|numeric",
            "may" => "required|numeric",
            "june" => "required|numeric",
            "july" => "required|numeric",
            "august" => "required|numeric",
            "september" => "required|numeric",
            "october" => "required|numeric",
            "november" => "required|numeric",
            "december" => "required|numeric",
        ]);

        $forecastTireSize = ForecastTireSize::find($id);
        $forecastTireSize->update([
            "tire_size_id" => $request->tire_size_id,
            "year" => $request->year,
            "january" => $request->january,
            "february" => $request->february,
            "march" => $request->march,
            "april" => $request->april,
            "may" => $request->may,
            "june" => $request->june,
            "july" => $request->july,
            "august" => $request->august,
            "september" => $request->september,
            "october" => $request->october,
            "november" => $request->november,
            "december" => $request->december,
        ]);

        return redirect()->back()->with("success", "Forecast Updated");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ForecastTireSize $forecastTireSize)
    {
        $forecastTireSize->delete();

        return redirect()->back()->with("success", "Forecast Deleted");
    }
}
