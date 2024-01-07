<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TireSize extends Model
{
    use HasFactory;
    protected $fillable = [
        'company_id',
        'size',
        'tire_pattern_id',
        'otd',
        'recomended_pressure',
        'target_lifetime_hm',
        'target_lifetime_km',
        'price',
    ];

    public function tire_pattern()
    {
        return $this->belongsTo(TirePattern::class);
    }

    public function tire()
    {
        return $this->hasMany(TireMaster::class, "tire_size_id");
    }

    public function target_km(){
        return $this->hasMany(TireTargetKm::class, "tire_size_id");
    }

    public function scrapCount(): Attribute
    {
        $scrap = TireStatus::where("status", "SCRAP")->first();
        return Attribute::make(
            get: fn($value) => $this
                ->tire
                ->where("tire_status_id", $scrap->id)
                ->count(),
        );
    }

    public function runningCount(): Attribute
    {
        $scrap = TireStatus::where("status", "RUNNING")->first();
        return Attribute::make(
            get: fn($value) => $this
                ->tire
                ->where("tire_status_id", $scrap->id)
                ->count(),
        );
    }

    public function repairCount(): Attribute
    {
        $scrap = TireStatus::where("status", "REPAIR")->first();
        return Attribute::make(
            get: fn($value) => $this
                ->tire
                ->where("tire_status_id", $scrap->id)
                ->count(),
        );
    }

    public function newCount(): Attribute
    {
        $scrap = TireStatus::where("status", "NEW")->first();
        return Attribute::make(
            get: fn($value) => $this
                ->tire
                ->where("tire_status_id", $scrap->id)
                ->count(),
        );
    }

    public function spareCount(): Attribute
    {
        $scrap = TireStatus::where("status", "SPARE")->first();
        return Attribute::make(
            get: fn($value) => $this
                ->tire
                ->where("tire_status_id", $scrap->id)
                ->count(),
        );
    }


    public function actualAvgKmPerMm(): Attribute
    {
        $actual_km_per_mm = [];
        foreach ($this->tire as $tire){
            $actual_km_per_mm[] = $tire->km_per_mm;
        }
        return Attribute::make(
             get: fn($value) => round(count($actual_km_per_mm) > 0 ? array_sum($actual_km_per_mm) / count($actual_km_per_mm) : 0, 1)
        );
    }

    public function actualAvgRtd(): Attribute
    {
        $actual_rtd = [];
        foreach ($this->tire as $tire){
            $actual_rtd[] = $tire->rtd;
        }
        return Attribute::make(
             get: fn($value) => round(count($actual_rtd) > 0 ? array_sum($actual_rtd) / count($actual_rtd) : 0, 1)
        );
    }

    public function actualAvgTur(): Attribute
    {
        $actual_tur = [];
        foreach ($this->tire as $tire){
            $actual_tur[] = $this->otd - $tire->rtd;
        }
        return Attribute::make(
             get: fn($value) => round(count($actual_tur) > 0 ? array_sum($actual_tur) / count($actual_tur) : 0, 1)
        );
    }

    public function actualAvgLifetimeKm(): Attribute
    {
        $actual_km = [];
        foreach ($this->tire as $tire){
            $actual_km[] = $tire->lifetime_km;
        }
        return Attribute::make(
             get: fn($value) => round(count($actual_km) > 0 ? array_sum($actual_km) / count($actual_km) : 0, 1)
        );
    }
}
