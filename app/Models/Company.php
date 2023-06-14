<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "initial",
        "email",
    ];

    public function user()
    {
        return $this->hasMany(User::class);
    }

    public function tire_compound()
    {
        return $this->hasMany(TireCompound::class);
    }

    public function tire_size()
    {
        return $this->hasMany(TireSize::class);
    }

    public function tire_damage()
    {
        return $this->hasMany(TireDamage::class);
    }

    public function tire_manufacture()
    {
        return $this->hasMany(TireManufacture::class);
    }

    public function tire_pattern()
    {
        return $this->hasMany(TirePattern::class);
    }

    public function tire_status()
    {
        return $this->hasMany(TireStatus::class);
    }

    public function unit_status()
    {
        return $this->hasMany(UnitStatus::class);
    }

    public function site()
    {
        return $this->hasMany(Site::class);
    }
}
