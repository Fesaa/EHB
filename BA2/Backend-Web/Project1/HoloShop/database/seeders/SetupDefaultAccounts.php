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
        $MEMBER = Role::where(['name' => 'MEMBER'])->first();

        $admin_account = User::factory()->create([
            'name' => 'Amelia',
            'email' => 'founder@localhost',
            'password' => bcrypt('password'),
        ]);

        $admin_account->roles()->attach($ADMIN);
        $admin_account->roles()->attach($STAFF);

        $moderator_account = User::factory()->create([
            'name' => 'Rebecca',
            'email' => 'moderator@localhost',
            'password' => bcrypt('password'),
        ]);

        $moderator_account->roles()->attach($MODERATOR);
        $moderator_account->roles()->attach($STAFF);

        $ehb_account = User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@ehb.be',
            'password' => bcrypt('Password!124'),
        ]);

        $ehb_account->roles()->attach($ADMIN);
        $ehb_account->roles()->attach($STAFF);

        $funNames = [
            'Luna Starlight',
            'Captain Crunch',
            'Ruby Redd',
            'Galaxy Explorer',
            'Max Thunderbolt'
        ];

        foreach ($funNames as $name) {
            $email = strtolower(str_replace(' ', '.', $name)) . '@example.com';
            $password = bcrypt('password');

            $user = User::factory()->create([
                'name' => $name,
                'email' => $email,
                'password' => $password,
            ]);

            $user->roles()->attach($MEMBER);
        }
    }
}
