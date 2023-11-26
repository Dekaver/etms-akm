<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TireTargetKm extends Model
{
    use HasFactory;

    protected $table = "tire_target_km";

    protected $fillable = [
        'site_id',
        'tire_size_id',
        'rtd_target_km',
        'company_id',
    ];

    public function site(){
        return $this->belongsTo(Site::class);
    }

    public function tire_size(){
        return $this->belongsTo(TireSize::class);
    }
}
