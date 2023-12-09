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
        "tire_id",
        "unit_id",
        "tire_damage_id",
        "km_unit",
        "hm_unit",
        "rtd",
        "position",
        "location",
        "shift",
        "pic",
        "driver",
        "rtd",
        "pressure",
        "lifetime_hm",
        "lifetime_km",
        "date",
        "tube",
        "flap",
        "rim",
        "t_pentil",
        "remark",
    ];

    protected $casts = [
        "date" => "date:Y-m-d"
    ];

    function tire()
    {
        return $this->belongsTo(TireMaster::class, "tire_id", "id");
    }

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
}
