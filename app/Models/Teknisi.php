<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teknisi extends Model
{
    use HasFactory;

    protected $table = "teknisis";
    protected $fillable = [
        "nama",
        "kode",
        "department_id",
        "jabatan_id",
        "company_id",
        "is_leader",
        "is_foreman",
        "is_manpower",
        "nik"
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
