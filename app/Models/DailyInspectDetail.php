<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyInspectDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        "daily_inspect_id",
        "tire_id",
        "tire_damage_id",
        "position",
        "is_selected",
        "last_km_unit",
        "last_hm_unit",
        "lifetime_hm",
        "lifetime_km",
        "diff_hm",
        "diff_km",
        "rtd",
        "pressure",
        "tube",
        "flap",
        "rim",
        "t_pentil",
        "remark",
    ];

    function tire()
    {
        return $this->belongsTo(TireMaster::class);
    }

    public function daily_inspect()
    {
        return $this->belongsTo(DailyInspect::class, 'daily_inspect_id', 'id');
    }
}
