<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BreakDownUnitPic extends Model
{
    use HasFactory;

    protected $table = "breakdown_unit_pics";
    protected $fillable = [
        "teknisi_id",
        "breakdown_unit_id"
    ];

    public function teknisi()
    {
        return $this->belongsTo(Teknisi::class, "teknisi_id");
    }
}
