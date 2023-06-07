<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TirePattern extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'pattern',
        'type_pattern',
        'tire_manufacture_id',
    ];

    public function manufacture()
    {
        return $this->belongsTo(TireManufacture::class, "tire_manufacture_id");
    }
}