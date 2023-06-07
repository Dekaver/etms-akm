<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TireCompound extends Model
{
    use HasFactory;
    protected $fillable = [
        "compound",
        "company_id",
    ];
}

