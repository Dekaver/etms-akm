<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TireRepairPhoto extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        "tire_repair_id",
        "photo",
        "urut",
        "tipe",
    ];

    public function tire_repair()
    {
        return $this->belongsTo(TireRepair::class);
    }
}
