<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Privilege;
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
            'value' => 1 << 100
        ]);

        Privilege::factory()->create([
            'name' => 'STAFF',
            'description'=> 'View login logs',
            'value' => 1 << 1
        ]);

        Privilege::factory()->create([
            'name' => 'VIEW_LOGIN_LOGS',
            'description'=> 'View login logs',
            'value' => 1 << 2
        ]);

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@localhost',
            'password' => bcrypt('admin'),
            'privilege' => 1 << 1 | 1 << 2
        ]);

    }
}
