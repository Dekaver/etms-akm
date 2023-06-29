<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TireRepair extends Model
{
    use HasFactory;

    protected $fillable = [
        "tire_id",
        "tire_damage_id",
        "tire_status_id",
        "company_id",
        "reason",
        "analisa",
        "alasan",
        "man_power",
        "pic",
        "start_date",
        "end_date",
        "move"
    ];

    public function tire()
    {
        return $this->belongsTo(TireMaster::class);
    }

    public function tire_damage()
    {
        return $this->belongsTo(TireDamage::class);
    }

    public function tire_status()
    {
        return $this->belongsTo(TireStatus::class);
    }

    public function tire_movement()
    {
        return $this->hasOne(TireMovement::class);
    }
}