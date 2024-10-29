<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        "tanggal",
        "site_id",
        "teknisi_id",
        "aktivitas_pekerjaan_id",
        "unit_model_id",
        "unit_id",
        "start_date",
        "end_date",
        "area_pekerjaan_id",
        "remark",
        "company_id"
    ];

    public function teknisi()
    {
        return $this->belongsTo(Teknisi::class);
    }

    public function aktivitas_pekerjaan()
    {
        return $this->belongsTo(AktivitasPekerjaan::class);
    }

    public function unit_model()
    {
        return $this->belongsTo(UnitModel::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function area_pekerjaan()
    {
        return $this->belongsTo(AreaPekerjaan::class);
    }

    public function site()
    {
        return $this->belongsTo(Site::class);
    }
    public function gambars()
    {
        return $this->hasMany(DailyActivityGambar::class);
    }
}
