<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class SetupDefaultAccounts extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ADMIN = Role::where(['name' => 'ADMIN'])->first();
        $MODERATOR = Role::where(['name' => 'MODERATOR'])->first();
        $STAFF = Role::where(['name' => 'STAFF'])->first();

        $admin_account = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@localhost',
            'password' => bcrypt('password'),
        ]);

        $admin_account->roles()->attach($ADMIN);
        $admin_account->roles()->attach($STAFF);

        $moderator_account = User::factory()->create([
            'name' => 'Moderator',
            'email' => 'moderator@localhost',
            'password' => bcrypt('password'),
        ]);

        $moderator_account->roles()->attach($MODERATOR);
        $moderator_account->roles()->attach($STAFF);


    }
}
