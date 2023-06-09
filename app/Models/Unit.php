<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    protected $fillable = [
        "company_id",
        "unit_model_id",
        "unit_status_id",
        "site_id",
        "unit_number",
        "head",
        "km",
        "hm",
    ];

    public function unit_model()
    {
        return $this->belongsTo(UnitModel::class);
    }

    public function unit_status()
    {
        return $this->belongsTo(UnitStatus::class);
    }

    public function site()
    {
        return $this->belongsTo(Site::class);
    }
}