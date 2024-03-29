<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;

    protected $table = "drivers";
    protected $fillable = [
        "company_id",
        "nama",
        "hp",
        "email",
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
