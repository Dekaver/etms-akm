<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyActivityGambar extends Model
{
    use HasFactory;

    protected $table = 'daily_activity_gambars';

    protected $fillable = [
        'daily_activity_id',
        'gambar'
    ];

    // Relasi ke model DailyActivity
    public function dailyActivity()
    {
        return $this->belongsTo(DailyActivity::class);
    }
}
