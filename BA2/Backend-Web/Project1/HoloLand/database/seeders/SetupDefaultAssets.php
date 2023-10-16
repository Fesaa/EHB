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

        Asset::factory()->create([
           'url' => 'https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Ftse1.mm.bing.net%2Fth%3Fid%3DOIP.uEF9IS9GSVuKJ2tM9r1hYAHaE1%26pid%3DApi&f=1&ipt=cff662be7f30dedff9904726e213aa2049e1815e46824e8d59062589e6bd807e&ipo=images',
        ]);

        Asset::factory()->create([
            'url' => 'https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fpng.pngtree.com%2Fpng-vector%2F20210913%2Fourmid%2Fpngtree-faq-button-icon-png-image_3927269.jpg&f=1&nofb=1&ipt=eb06fc4208a1cba762e11b3ef004f878d90ab19da21526df238293d2546d6e88&ipo=images',
        ]);

        Asset::factory()->create([
           'url' => 'https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fwww.dxw.com%2Fwp-content%2Fthemes%2Fdxw-theme-2020%2Fstatic%2Fimg%2Flgbti-flag.png&f=1&nofb=1&ipt=8f6dc4e56354726f823737d49117a4004c93d0e9b7430d3184bcc1dea298c8cb&ipo=images'
        ]);
    }
}
