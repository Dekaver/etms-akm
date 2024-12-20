<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryTireMovement extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_id",
        "company_id",
        "tire_damage_id",
        "site_id",
        "unit",
        "tire",
        "position",
        "status",
        "km_unit",
        "hm_unit",
        "pic",
        "pic_man_power",
        "des",
        "process",
        "km_tire",
        "hm_tire",
        "km_tire_retread",
        "hm_tire_retread",
        "km_tire_repair",
        "hm_tire_repair",
        "rtd",
        "start_date",
        "end_date",
        "start_breakdown",
        "status_schedule",
        "lokasi_breakdown",
        "driver_id",
        "pic_id",
        "price",
        "photo"
    ];

    public function tire_number()
    {
        return $this->belongsTo(TireMaster::class, "tire", "serial_number");
    }

    public function unit_number()
    {
        return $this->belongsTo(Unit::class, "unit", "unit_number");
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class, "driver_id", "id");
    }

    public function site()
    {
        return $this->belongsTo(Site::class);
    }
    public function tire_damage()
    {
        return $this->belongsTo(TireDamage::class);
    }
    public function pics()
    {
        return $this->belongsTo(Teknisi::class, 'pic_id', 'id');
    }
    function foremans()
    {
        return $this->hasMany(HistoryTireMovementForeman::class);
    }
    function manpowers()
    {
        return $this->hasMany(HistoryTireMovementManPower::class);
    }
    public function getForemansListAttribute()
    {
        return $this->foremans->pluck('teknisi.nama')->implode(', ');
    }
    
    public function getManpowersListAttribute()
    {
        return $this->manpowers->pluck('teknisi.nama')->implode(', ');
    }
    
}
