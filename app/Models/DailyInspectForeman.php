<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyInspectForeman extends Model
{
    use HasFactory;

    protected $table = "daily_inspect_foremans";
    protected $fillable = [
        "daily_inspect_id",
        "teknisi_id"
    ];

    public function teknisi()
    {
        return $this->belongsTo(Teknisi::class, "teknisi_id");
    }
}
