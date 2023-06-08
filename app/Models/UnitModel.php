<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitModel extends Model
{
    use HasFactory;

    protected $fillable = [
        "tire_size_id",
        "brand",
        "model",
        "type",
        "tire_qty",
        "axle_2_tire",
        "axle_4_tire",
        "axle_8_tire"
    ];
}