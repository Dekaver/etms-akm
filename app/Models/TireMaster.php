<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TireMaster extends Model
{
    use HasFactory;

    protected $table = "tires";
    protected $fillable = [
        'company_id',
        'site_id',
        'tire_supplier_id',
        'serial_number',
        'tire_size_id',
        'tire_compound_id',
        'tire_status_id',
        'tire_damage_id',
        'rtd',
        'lifetime_km',
        'lifetime_hm',
        'lifetime_retread_km',
        'lifetime_retread_hm',
        'lifetime_repair_km',
        'lifetime_repair_hm',
        'date',
        'pressure',
        'tube',
        'flap',
        'rim',
        't_pentil',
        'is_repair',
        'is_retread',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    public function tire_size()
    {
        return $this->belongsTo(TireSize::class);
    }

    public function tire_compound()
    {
        return $this->belongsTo(TireCompound::class);
    }

    public function tire_status()
    {
        return $this->belongsTo(TireStatus::class);
    }

    public function tire_running()
    {
        return $this->hasOne(TireRunning::class, "tire_id", "id");
    }

    public function history_tire_movement()
    {
        return $this->hasMany(HistoryTireMovement::class, "tire", "serial_number");
    }

    public function daily_inspect()
    {
        return $this->hasMany(DailyInspect::class, "tire_id", "id");
    }
}