<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "company_id"
    ];

    public function user()
    {
        return $this->hasOneThrough(
            User::class,
            UserSite::class,
            "site_id",
            "id",
            "id",
            "user_id",
        );
    }
}
