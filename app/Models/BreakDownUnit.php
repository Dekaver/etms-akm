<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BreakDownUnit extends Model
{
    use HasFactory;

    protected $table = "breakdown_units";
    protected $fillable = [
        'company_id',
        'tanggal',
        'shift',
        'unit',
        'pit',
        'site_id',
        'hm_bd',
        'hm_ready',
        'start_bd_date',
        'start_bd',
        'end_bd',
        'duration_bd',
        'status_bd',
        'problem',
        'action',
        'pb_vendor',
        'mr_ro_po',
        'section',
        'component',
    ];

    // Relasi dengan tabel lain jika diperlukan
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function site()
    {
        return $this->belongsTo(Site::class);
    }
}
