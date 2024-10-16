<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyInspectManPower extends Model
{
    use HasFactory;

    protected $table = "daily_inspect_manpowers";
    protected $fillable = [
        "daily_inspect_id",
        "teknisi_id"
    ];

    public function teknisi()
    {
        return $this->belongsTo(Teknisi::class, "teknisi_id");
    }
}
