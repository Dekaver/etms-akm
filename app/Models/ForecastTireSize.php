<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForecastTireSize extends Model
{
    use HasFactory;
    protected $table = 'forecast_tire_sizes';
    protected $fillable = [
        'tire_size_id',
        'company_id',
        'year',
        'january',
        'february',
        'march',
        'april',
        'may',
        'june',
        'july',
        'august',
        'september',
        'october',
        'november',
        'december',
    ];

    public function size()
    {
        return $this->belongsTo(Size::class, 'tire_size_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function getAnnualForecastAttribute()
    {
        return $this->january + $this->february + $this->march + 
               $this->april + $this->may + $this->june +
               $this->july + $this->august + $this->september +
               $this->october + $this->november + $this->december;
    }
}
