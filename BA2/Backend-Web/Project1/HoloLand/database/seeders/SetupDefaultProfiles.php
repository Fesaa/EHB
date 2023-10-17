<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class SetupDefaultProfiles extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $founder = User::where(['name' => 'Amelia'])->first();
        $moderator = User::where(['name' => 'Rebecca'])->first();
        $ehb = User::where(['name' => 'admin'])->first();

        $founder->populateFields();
        $moderator->populateFields();
        $ehb->populateFields();

        $profile = $founder->profile();
        $profile->title = 'Founder';
        $profile->pfp_asset_id = 1;
        $profile->banner_asset_id = 4;
        $profile->bio = "Hey there, fabulous forum fanatics! 🌟 I'm the [b]quirky queen bee[/b] behind this online hangout, and let me tell you, it's all about bringing the sparkle to your digital life! 👑✨ When I'm not dreaming up emojis or sipping on unicorn lattes (extra glitter, please), you can find me navigating the wacky world of internet with the same passion and zeal as a puppy chasing its tail. I believe that our forum is more than just a place to chat; it's a vibrant, virtual garden where friendships bloom and ideas take flight. So, grab your coffee, throw on your favorite emoji pajamas, and let's spread the love and laughter, one post at a time! 💬💕";
        $profile->save();

        $profile = $moderator->profile();
        $profile->title = 'Moderator';
        $profile->pfp_asset_id = 2;
        $profile->bio = "Hello, fabulous forum fam! ✨I'm the volunteer moderator with a sprinkle of glitter and a whole lot of heart! 🌟🦄 I might not have a superhero cape, but I'm here to save the day (and your sanity) by keeping our forum as bubbly and positive as a champagne toast at a unicorn-themed birthday party. When I'm not chasing rainbows or perfecting my emoji game, I'm on a mission to make sure this forum is a place where every member feels heard and loved. 🌈💬 So, whether you need help, a friendly chat, or just a virtual hug, I'm your gal! Let's make this digital world a little more magical, one sparkly post at a time. 😄💖";
        $profile->save();

        $profile = $ehb->profile();
        $profile->pfp_asset_id = 3;
        $profile->banner_asset_id = 5;
        $profile->bio = "Greetings to the community, I'm the administrator and caretaker of our cherished forum, and it's a privilege to be entrusted with the responsibility of maintaining this thriving digital space. While I might not be donning a cape, I do consider myself a guardian of order and civility in our online home. My goal is to ensure that our forum remains a respectful and informative environment, where ideas can be shared, questions can be answered, and camaraderie can flourish. I'm dedicated to upholding the rules, preserving the quality of discussions, and providing the support needed to keep this community strong. If you ever have questions or concerns, don't hesitate to reach out. Let's work together to make this forum the best it can be.";
        $profile->save();

    }
}
