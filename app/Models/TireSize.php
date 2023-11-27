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
}
