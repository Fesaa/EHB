<?php

namespace Database\Seeders;

use App\Models\Forum;
use App\Models\Post;
use App\Models\Thread;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SetupDefaultContent extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $TALK_CORNER_FORUM = Forum::factory()->create([
            'title' => 'Talk Corner',
            'subtitle' => 'A place to talk about anything.',
            'description' => 'You can post [b] anything [/b] here, as long as you\'re respectful. Go all out on the crazy question and stories, we\'re all here to listen <3',
            'image_id' => 6,
        ]);

        $FAQ = Forum::factory()->create([
            'title' => 'FAQ',
            'subtitle' => 'Frequently Asked Questions',
            'description' => 'This is a place to ask questions about the site, and get answers from the community. If you have a question, ask away!',
            'image_id' => 7,
        ]);

        $COMING_OUT = Thread::factory()->create([
            'forum_id' => $TALK_CORNER_FORUM->id,
            'user_id' => 2,
            'banner_id' => 8,
            'title' => 'Coming out (gone good)',
            'content' => "[center][size=4][color=#800080]🌈 Coming Out Success Story 🌈[/color][/size][/center]

Hey there, fellow forum members! I wanted to share my heartwarming experience of coming out to my parents as gay. It was a significant moment in my life, and I hope it can inspire and provide some hope for those who might still be on their journey.

I decided to sit down with my parents one evening, nervous but determined. I explained to them that I had something important to share. As I spoke my truth, their initial expressions of surprise and concern gradually shifted into understanding and support. They asked questions, not to judge, but to learn and empathize. The love they showed me in that moment was overwhelming, and I could see their desire to see me happy and authentic.

Fast forward to today, and I can proudly say that my relationship with my parents has only grown stronger. They've embraced my identity with open arms, and we've had so many heartfelt conversations since that day. I couldn't be happier or more grateful for their acceptance and love. Remember, there's always hope, and the people who truly care about you will accept you for who you are. 🏳️‍🌈❤️"
        ]);

        $APPLYING_FOR_STAFF = Thread::factory()->create([
            'forum_id' => $FAQ->id,
            'user_id' => 1,
            'title' => 'Applying for staff',
            'content' => "[center][size=4][color=#003366]🌐 Forum Moderation Application 🌐[/color][/size][/center]

Dear [color=#FF6600]Community Members[/color],

Exciting news! We're looking for [b]Forum Moderators[/b] to join our team. If you're passionate about maintaining a positive community, follow these steps:

1. [b]Visit our Website:[/b] Log in to your forum account on our website.

2. [b]Access the Application Form:[/b] Go to the Moderation Application section.

3. [b]Complete the Form:[/b] Provide your info, qualifications, and reasons for applying.

4. [b]Submit:[/b] Check your responses and submit your application.

[b]Application Deadline:[/b] Open until [color=#FF0000]DD/MM/YYYY[/color].

Your dedication helps us keep our community respectful. Contact [color=#003399]Community Management[/color] for questions.

Thank you for making our forum a great place!

Best regards,
HoloShop Team",
        ]);
    }
}
