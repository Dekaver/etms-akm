<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    protected $fillable = [
        "company_id",
        "unit_model_id",
        "unit_status_id",
        "site_id",
        "unit_number",
        "head",
        "km",
        "hm",
    ];

    public function unit_model()
    {
        return $this->belongsTo(UnitModel::class);
    }

    public function unit_status()
    {
        return $this->belongsTo(UnitStatus::class);
    }

    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    public function daily_inspect()
    {
        return $this->hasMany(DailyInspect::class)->orderBy('id', 'desc');
    }

    public function history_tire_movement()
    {
        return $this->hasMany(HistoryTireMovement::class, "unit", "unit_number");
    }

    public function tire_runnings()
    {
        return $this->hasMany(TireRunning::class, "unit_id", "id");
    }

    public function inspectionLastUpdate(): Attribute
    {
        return Attribute::make(
            get: function () {
                $date = $this->daily_inspect
                    ->sortByDesc('date')
                    ->sortByDesc('time')
                    ->pluck('date')
                    ->first()?->format("Y-m-d");
                    $time = $this->daily_inspect
                    ->sortByDesc('date')
                    ->sortByDesc('time')
                    ->pluck('time')
                    ->first();
                if ($date == null) {
                    return null;
                }
                return Carbon::parse("$date $time");
            }
        );
    }
}
