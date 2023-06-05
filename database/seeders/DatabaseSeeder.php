<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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

        Permission::create(['name' => 'MANAJEMEN_USER']);

        $role = Role::create(['name' => 'superadmin']);
        $role->givePermissionTo('MANAJEMEN_USER');

        $role_a = Role::create(['name' => 'admin_a']);
        $role_a->givePermissionTo('MANAJEMEN_USER');

        $role_b = Role::create(['name' => 'admin_b']);
        $role_b->givePermissionTo('MANAJEMEN_USER');

        $user = \App\Models\User::factory()->create([
            'name' => 'superadmin',
            'email' => 'superadmin@gmail.com',
        ]);
        $user->assignRole($role);

        $user_a = \App\Models\User::factory()->create([
            'name' => 'admin_a',
            'email' => 'admin_a@gmail.com',
        ]);
        $user_a->assignRole($role_a);

        $user_b = \App\Models\User::factory()->create([
            'name' => 'admin_b',
            'email' => 'admin_b@gmail.com',
        ]);
        $user_b->assignRole($role_b);


    }
}