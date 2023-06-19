<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Company;
use App\Models\HistoryTireMovement;
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
use App\Models\User;
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
        // $company2 = Company::factory()->create();
        // $company3 = Company::factory()->create();


        Permission::insert(
            array(
                array('id' => '1', 'name' => 'TIRE_MANUFACTURE', 'description' => 'Manufacture of tire', 'group' => 'DATA_TIRE', 'guard_name' => 'web', 'created_at' => '2023-06-11 16:46:55', 'updated_at' => '2023-06-12 03:19:44'),
                array('id' => '2', 'name' => 'MANAJEMEN_USER', 'description' => '', 'group' => '', 'guard_name' => 'web', 'created_at' => '2023-06-11 16:46:55', 'updated_at' => '2023-06-11 16:46:55'),
                array('id' => '3', 'name' => 'DEMO', 'description' => '', 'group' => '', 'guard_name' => 'web', 'created_at' => '2023-06-11 16:46:55', 'updated_at' => '2023-06-11 16:46:55'),
                array('id' => '4', 'name' => 'USER_MANAJEMEN', 'description' => '', 'group' => '', 'guard_name' => 'web', 'created_at' => '2023-06-12 03:03:49', 'updated_at' => '2023-06-12 03:03:49'),
                array('id' => '5', 'name' => 'COMPANY', 'description' => '-', 'group' => 'MANAJEMEN_USER', 'guard_name' => 'web', 'created_at' => '2023-06-12 03:22:11', 'updated_at' => '2023-06-12 03:22:11'),
                array('id' => '6', 'name' => 'TIRE_PATTERN', 'description' => 'Type shape pattern of tire', 'group' => 'DATA_TIRE', 'guard_name' => 'web', 'created_at' => '2023-06-12 03:22:54', 'updated_at' => '2023-06-12 03:22:54'),
                array('id' => '7', 'name' => 'TIRE_SIZE', 'description' => 'Type size of tire', 'group' => 'DATA_TIRE', 'guard_name' => 'web', 'created_at' => '2023-06-12 03:24:07', 'updated_at' => '2023-06-12 03:24:07'),
                array('id' => '8', 'name' => 'TIRE_COMPOUND', 'description' => 'Compound of tire', 'group' => 'DATA_TIRE', 'guard_name' => 'web', 'created_at' => '2023-06-12 03:24:44', 'updated_at' => '2023-06-12 03:24:44'),
                array('id' => '9', 'name' => 'TIRE_STATUS', 'description' => 'Status of tire', 'group' => 'DATA_TIRE', 'guard_name' => 'web', 'created_at' => '2023-06-12 03:25:31', 'updated_at' => '2023-06-12 03:25:31'),
                array('id' => '10', 'name' => 'TIRE_DAMAGE', 'description' => 'Damage of tire', 'group' => 'DATA_TIRE', 'guard_name' => 'web', 'created_at' => '2023-06-12 03:28:38', 'updated_at' => '2023-06-12 03:28:38'),
                array('id' => '11', 'name' => 'TIRE_MASTER', 'description' => 'Master data of tire', 'group' => 'DATA_TIRE', 'guard_name' => 'web', 'created_at' => '2023-06-12 03:29:41', 'updated_at' => '2023-06-12 03:29:41'),
                array('id' => '12', 'name' => 'SITE', 'description' => 'site', 'group' => 'DATA', 'guard_name' => 'web', 'created_at' => '2023-06-12 03:30:26', 'updated_at' => '2023-06-12 03:30:26'),
                array('id' => '13', 'name' => 'UNIT_STATUS', 'description' => 'status unit', 'group' => 'DATA', 'guard_name' => 'web', 'created_at' => '2023-06-12 03:30:50', 'updated_at' => '2023-06-12 03:30:50'),
                array('id' => '14', 'name' => 'UNIT_MODEL', 'description' => 'model unit', 'group' => 'DATA', 'guard_name' => 'web', 'created_at' => '2023-06-12 03:31:14', 'updated_at' => '2023-06-12 03:31:14'),
                array('id' => '15', 'name' => 'UNIT', 'description' => 'unit', 'group' => 'DATA', 'guard_name' => 'web', 'created_at' => '2023-06-12 03:31:34', 'updated_at' => '2023-06-12 03:31:34'),
                array('id' => '16', 'name' => 'GRAFIK', 'description' => 'grafik', 'group' => 'GRAFIK', 'guard_name' => 'web', 'created_at' => '2023-06-12 03:32:57', 'updated_at' => '2023-06-12 03:32:57'),
                array('id' => '17', 'name' => 'DAILY_INSPECT', 'description' => 'daily inspect tire', 'group' => 'DATA_HISTORY', 'guard_name' => 'web', 'created_at' => '2023-06-12 03:34:25', 'updated_at' => '2023-06-12 03:34:25'),
                array('id' => '18', 'name' => 'HISTORY_TIRE', 'description' => 'tire history inspect & movement', 'group' => 'DATA_HISTORY', 'guard_name' => 'web', 'created_at' => '2023-06-12 03:35:11', 'updated_at' => '2023-06-12 03:35:11'),
                array('id' => '19', 'name' => 'HISTORY_TIRE_MOVEMENT', 'description' => '-', 'group' => 'DATA_HISTORY', 'guard_name' => 'web', 'created_at' => '2023-06-12 03:36:22', 'updated_at' => '2023-06-12 03:36:22'),
                array('id' => '20', 'name' => 'HISTORY_TIRE_INSPECT', 'description' => '-', 'group' => 'DATA_HISTORY', 'guard_name' => 'web', 'created_at' => '2023-06-12 03:37:15', 'updated_at' => '2023-06-12 03:37:15'),
                array('id' => '21', 'name' => 'ROLE', 'description' => '-', 'group' => 'MANAJEMEN_USER', 'guard_name' => 'web', 'created_at' => '2023-06-12 03:38:20', 'updated_at' => '2023-06-12 03:38:20'),
                array('id' => '22', 'name' => 'PERMISSION', 'description' => '-', 'group' => 'MANAJEMEN_USER', 'guard_name' => 'web', 'created_at' => '2023-06-12 03:38:57', 'updated_at' => '2023-06-12 03:38:57')
            )
        );

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

        $user = User::factory()->create([
            'name' => 'superadmin',
            'email' => 'superadmin@gmail.com',
            'company_id' => $company1->id
        ]);
        $user->assignRole($role);

        // $user_a = User::factory()->create([
        //     'name' => 'admin_a',
        //     'email' => 'admin_a@gmail.com',
        //     'company_id' => $company1->id
        // ]);
        // $user_a->assignRole($role_a);
        // $user_a->syncPermissions("TIRE_MANUFACTURE");

        $user->userSite()->create([
            "site_id" => $site->id,
        ]);

        // $user_b = User::factory()->create([
        //     'name' => 'admin_b',
        //     'email' => 'admin_b@gmail.com',
        //     'company_id' => $company2->id
        // ]);
        // $user_b->assignRole($role_a);

        TireSupplier::create([
            "name" => "AKM",
            "email" => "akm@gmail.com",
            "phone" => "08235234223",
            "address" => "jl. kilang Semar bakpia",
        ]);

        TireCompound::factory()->createMany([
            ['compound' => 'A'],
            ['compound' => 'B'],
            ['compound' => 'Z'],
            ['compound' => 'K'],
        ]);

        TireManufacture::insert(
            array(
                array('id' => '1', 'company_id' => '1', 'name' => 'AEOLUS', 'created_at' => '2023-06-11 16:46:55', 'updated_at' => '2023-06-12 03:06:03'),
                array('id' => '2', 'company_id' => '1', 'name' => 'ADVANCE', 'created_at' => '2023-06-11 16:46:55', 'updated_at' => '2023-06-12 03:06:18'),
                array('id' => '3', 'company_id' => '1', 'name' => 'BFGOODRICH', 'created_at' => '2023-06-11 16:46:55', 'updated_at' => '2023-06-12 03:06:39'),
                array('id' => '4', 'company_id' => '1', 'name' => 'BONTYRE', 'created_at' => '2023-06-11 16:46:55', 'updated_at' => '2023-06-12 03:06:57'),
                array('id' => '5', 'company_id' => '1', 'name' => 'BRIDGESTONE', 'created_at' => '2023-06-11 16:46:55', 'updated_at' => '2023-06-12 03:07:13'),
                array('id' => '6', 'company_id' => '1', 'name' => 'CROSS', 'created_at' => '2023-06-12 03:07:37', 'updated_at' => '2023-06-12 03:07:37'),
                array('id' => '7', 'company_id' => '1', 'name' => 'UNINEST', 'created_at' => '2023-06-12 03:07:55', 'updated_at' => '2023-06-12 03:07:55')
            )
        );

        TirePattern::factory(10)->create();

        TireSize::factory(15)->create();


        TireStatus::create([
            "status" => 'NEW'
        ]);
        TireStatus::create([
            "status" => 'SPARE'
        ]);
        TireStatus::create([
            "status" => 'REPAIR'
        ]);
        TireStatus::create([
            "status" => 'RETREAD'
        ]);
        TireStatus::create([
            "status" => 'SCRAP'
        ]);
        TireStatus::create([
            "status" => 'RUNNING'
        ]);

        UnitStatus::create([
            "status_code" => "RFU",
            "description" => "Running"
        ]);
        UnitStatus::create([
            "status_code" => "STBY",
            "description" => "Running"
        ]);
        UnitStatus::create([
            "status_code" => "BD",
            "description" => "Running"
        ]);

        UnitModel::create([
            'company_id' => 1,
            "tire_size_id" => 3,
            "brand" => "Scania",
            "model" => "P360 LA 6X6",
            "type" => "PRIME MOVER",
            "tire_qty" => 10,
            "axle_2_tire" => 1,
            "axle_4_tire" => 2,
            "axle_8_tire" => 0,
        ]);

        // UnitModel::create([
        //     'company_id' => 1,
        //     "tire_size_id" => 1,
        //     "brand" => "Scania",
        //     "model" => "P360 LA 6X6",
        //     "type" => "PRIME MOVER",
        //     "tire_qty" => 10,
        //     "axle_2_tire" => 1,
        //     "axle_4_tire" => 2,
        //     "axle_8_tire" => 0,
        // ]);

        // UnitModel::create([
        //     'company_id' => 1,
        //     "tire_size_id" => 2,
        //     "brand" => "Scania",
        //     "model" => "P360 LA 6X6",
        //     "type" => "PRIME MOVER",
        //     "tire_qty" => 10,
        //     "axle_2_tire" => 1,
        //     "axle_4_tire" => 2,
        //     "axle_8_tire" => 0,
        // ]);

        TireDamage::insert(
            array(

                array('id' => '1', 'company_id' => 1, 'damage' => 'BEAD FATIQUE', 'cause' => 'Operational', 'rating' => '-', 'created_at' => '2022-08-05 13:59:26', 'updated_at' => '2022-08-05 15:12:01'),
                array('id' => '2', 'company_id' => 1, 'damage' => 'BEAD DAMAGE', 'cause' => 'Maintenance', 'rating' => '-', 'created_at' => '2022-08-05 15:12:20', 'updated_at' => '2022-08-05 15:12:20'),
                array('id' => '3', 'company_id' => 1, 'damage' => 'SIDEWALL CUT', 'cause' => 'Operational', 'rating' => '-', 'created_at' => '2022-08-05 15:12:41', 'updated_at' => '2022-08-05 15:12:41'),
                array('id' => '4', 'company_id' => 1, 'damage' => 'TREAD CUT', 'cause' => 'Operational', 'rating' => '-', 'created_at' => '2022-08-05 15:13:06', 'updated_at' => '2022-08-05 15:13:06'),
                array('id' => '5', 'company_id' => 1, 'damage' => 'SHOULDER CUT', 'cause' => 'Operational', 'rating' => '-', 'created_at' => '2022-08-05 15:13:37', 'updated_at' => '2022-08-05 15:13:37'),
                array('id' => '6', 'company_id' => 1, 'damage' => 'SIDEWALL SEPARATION', 'cause' => 'Maintenance', 'rating' => '-', 'created_at' => '2022-08-05 15:14:08', 'updated_at' => '2022-08-05 15:14:08'),
                array('id' => '7', 'company_id' => 1, 'damage' => 'TREAD SEPARATION', 'cause' => 'Maintenance', 'rating' => '-', 'created_at' => '2022-08-05 15:14:35', 'updated_at' => '2022-08-05 15:14:35'),
                array('id' => '8', 'company_id' => 1, 'damage' => 'SHOULDER SEPARATION', 'cause' => 'Maintenance', 'rating' => '-', 'created_at' => '2022-08-05 15:15:00', 'updated_at' => '2022-08-05 15:15:00'),
                array('id' => '9', 'company_id' => 1, 'damage' => 'RADIAL CRACK', 'cause' => 'Operational', 'rating' => '-', 'created_at' => '2022-08-05 15:15:21', 'updated_at' => '2022-08-05 15:15:21'),
                array('id' => '10', 'company_id' => 1, 'damage' => 'RUNFLAT', 'cause' => 'Operational', 'rating' => '-', 'created_at' => '2022-08-05 15:15:57', 'updated_at' => '2022-08-05 15:15:57'),
                array('id' => '11', 'company_id' => 1, 'damage' => 'WORNOUT', 'cause' => 'Normal', 'rating' => '-', 'created_at' => '2022-08-05 15:16:13', 'updated_at' => '2022-08-05 15:16:13'),
                array('id' => '12', 'company_id' => 1, 'damage' => 'IRREGULAR WEAR', 'cause' => 'Maintenance', 'rating' => '-', 'created_at' => '2022-08-05 15:16:32', 'updated_at' => '2022-08-05 15:16:32'),
                array('id' => '13', 'company_id' => 1, 'damage' => 'CENTER WEAR', 'cause' => 'Maintenance', 'rating' => '-', 'created_at' => '2022-08-05 15:18:25', 'updated_at' => '2022-08-05 15:18:25'),
                array('id' => '14', 'company_id' => 1, 'damage' => 'EXPOSE PLY', 'cause' => 'Maintenance', 'rating' => '-', 'created_at' => '2022-08-05 15:18:43', 'updated_at' => '2022-08-05 15:18:43'),
                array('id' => '15', 'company_id' => 1, 'damage' => 'TREAD CHIPPING', 'cause' => 'Operational', 'rating' => '-', 'created_at' => '2022-08-05 15:18:59', 'updated_at' => '2022-08-05 15:18:59'),
                array('id' => '16', 'company_id' => 1, 'damage' => 'TREAD CHUNKING', 'cause' => 'Operational', 'rating' => '-', 'created_at' => '2022-08-05 15:19:33', 'updated_at' => '2022-08-05 15:19:33'),
                array('id' => '17', 'company_id' => 1, 'damage' => 'SEIZED BRAKES', 'cause' => 'Maintenance', 'rating' => '-', 'created_at' => '2022-08-05 15:22:53', 'updated_at' => '2022-08-05 15:22:53'),
                array('id' => '18', 'company_id' => 1, 'damage' => 'TREAD LIFTING', 'cause' => 'Operational', 'rating' => '-', 'created_at' => '2022-08-05 15:23:12', 'updated_at' => '2022-08-05 15:23:12'),
                array('id' => '19', 'company_id' => 1, 'damage' => 'HEAT SEPARATION', 'cause' => 'Maintenance', 'rating' => '-', 'created_at' => '2022-08-05 15:23:29', 'updated_at' => '2022-08-05 15:23:29'),
                array('id' => '20', 'company_id' => 1, 'damage' => 'INNERLINER FATIQUE', 'cause' => 'Maintenance', 'rating' => '-', 'created_at' => '2022-08-05 15:23:54', 'updated_at' => '2022-08-05 15:23:54'),
                array('id' => '21', 'company_id' => 1, 'damage' => 'ACCIDENTAL DAMAGE', 'cause' => 'Operational', 'rating' => '-', 'created_at' => '2022-08-05 15:24:18', 'updated_at' => '2022-08-05 15:24:18'),
                array('id' => '22', 'company_id' => 1, 'damage' => 'FOREIGN OBJECT', 'cause' => 'Operational', 'rating' => '-', 'created_at' => '2022-08-05 15:24:45', 'updated_at' => '2022-08-05 15:24:45'),
                array('id' => '23', 'company_id' => 1, 'damage' => 'IMPACT', 'cause' => 'Operational', 'rating' => '-', 'created_at' => '2022-08-05 15:25:01', 'updated_at' => '2022-08-05 15:25:01'),
                array('id' => '24', 'company_id' => 1, 'damage' => 'REPAIR FAILURE', 'cause' => 'Maintenance', 'rating' => '-', 'created_at' => '2022-08-05 15:25:22', 'updated_at' => '2022-08-05 15:25:22'),
                array('id' => '25', 'company_id' => 1, 'damage' => 'ROCK BETWEEN DUAL', 'cause' => 'Operational', 'rating' => '-', 'created_at' => '2022-08-05 15:25:43', 'updated_at' => '2022-08-05 15:25:43'),
                array('id' => '26', 'company_id' => 1, 'damage' => 'RIM DAMAGE', 'cause' => 'Operational', 'rating' => '-', 'created_at' => '2022-08-05 15:26:09', 'updated_at' => '2022-08-05 15:26:09'),
                array('id' => '27', 'company_id' => 1, 'damage' => 'VALVE DAMAGE', 'cause' => 'Maintenance', 'rating' => '-', 'created_at' => '2022-08-05 15:26:32', 'updated_at' => '2022-08-05 15:26:32'),
                array('id' => '28', 'company_id' => 1, 'damage' => 'ORING DAMAGE', 'cause' => 'Maintenance', 'rating' => '-', 'created_at' => '2022-08-05 15:27:20', 'updated_at' => '2022-08-05 15:27:20'),
                array('id' => '29', 'company_id' => 1, 'damage' => 'STUD DAMAGE', 'cause' => 'Maintenance', 'rating' => '-', 'created_at' => '2022-08-05 15:27:45', 'updated_at' => '2022-08-05 15:27:45'),
                array('id' => '30', 'company_id' => 1, 'damage' => 'BURSTING', 'cause' => 'Operational', 'rating' => '-', 'created_at' => '2022-08-05 15:28:21', 'updated_at' => '2022-08-05 15:28:21'),
                array('id' => '31', 'company_id' => 1, 'damage' => 'ROTASI', 'cause' => 'Maintenance', 'rating' => '-', 'created_at' => '2022-08-05 15:31:29', 'updated_at' => '2022-08-05 15:31:29'),
                array('id' => '32', 'company_id' => 1, 'damage' => 'MATCHING', 'cause' => 'Maintenance', 'rating' => '-', 'created_at' => '2022-08-05 15:31:41', 'updated_at' => '2022-08-05 15:31:41'),
                array('id' => '33', 'company_id' => 1, 'damage' => 'STONE DRILLING', 'cause' => 'Operational', 'rating' => '-', 'created_at' => '2022-08-31 08:59:53', 'updated_at' => '2022-08-31 08:59:53')
            )
        );
        // TireMaster::factory()->count(1000)->create();
        // Unit::factory()->count(100)->create();

        // $unit = Unit::limit(10)->get();
        // foreach ($unit as $key => $value) {
        //     for ($i = 0; $i < $value->unit_model->tire_qty; $i++) {
        //         $tire = TireMaster::where("tire_status_id", 1)->inRandomOrder()->first();
        //         $tirerunning = TireRunning::create([
        //             "unit_id" => $value->id,
        //             "tire_id" => $tire->id,
        //             "site_id" => 1,
        //             "company_id" => 1,
        //             "position" => $i + 1,
        //         ]);
        //         TireMovement::create([
        //             "tire_running_id" => $tirerunning->id,
        //             "hm" => 0,
        //             "km" => 0,
        //             "unit_lifetime_hm" => $value->hm,
        //             "unit_lifetime_km" => $value->km,
        //             "tire_lifetime_hm" => $tire->lifetime_hm,
        //             "tire_lifetime_km" => $tire->lifetime_km,
        //             "rtd" => $tire->rtd,
        //             "start_date" => \Carbon\Carbon::now(),
        //             "end_date" => \Carbon\Carbon::now(),
        //             "pic" => fake()->name(),
        //             "pic_man_power" => fake()->firstNameMale(),
        //             "desc" => "install"
        //         ]);
        //         $tire->tire_status_id = 6;
        //         $tire->save();

        //         HistoryTireMovement::create(
        //             [
        //                 "user_id" => 1,
        //                 "company_id" => 1,
        //                 "site_id" => 1,
        //                 "unit" => $value->unit_number,
        //                 "tire" => $tire->serial_number,
        //                 "position" => $i + 1,
        //                 "status" => "RUNNING",
        //                 "km_unit_install" => $value->km,
        //                 "hm_unit_install" => $value->hm,
        //                 "pic" => fake()->firstNameMale(),
        //                 "pic_man_power" => fake()->firstNameMale(),
        //                 "des" => "Install",
        //                 "km_tire_install" => $tire->lifetime_km,
        //                 "hm_tire_install" => $tire->lifetime_km,
        //                 "start_date" => \Carbon\Carbon::now(),
        //                 "end_date" => \Carbon\Carbon::now()
        //             ]
        //         );
        //     }
        // }

    }
}
