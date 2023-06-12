<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TireRunning extends Model
{
    use HasFactory;

    protected $fillable = [
        "unit_id",
        "tire_id",
        "site_id",
        "company_id",
        "position",
    ];

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function tire()
    {
        return $this->belongsTo(TireMaster::class);
    }

    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function tire_movemet()
    {
        return $this->hasOne(TireMovement::class);
    }
}
