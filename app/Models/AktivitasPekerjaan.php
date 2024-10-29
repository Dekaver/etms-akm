<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AktivitasPekerjaan extends Model
{
    use HasFactory;

    protected $fillable = [
        "nama",
        "company_id",
    ];
}
