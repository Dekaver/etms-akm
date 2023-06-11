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
        "site_id",
        "unit",
        "tire",
        "position",
        "status",
        "km_unit_install",
        "hm_unit_install",
        "km_unit_remove",
        "hm_unit_remove",
        "pic",
        "pic_man_power",
        "des",
        "km_tire_install",
        "hm_tire_install",
        "km_tire_remove",
        "hm_tire_remove",
        "start_date",
        "end_date"
    ];
}