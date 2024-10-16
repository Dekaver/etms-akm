<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyInspect extends Model
{
    use HasFactory;

    protected $fillable = [
        "company_id",
        "site_id",
        "unit_id",
        "km_unit",
        "hm_unit",
        "updated_km_unit",
        "updated_hm_unit",
        "location",
        "shift",
        "pic",
        "driver",
        "date",
        "time",
        "pic_id",
        "driver_id",
        "start_date",
        "end_date",
    ];

    protected $casts = [
        "date" => "date:Y-m-d"
    ];

    function site()
    {
        return $this->belongsTo(Site::class);
    }

    function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    function tire_damage()
    {
        return $this->belongsTo(TireDamage::class);
    }

    function details()
    {
        return $this->hasMany(DailyInspectDetail::class);
    }

    function foremans()
    {
        return $this->hasMany(DailyInspectForeman::class);
    }    
    function manpowers()
    {
        return $this->hasMany(DailyInspectManPower::class);
    }
}
