<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitModel extends Model
{
    use HasFactory;

    protected $fillable = [
        "company_id",
        "tire_size_id",
        "brand",
        "model",
        "type",
        "tire_qty",
        "axle_2_tire",
        "axle_4_tire",
        "axle_8_tire",
        "informasi_berat_kosong",
        "distribusi_beban",
        "standar_load_capacity",
    ];

    public function tire_size()
    {
        return $this->belongsTo(TireSize::class);
    }
}