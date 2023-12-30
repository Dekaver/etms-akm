<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdjustKmPasang extends Model
{
    use HasFactory;

    protected $fillable = [
        "unit_id",
        "tire_id",
        "tanggal",
        "position",
        "km_unit",
        "updated_km_unit",
        "hm_unit",
        "updated_hm_unit",
        "km",
        "updated_km",
        "hm",
        "updated_hm",
    ];
}
