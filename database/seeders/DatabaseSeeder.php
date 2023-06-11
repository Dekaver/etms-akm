<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Company;
use App\Models\Site;
use App\Models\TireCompound;
use App\Models\TireDamage;
use App\Models\TireManufacture;
use App\Models\TireMaster;
use App\Models\TireMovement;
use App\Models\TirePattern;
use App\Models\TireRunning;
use App\Models\TireSize;
use App\Models\TireStatus;
use App\Models\TireSupplier;
use App\Models\Unit;
use App\Models\UnitModel;
use App\Models\UnitStatus;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $company1 = Company::factory()->create();
        $company2 = Company::factory()->create();
        $company3 = Company::factory()->create();


        Permission::create(['name' => 'TIRE_MANUFACTURE']);
        Permission::create(['name' => 'MANAJEMEN_USER']);
        Permission::create(['name' => 'DEMO']);
        $site = Site::create([
            "name" => "site A",
            "company_id" => $company1->id,
        ]);

        $role = Role::create(['name' => 'superadmin']);
        $role->givePermissionTo('MANAJEMEN_USER');

        $roleuser = Role::create(['name' => 'user']);
        $roleuser->givePermissionTo('MANAJEMEN_USER');

        $rolenew = Role::create(['name' => 'new']);
        $rolenew->givePermissionTo('DEMO');

        $role_a = Role::create(['name' => 'customeradmin']);
        $role_a->givePermissionTo('MANAJEMEN_USER');

        $user = \App\Models\User::factory()->create([
            'name' => 'superadmin',
            'email' => 'superadmin@gmail.com',
            'company_id' => $company1->id
        ]);
        $user->assignRole($role);

        $user_a = \App\Models\User::factory()->create([
            'name' => 'admin_a',
            'email' => 'admin_a@gmail.com',
            'company_id' => $company1->id
        ]);
        $user_a->assignRole($role_a);
        $user_a->syncPermissions("TIRE_MANUFACTURE");

        $user->userSite()->create([
            "site_id" => $site->id,
        ]);

        $user_b = \App\Models\User::factory()->create([
            'name' => 'admin_b',
            'email' => 'admin_b@gmail.com',
            'company_id' => $company2->id
        ]);
        $user_b->assignRole($role_a);

        TireSupplier::create([
            "name" => "AKM",
            "email" => "akm@gmail.com",
            "phone" => "08235234223",
            "address" => "jl. kilang Semar bakpia",
        ]);

        TireManufacture::create([
            "name" => "Advanced",
            "company_id" => 1,
        ]);
        TirePattern::create([
            "company_id" => 1,
            "pattern" => "GL909A",
            "type_pattern" => "MIX",
            "tire_manufacture_id" => 1,
        ]);

        TireSize::create([
            'company_id' => 1,
            'size' => "29.5R25",
            'tire_pattern_id' => 1,
            'otd' => 80,
            'recomended_pressure' => 90,
            'target_lifetime' => 10000,
        ]);

        TireStatus::create([
            'company_id' => 1,
            "status" => 'NEW'
        ]);
        TireStatus::create([
            'company_id' => 1,
            "status" => 'SPARE'
        ]);
        TireStatus::create([
            'company_id' => 1,
            "status" => 'REPAIR'
        ]);
        TireStatus::create([
            'company_id' => 1,
            "status" => 'RETREAD'
        ]);
        TireStatus::create([
            'company_id' => 1,
            "status" => 'SCRAP'
        ]);
        TireStatus::create([
            'company_id' => 1,
            "status" => 'RUNNING'
        ]);

        UnitStatus::create([
            'company_id' => 1,
            "status_code" => "RFU",
            "description" => "Running"
        ]);

        UnitModel::create([
            'company_id' => 1,
            "tire_size_id" => 1,
            "brand" => "Scania",
            "model" => "P360 LA 6X6",
            "type" => "PRIME MOVER",
            "tire_qty" => 10,
            "axle_2_tire" => 1,
            "axle_4_tire" => 2,
            "axle_8_tire" => 0,
        ]);

        TireDamage::create([
            'company_id' => 1,
            "damage" => "RADIAL CRACK",
            "cause" => "Operational",
            "rating" => "A",
        ]);

        TireCompound::create([
            "company_id" => 1,
            "compound" => "HEAT RESISTANCE",
        ]);
        TireMaster::factory()->count(1000)->create();
        Unit::factory()->count(100)->create();

        $unit = Unit::limit(10)->get();
        foreach ($unit as $key => $value) {
            for ($i = 0; $i < $value->unit_model->tire_qty; $i++) {
                $tire = TireMaster::where("tire_status_id", 1)->inRandomOrder()->first();
                $tirerunning = TireRunning::create([
                    "unit_id" => $value->id,
                    "tire_id" => $tire->id,
                    "site_id" => 1,
                    "company_id" => 1,
                    "position" => $i +1,
                ]);
                TireMovement::create([
                    "tire_running_id" => $tirerunning->id,
                    "hm" => 0,
                    "km" => 0,
                    "unit_lifetime_hm" => $value->hm,
                    "unit_lifetime_km" => $value->km,
                    "tire_lifetime_hm" => $tire->lifetime_hm,
                    "tire_lifetime_km" => $tire->lifetime_km,
                    "rtd" => $tire->rtd,
                    "start_date" => \Carbon\Carbon::now(),
                    "end_date" => \Carbon\Carbon::now(),
                    "pic" => fake()->name(),
                    "pic_man_power" => fake()->firstName(),
                    "desc" => "install"
                ]);
                $tire->tire_status_id = 6;
                $tire->save();
            }
        }

    }
}
