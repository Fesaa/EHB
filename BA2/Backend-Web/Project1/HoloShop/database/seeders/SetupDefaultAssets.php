<?php

namespace Database\Seeders;

use App\Models\Asset;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SetupDefaultAssets extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Asset::factory()->create([
            'url' => 'https://pvprp.com/assets/profiles/37642/pfp.png'
        ]);

        Asset::factory()->create([
            'url' => 'https://images.hitpaw.com/topics/video-tips/cute-anime-1.jpg'
        ]);

        Asset::factory()->create([
            'url' => 'https://upload.wikimedia.org/wikipedia/commons/8/84/JohnDonahoe.jpg'
        ]);

        Asset::factory()->create([
            'url' => 'https://static.vecteezy.com/system/resources/previews/027/775/631/non_2x/sunset-in-the-field-cute-kawaii-lo-fi-background-fluffy-clouds-park-2d-cartoon-landscape-illustration-lofi-aesthetic-wallpaper-desktop-japanese-anime-scenery-dreamy-vibes-vector.jpg'
        ]);

        Asset::factory()->create([
            'url' => 'https://i.pinimg.com/originals/42/61/ff/4261ffdc43c5269ab0683e9fac1bf281.jpg'
        ]);
    }
}
