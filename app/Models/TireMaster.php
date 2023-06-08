<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TireMaster extends Model
{
    use HasFactory;
    protected $fillable=[
        'site_id',
        'serial_number',
        'tire_size_id',
        'tire_compound_id',
        'tire_status_id',
        'rtd',
        'lifetime',
        'date',
    ];
}
