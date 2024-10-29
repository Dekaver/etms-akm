<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AreaPekerjaan extends Model
{
    use HasFactory;
    
    protected $fillable = [
        "nama",
        "company_id",
    ];
}
