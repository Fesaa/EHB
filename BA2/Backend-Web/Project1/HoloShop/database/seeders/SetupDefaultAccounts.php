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
            'Luna Starlight' => "Hey there, I'm Luna Starlight, and I'm absolutely starry-eyed about the night sky! When I'm not chatting with you all, I'm wrapped up in my cozy blanket, sipping moonlight tea, and gazing at the stars. You can often find me lost in thought, penning poetry inspired by the cosmos. Let's journey through the universe together, one twinkling star at a time!",
            'Captain Crunch' => "Ahoy, me hearties! I'm Captain Crunch, a true seafarer at heart. When I'm not sharing tales of nautical adventures, I'm out there plundering buried treasure and exploring the seven seas. Join me for some swashbuckling stories and salty sea dog banter. Bring your spyglass and let's set sail together!",
            'Ruby Redd' => "Hey, I'm Ruby Redd, your resident dancing diva! When I'm not shaking a leg or dazzling the digital dance floor, I'm here to spill the tea on style, makeup, and all things fabulous. Get ready to groove with me and embrace the glam life. Let's make every day a runway!",
            'Galaxy Explorer' => "Greetings, fellow space enthusiasts! I'm Galaxy Explorer, and my passion is uncovering the mysteries of the cosmos. With my trusty telescope in hand, I'll take you on interstellar journeys through black holes, alien encounters, and everything in between. So, fasten your seatbelts, because we're in for an epic starship ride to remember!",
            'Max Thunderbolt' => "What's up, thrill-seekers? I'm Max Thunderbolt, and I live for the adrenaline rush. When I'm not sharing my daring escapades and extreme sports experiences, you'll find me on the edge of excitement. From skydiving to storm-chasing, it's all about that electrifying thrill. So, buckle up and get ready for a jolt of excitement!",
        ];

        foreach ($funNames as $name => $bio) {
            $email = strtolower(str_replace(' ', '.', $name)) . '@example.com';
            $password = bcrypt('password');

            $user = User::factory()->create([
                'name' => $name,
                'email' => $email,
                'password' => $password,
            ]);

            $user->roles()->attach($MEMBER);

            $profile = $user->profile();
            $profile->bio = $bio;
            $profile->save();
        }
    }
}
