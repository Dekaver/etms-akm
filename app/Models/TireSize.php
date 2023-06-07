<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TireSize extends Model
{
    use HasFactory;
    protected $fillable=[
        'company_id',
        'size',
        'tire_pattern_id',
        'otd',
        'recomended_pressure',
        'target_lifetime',
    ];
}
