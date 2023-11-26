<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TireMovement extends Model
{
    use HasFactory;

    protected $fillable = [
        "tire_running_id",
        "hm",
        "km",
        "hm_actual",
        "km_actual",
        "unit_lifetime_hm",
        "unit_lifetime_km",
        "tire_lifetime_hm",
        "tire_lifetime_km",
        "rtd",
        "start_date",
        "end_date",
        "pic",
        "pic_man_power",
        "desc",
        "start_breakdown",
        "status_schedule",
        "lokasi_breakdown"
    ];
}
