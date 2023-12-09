<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryDailyInspect extends Model
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
}
