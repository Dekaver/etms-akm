<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TireMaster extends Model
{
    use HasFactory;

    protected $table = "tires";
    protected $fillable = [
        'company_id',
        'site_id',
        'tire_supplier_id',
        'serial_number',
        'tire_size_id',
        'tire_compound_id',
        'tire_status_id',
        'tire_damage_id',
        'rtd',
        'lifetime_km',
        'lifetime_hm',
        'lifetime_retread_km',
        'lifetime_retread_hm',
        'lifetime_repair_km',
        'lifetime_repair_hm',
        'date',
        'pressure',
        'tube',
        'flap',
        'rim',
        't_pentil',
        'is_repair',
        'is_retread',
        'is_repairing',
        'is_retreading',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    public function tire_size()
    {
        return $this->belongsTo(TireSize::class);
    }

    public function tire_compound()
    {
        return $this->belongsTo(TireCompound::class);
    }

    public function tire_status()
    {
        return $this->belongsTo(TireStatus::class);
    }

    public function tire_running()
    {
        return $this->hasOne(TireRunning::class, "tire_id", "id");
    }

    public function tire_repair()
    {
        return $this->hasOne(TireRepair::class, "tire_id", "id");
    }

    public function tire_adjust_km()
    {
        return $this->hasMany(AdjustKmPasang::class, "tire_id", "id");
    }

    public function daily_inspect_details()
    {
        return $this->hasMany(DailyInspectDetail::class, "tire_id", "id");
    }

    public function history_tire_movement()
    {
        return $this->hasMany(HistoryTireMovement::class, "tire", "serial_number");
    }

    public function daily_inspect_detail($unit_id)
    {
        return $this->hasMany(DailyInspectDetail::class, 'tire_id')
            ->join('daily_inspects', 'daily_inspects.id', '=', 'daily_inspect_details.daily_inspect_id')
            ->where('daily_inspects.unit_id', $unit_id)
            ->orderBy('daily_inspects.created_at', 'desc');
    }


    public function tur(): Attribute
    {
        return Attribute::make(
            get: fn($value) => ((int) $this->tire_size->otd - (int) $this->rtd),
        );
    }

    public function kmPerMm(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $this->tur == 0 ? 0: round((int) $this->lifetime_km / ((int) $this->tur ), 1),
        );
    }

    public function countDay(): Attribute
    {
        $tire_size = $this->tire_size;
        $site = $this->site;
        if ($site == null) {
            return Attribute::make(
                get: fn($value) => NULL,
            );
        }
        $total_jarak = (int) $site->total_jarak;
        $km_per_mil = $tire_size->target_km->where("site_id", $site->id)->pluck("rtd_target_km")->first();
        if($total_jarak && $km_per_mil){
            return Attribute::make(
                get: fn($value) => round($this->rtd * (int) $km_per_mil / (int) $total_jarak),
            );
        }else{
            return Attribute::make(
                get: fn($value) => NULL,
            );
        }
    }

    public function lastUpdateKmUnit(): Attribute
    {
        $tire_running = $this->tire_running;
        if($tire_running){
            $daily_inspect = $this->daily_inspect_detail($tire_running->unit_id)->first();
            if($daily_inspect){
                return Attribute::make(
                    get: fn($value) => $daily_inspect->last_km_unit
                );
            }else{
                return Attribute::make(
                    get: fn($value) => $tire_running->tire_movement->km
                );
            }
        }else{
            return Attribute::make(
                get: fn($value) => 0
            );
        }
    }

    public function lastUpdateHmUnit(): Attribute
    {
        $tire_running = $this->tire_running;
        if($tire_running){
            $daily_inspect = $this->daily_inspect_detail($tire_running->unit_id)->first();
            if($daily_inspect){
                return Attribute::make(
                    get: fn($value) => $daily_inspect->last_hm_unit
                );
            }else{
                return Attribute::make(
                    get: fn($value) => $tire_running->tire_movement->hm
                );
            }
        }else{
            return Attribute::make(
                get: fn($value) => 0
            );
        }
    }
}
