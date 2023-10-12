<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Privilege;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseDefaults extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        Privilege::factory()->create([
            'name' => 'VIEW_SITE',
            'description'=> 'Default privilege for everyone. Removed to ban users',
            'value' => 1 << 25
        ]);

        Privilege::factory()->create([
            'name' => 'VIEW_LOGIN_LOGS',
            'description'=> 'View login logs',
            'value' => 1 << 1
        ]);

        $staff = Role::factory()->create([
            'name' => 'Staff',
            'description' => 'Staff role - has no privileges',
            'privilege' => -1
        ]);

        $admin = Role::factory()->create([
            'name' => 'Admin',
            'description' => 'Admin role',
            'privilege' => 1 << 1 | 1 << 2
        ]);

        $user = User::factory()->create([
            'name' => 'Amelia',
            'email' => 'amelia@localhost',
            'password' => bcrypt('password')
        ]);

        $user->roles()->attach($admin);
        $user->roles()->attach($staff);
    }
}
