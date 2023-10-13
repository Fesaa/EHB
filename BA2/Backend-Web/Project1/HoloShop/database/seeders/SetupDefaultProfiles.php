<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SetupDefaultProfiles extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $founder = User::where(['name' => 'Founder'])->first();
        $moderator = User::where(['name' => 'Moderator'])->first();
        $ehb = User::where(['name' => 'admin'])->first();

        $profile = $founder->getProfile();
        $profile->pfp_asset_id = 1;
        $profile->banner_asset_id = 4;
        $profile->save();

        $profile = $moderator->getProfile();
        $profile->pfp_asset_id = 2;
        $profile->save();

        $profile = $ehb->getProfile();
        $profile->pfp_asset_id = 3;
        $profile->banner_asset_id = 5;
        $profile->save();

    }
}
