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
        "tire_damage_2_id",
        "tire_damage_3_id",
        "history_tire_movement_id",
        "tire_status_id",
        "company_id",
        "reason",
        "analisa",
        "alasan",
        "man_power",
        "pic",
        "start_date",
        "end_date",
        "move",
        // Add the new fields for fotos and their descriptions
        "foto_before_1",
        "keterangan_before_1",
        "foto_after_1",
        "keterangan_after_1",
        "foto_before_2",
        "keterangan_before_2",
        "foto_after_2",
        "keterangan_after_2",
        "foto_before_3",
        "keterangan_before_3",
        "foto_after_3",
        "keterangan_after_3",
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

    // public function tire_repair_photo()
    // {
    //     return $this->hasMany(TireRepairPhoto::class, "tire_repair_id");
    // }
}
