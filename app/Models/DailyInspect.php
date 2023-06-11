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
        "rtd",
        "action",
        "pressure",
        "position",
        "lifetime_hm",
        "lifetime_km",
        "date",
    ];
}
