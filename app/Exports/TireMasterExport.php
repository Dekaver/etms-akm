<?php

namespace App\Exports;

use App\Models\TireMaster;
use Carbon\Carbon;
use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class TireMasterExport implements FromView
{
    protected $year;
    protected $compound;
    protected $size;
    protected $status;

    public function __construct(string $status, string $size, string $compound, string $year)
    {
        $this->year = $year;
        $this->compound = $compound;
        $this->size = $size;
        $this->status = $status;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {
        $company = auth()->user()->company;
        $tire = TireMaster::where("company_id", $company->id);
        if ($this->size) {
            $tire = $tire->where("tire_size_id", $this->size);
        }

        if ($this->compound) {
            $tire = $tire->where("tire_size_id", $this->compound);
        }

        if ($this->status) {
            $tire = $tire->where("tire_size_id", $this->status);
        }

        if ($this->year) {
            $tire = $tire->whereYear("date", $this->year);
        }
        $tires = $tire->save();

        return view("admin.export.tire-master", compact("tires"));
    }
}
