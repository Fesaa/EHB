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
        Asset::factory()->create([ // 1
            'url' => 'https://pvprp.com/assets/profiles/37642/pfp.png'
        ]);

        Asset::factory()->create([ // 2
            'url' => 'https://images.hitpaw.com/topics/video-tips/cute-anime-1.jpg'
        ]);

        Asset::factory()->create([ // 3
            'url' => 'https://upload.wikimedia.org/wikipedia/commons/8/84/JohnDonahoe.jpg'
        ]);

        Asset::factory()->create([ // 4
            'url' => 'https://static.vecteezy.com/system/resources/previews/027/775/631/non_2x/sunset-in-the-field-cute-kawaii-lo-fi-background-fluffy-clouds-park-2d-cartoon-landscape-illustration-lofi-aesthetic-wallpaper-desktop-japanese-anime-scenery-dreamy-vibes-vector.jpg'
        ]);

        Asset::factory()->create([ // 5
            'url' => 'https://i.pinimg.com/originals/42/61/ff/4261ffdc43c5269ab0683e9fac1bf281.jpg'
        ]);

        Asset::factory()->create([ // 6
           'url' => 'https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Ftse1.mm.bing.net%2Fth%3Fid%3DOIP.uEF9IS9GSVuKJ2tM9r1hYAHaE1%26pid%3DApi&f=1&ipt=cff662be7f30dedff9904726e213aa2049e1815e46824e8d59062589e6bd807e&ipo=images',
        ]);

        Asset::factory()->create([ // 7
            'url' => 'https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fpng.pngtree.com%2Fpng-vector%2F20210913%2Fourmid%2Fpngtree-faq-button-icon-png-image_3927269.jpg&f=1&nofb=1&ipt=eb06fc4208a1cba762e11b3ef004f878d90ab19da21526df238293d2546d6e88&ipo=images',
        ]);

        Asset::factory()->create([ // 8
           'url' => 'https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fwww.dxw.com%2Fwp-content%2Fthemes%2Fdxw-theme-2020%2Fstatic%2Fimg%2Flgbti-flag.png&f=1&nofb=1&ipt=8f6dc4e56354726f823737d49117a4004c93d0e9b7430d3184bcc1dea298c8cb&ipo=images'
        ]);

        Asset::factory()->create([ // 9
           'url' => 'https://i.pinimg.com/originals/a4/76/3b/a4763bc1588a85387b21d9dc3c4fdf1a.jpg'
        ]);

        Asset::factory()->create([ // 10
            'url' => 'https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fstatic.vecteezy.com%2Fsystem%2Fresources%2Fpreviews%2F000%2F571%2F059%2Foriginal%2Fvector-newspaper-icon.jpg&f=1&nofb=1&ipt=a8b37fdc7e72a025f72e0d2804b169b25d05930d8a7200606c73a880c3a8b621&ipo=images'
        ]);

        Asset::factory()->create([ // 11
           'url' => 'https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fimages.genius.com%2Fc267f04961f93db913a55906e51201b3.1000x1000x1.png&f=1&nofb=1&ipt=4e644b1350d3eda41b661d4d8363c1e91f9bdfbeac4786d8d7ee08f19968d625&ipo=images'
        ]);

        Asset::factory()->create([ // 12
            'url' => 'https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fporch.com%2Fadvice%2Fwp-content%2Fuploads%2F2020%2F09%2FiStock-1152164476.jpg&f=1&nofb=1&ipt=c7880f5c629f6cd2c06945649433f8cb42d6ffeeadb880c43ffc1b36a0ee4f98&ipo=images'
        ]);

        Asset::factory()->create([ // 13
            'url' => 'https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fi.pinimg.com%2Foriginals%2F2c%2F6d%2F55%2F2c6d55161b62332ace235a69805bd797.jpg&f=1&nofb=1&ipt=c00d96195152ae5092446c5a4ab775198e614bc39399858499004a7aac3ed03b&ipo=images'
        ]);

        Asset::factory()->create([ // 14
            'url' => 'https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Ftse1.mm.bing.net%2Fth%3Fid%3DOIP.kgjGEvtnQwKlBSwPAzbHlwHaD4%26pid%3DApi&f=1&ipt=1192363fed075fbca0b069a5044bfa25cc5efe2ff0d9a4ffdf3b80505b1ac80f&ipo=images'
        ]);

        Asset::factory()->create([ // 15
           'url' => 'https://external-content.duckduckgo.com/iu/?u=http%3A%2F%2Ficons.iconarchive.com%2Ficons%2Fthesquid.ink%2Ffree-flat-sample%2F1024%2Fsupport-icon.png&f=1&nofb=1&ipt=7bff375836a6b16eb4ca167d0b4bfa967a48bba1db1760156f390cb49f7742fb&ipo=images'
        ]);
    }
}
