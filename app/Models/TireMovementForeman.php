<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TireMovementForeman extends Model
{
    use HasFactory;

    protected $table = "tire_movement_foremans";
    protected $fillable = [
        "tire_movement_id",
        "teknisi_id"
    ];

    public function teknisi()
    {
        return $this->belongsTo(Teknisi::class, "teknisi_id");
    }
}
