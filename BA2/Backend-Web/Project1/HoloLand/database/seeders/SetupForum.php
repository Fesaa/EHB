<?php

namespace Database\Seeders;

use App\Models\Forum;
use App\Models\Post;
use App\Models\Privilege;
use App\Models\Thread;
use App\Models\ThreadForm;
use Illuminate\Database\Seeder;

class SetupForum extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->news();
        $this->talkCorner();
        $this->HomeMatters();
        $this->FAQ();
        $this->Support();
    }

    private function news(): void
    {
        Forum::factory()->create([
            'title' => 'News',
            'subtitle' => 'All things HoloLand',
            'description' => "Welcome to the HoloLand News Forum, your gateway to the latest and greatest happenings in the world of anime and all things we love. 🌟 Our team of dedicated moderators and contributors work tirelessly to keep you updated on the most recent releases, announcements, and trends within the anime community. Whether it's breaking news about upcoming seasons, convention coverage, or exclusive interviews with your favorite creators, you'll find it all here.

Engage in discussions, share your thoughts, and dive deep into the world of anime news. Stay in the loop and be the first to know about the exciting developments and events that shape the anime universe. The News Forum is your source for staying connected to the pulse of HoloLand and the anime realm at large.",
            'image_id' => 10,
        ]);

        Thread::factory()->create([
            'forum_id' => 1,
            'user_id' => 1,
            'banner_id' => 13,
            'title' => "🎉🎈 Grand Opening Celebration! 🎈🎉",
            'content' => "Ladies and gentlemen, anime enthusiasts of HoloLand, it's time to break out the confetti, put on your party hats, and celebrate the GRAND OPENING of our spectacular News Forum! 🥳📢

We're absolutely thrilled to bring you the latest, the greatest, and the most sensational news from the world of anime. 🌟 Our team of moderators and contributors have been burning the midnight oil to make this happen, and now it's your turn to join in on the fun!

📣 What to Expect?

    [*] Breaking News 🚀
    [*] Exclusive Interviews with Creators 🎤
    [*] Convention Coverage 🌆
    [*] In-Depth Analysis 🤓
    [*] And So Much More!

🎉 So, how do we celebrate? 🎉

    Share your all-time favorite anime GIFs, memes, or moments. Let's flood this thread with anime goodness!
    Tell us about the anime that ignited your passion and love for this incredible world. 🙌
    Give a shout-out to your favorite characters, series, or voice actors. Who's your ultimate anime hero? 🦸‍♂️
    Recommend an anime gem to your fellow otaku. Spread the love! ❤️

Feel the excitement in the air? It's palpable! 🥰 Join the fun, let's celebrate, and let the anime discussions flow! 🎊🥂

[center][img]https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fmedia1.tenor.com%2Fimages%2F07869599e4a13f14ed4a6425c835537a%2Ftenor.gif%3Fitemid%3D15417564&f=1&nofb=1&ipt=c5572544d0071db56b536a227a230e6fcd6110aaee1e2fbc27e8b5b138f17add&ipo=images[/img][/center]

[i]🎉🌟 Let the Grand Opening festivities begin! 🌟🎉[/i]",
            'featured' => true,
            'created_at' => (new \DateTime())->sub(new \DateInterval('P2D')),
            'updated_at' => (new \DateTime())->sub(new \DateInterval('P2D')),
        ]);

        Thread::factory()->create([
           'forum_id' => 1,
           'user_id' => 2,
           'banner_id' => 14,
           'title' => "🏡 Home Matters: Open Hearts, Open Always! 🏡",
           'content' => "Dear HoloLand Family,

We are thrilled to introduce the warm and welcoming \"Home Matters\" forum, where you can pour your heart out, 24/7. 💕🏡

In Home Matters, we understand that life isn't just about anime and fandoms; it's about the personal, the intimate, and the everyday struggles and joys that make us who we are. This forum is your safe space to share your stories, ask for advice, and offer support to fellow members. It's a place to celebrate the joys of home life and seek solace during the tougher moments.

🌟 Why \"Home Matters\"?

    We believe in the power of community, and that means being there for each other, especially when life gets real.
    Whether it's family, relationships, self-care, or the ups and downs of everyday life, this is where you can find a listening ear and a supportive heart.

🤗 What Can You Do Here?

    [*] Share your personal stories, challenges, and triumphs.
    [*] Offer advice and a helping hand to those who need it.
    [*] Create a bond with fellow members based on shared experiences.

Your home life is a significant part of who you are, and we want to be there for you through it all. So, don't hesitate to open up and let your heart out. Whether you're celebrating a family milestone or seeking guidance through a tough time, Home Matters is here to embrace you with open arms.

This forum is open, 24/7, for you to share, care, and connect. We look forward to seeing you in Home Matters, where open hearts are always welcome! 💖🏡

[i]🏡 Your home away from home - Home Matters: Where open hearts thrive![/i]",
            'created_at' => (new \DateTime())->sub(new \DateInterval('P1D')),
            'updated_at' => (new \DateTime())->sub(new \DateInterval('P1D')),
        ]);
    }

    private function talkCorner(): void
    {
        Forum::factory()->create([
           'title' => 'Talk Corner',
           'subtitle' => 'A place to talk about anything.',
            'description' => "In the Talk Corner at HoloLand, you have a cozy space to share your thoughts, insights, and opinions about everything anime-related. 🌸 This is where our community comes together to discuss their favorite series, characters, and episodes. Whether you're a seasoned otaku or just dipping your toes into the world of anime, this corner is perfect for you. Engage in lively conversations, explore fan theories, and discover new gems recommended by fellow members.

Our friendly and passionate community is always ready to welcome you and encourage meaningful discussions. No matter your level of anime knowledge, you'll find kindred spirits in the Talk Corner. Share your passion, make friends, and immerse yourself in the vibrant world of anime conversations!",
            'image_id' => 11,
        ]);

        Thread::factory()->create([
            'forum_id' => 2,
            'user_id' => 4,
            'title' => '🌟 My First Cosplay Adventure! 🌟',
            'content' => "Hey, fellow anime enthusiasts of HoloLand! 🎉

I just had to share this incredibly exciting moment with you all - I've just had my very first cosplay experience, and I couldn't be more thrilled! 🤩

So, I decided to step into the world of cosplaying as [color=#ff0000][b]Naruto Uzumaki[/b][/color] from Naruto - one of my all-time favorite characters! 🍥 Believe it or not, I spent weeks perfecting the outfit, and the result was beyond my wildest expectations.

Cosplay Highlights:

    [*] I practiced Naruto's signature \"Shadow Clone Jutsu\" moves for weeks (and almost knocked over some furniture! 😆).
    [*] I couldn't stop grinning the moment I put on the iconic headband.
    [*] My friends couldn't recognize me - mission accomplished!
    [*] Attending an anime convention as Naruto was an absolute blast, and the reactions from fellow fans were priceless.

Now, here's the exciting part – I'd love to hear your first cosplay stories, too! What character did you embody, and how did you feel in that amazing moment when you brought your favorite character to life? Share your anecdotes, photos, and lessons learned. We're all ears! 🤗

Let's relive the magic of our first cosplay adventures together and inspire future cosplayers within our HoloLand community. Cosplay brings us closer to the characters we adore, and sharing these experiences brings us even closer as a community of passionate fans.

So, don't be shy – spill the beans on your first cosplay journey, and let's celebrate the vibrant world of anime and cosplay! 🌟

[i]🌟 Cosplay - Where fantasy becomes reality, and community becomes family! 🌟[/i]",
            'created_at' => (new \DateTime())->sub(new \DateInterval('PT5H')),
            'updated_at' => (new \DateTime())->sub(new \DateInterval('PT5H')),
        ]);

        Thread::factory()->create([
            'forum_id' => 2,
            'user_id' => 5,
            'title' => '📚 My First Day of School Adventure! 📚',
            'content' => "Hello, fellow HoloLand members! 🌈

Today is a day I've been looking forward to for a long time, and I couldn't wait to share it with all of you. 🎉 It's my very first day of school! 📝

The excitement and nervousness were swirling inside me as I put on my school uniform, grabbed my backpack, and took that first step into the schoolyard. It felt like the start of a brand new adventure!

First Day Highlights:

    [*] Meeting new friends and feeling that instant connection.
    [*] The butterflies in my stomach during the first class.
    [*] The awe of exploring a new place filled with knowledge and possibilities.
    [*] That overwhelming sense of growing up.

I'm sharing this with you all because I'd love to hear about your first day of school experiences too. How did you feel? What was the most memorable part of that special day for you? Let's talk about our shared journey through the world of education and growing up!

Remembering our first days at school is not just nostalgic; it's a reminder of how we've grown and learned along the way. So, feel free to share your stories, photos, and words of wisdom. Whether you're a student, a teacher, or a proud parent, your school experiences are worth celebrating!

Let's make this thread a place of inspiration and reflection, celebrating the beginning of every young scholar's journey.

[i]📚 Education is the key to unlocking our potential, and our stories are the ink in the book of life. 📚[/i]",
            'created_at' => (new \DateTime())->sub(new \DateInterval('PT3H')),
            'updated_at' => (new \DateTime())->sub(new \DateInterval('PT3H')),
        ]);
    }

    private function HomeMatters(): void
    {
        Forum::factory()->create([
           'title' => '🏡 Home Matters 🏡',
           'subtitle' => 'For all matters close to home and heart',
           'description' => "Welcome to Home Matters, the place where HoloLand members come together to share their most personal experiences, seek advice, and provide support. 🌟 In this intimate corner of our community, we invite you to discuss the ups and downs of life happening within the walls of your home. Whether it's about family, relationships, self-care, or everyday challenges, this is where you can open your heart.

Home Matters is a safe haven for conversations that touch the core of our lives. 🤗 Share your stories, offer a listening ear, and connect with fellow members on a deeply personal level. We believe that sometimes the most valuable discussions happen when we talk about the things that matter most to us.

Join us in embracing the warmth of our community, as we navigate the joys and tribulations of home life. 🏠 Home Matters is where HoloLand members come together to support and uplift one another in the journey of life's most personal chapters.",
            'image_id' => 12,
        ]);

        $COMING_OUT = Thread::factory()->create([
            'forum_id' => 3,
            'user_id' => 7,
            'banner_id' => 8,
            'title' => 'Coming out (gone good)',
            'content' => "[center][size=4][color=#800080]🌈 Coming Out Success Story 🌈[/color][/size][/center]

Hey there, fellow forum members! I wanted to share my heartwarming experience of coming out to my parents as gay. It was a significant moment in my life, and I hope it can inspire and provide some hope for those who might still be on their journey.

I decided to sit down with my parents one evening, nervous but determined. I explained to them that I had something important to share. As I spoke my truth, their initial expressions of surprise and concern gradually shifted into understanding and support. They asked questions, not to judge, but to learn and empathize. The love they showed me in that moment was overwhelming, and I could see their desire to see me happy and authentic.

Fast forward to today, and I can proudly say that my relationship with my parents has only grown stronger. They've embraced my identity with open arms, and we've had so many heartfelt conversations since that day. I couldn't be happier or more grateful for their acceptance and love. Remember, there's always hope, and the people who truly care about you will accept you for who you are. 🏳️‍🌈❤️",
            'featured' => true,
        ]);

        Post::factory()->create([
            'thread_id' => $COMING_OUT->id,
            'user_id' => 1,
            'content' => "Thank you for sharing your story! I'm so happy for you, and I hope your experience can inspire others to be true to themselves. 🥰"
        ]);

        Post::factory()->create([
            'thread_id' => $COMING_OUT->id,
            'user_id' => 3,
            'content' => "I'm so glad your parents were supportive! I'm sure it took a lot of courage to come out, and I'm happy it went well. 🤗"
        ]);

        Post::factory()->create([
            'thread_id' => $COMING_OUT->id,
            'user_id' => 4,
            'content' => "That's so sweet! I'm glad you have such a loving family. 🥰"
        ]);

        Post::factory()->create([
            'thread_id' => $COMING_OUT->id,
            'user_id' => 5,
            'content' => "I'm so happy for you! I'm glad your parents were supportive. 🤗"
        ]);
    }

    private function FAQ(): void
    {
        Forum::factory()->create([
            'title' => 'FAQ',
            'subtitle' => 'Frequently Asked Questions',
            'description' => "Have questions about HoloLand or how to navigate our forum? You've come to the right place! The Frequently Asked Questions (FAQ) section is your go-to resource for finding answers to common queries, understanding our forum rules, and getting the most out of your HoloLand experience. 🌐 We've compiled a comprehensive list of FAQs to ensure you have a seamless and enjoyable stay on our platform.

Explore our FAQ to learn about account registration, post formatting, etiquette, and much more. If you can't find the answers you seek, feel free to reach out to our dedicated support team. At HoloLand, we're committed to making your anime-loving journey as smooth and enjoyable as possible. So, dive into the FAQ, and let us guide you through the wonderful world of HoloLand!",
            'image_id' => 7,
        ]);

        $APPLICATIONS = Thread::factory()->create([
           'forum_id' => 4,
           'user_id' => 3,
           'title' => '❓ Staff Applications: Currently Closed, Future Opportunities Await! ❓',
            'content' => "Greetings, HoloLand community! 👋

We've received numerous inquiries about staff applications, and we truly appreciate your enthusiasm for contributing to our vibrant community. At this time, we wanted to provide some important information about the current status of staff applications and what the future holds.

[i]🔒 Currently Closed:[/i]

As of now, we regret to inform you that staff applications are [b]closed[/b]. We're not actively seeking new staff members at this moment, as our team is working diligently to maintain the quality and functionality of our beloved forum. We believe in upholding the high standards that HoloLand is known for, and our current staff is dedicated to ensuring that our community thrives.

[i]🌟 What Does the Future Hold? 🌟[/i]

While staff applications are closed for the time being, please don't be disheartened. Opportunities may arise in the future! As our community continues to grow, we foresee potential openings for passionate individuals who want to contribute to our shared vision. When the time comes to expand our team, we will make a formal announcement and provide detailed instructions on how to apply.

[i]💬 Frequently Asked Questions 💬[/i]

We understand you might have more questions about staff applications, so here are some FAQs to address your queries:

Q: Can I submit an application even when they are closed?
A: No, we are not accepting applications during the closed period. Please wait for an official announcement regarding staff recruitment.

Q: How will I know when staff applications reopen?
A: We will notify the entire community through a dedicated announcement on the forum and provide instructions for applying.

Q: What qualities are you looking for in potential staff members?
A: When the time comes, we will outline the specific qualifications and qualities we seek in new staff members.

Thank you for your understanding, patience, and for being a valued member of our community. We appreciate your enthusiasm and look forward to the opportunity of potentially welcoming new staff members to the HoloLand team in the future.

[i]🔐 Staff applications may be closed for now, but we are excited about the possibilities that tomorrow brings. Stay tuned for future opportunities! 🌈[/i]"
        ]);

        $STAFF_LOCK = Privilege::where(['name' => "THREAD_LOCK_STAFF"])->first();

        $APPLICATIONS->locks()->attach($STAFF_LOCK);

        $RULES = Thread::factory()->create([
           'forum_id' => 4,
            'user_id' => 1,
            'title' => '📜 Forum Rules and Guidelines 📜',
            'content' => "Welcome to HoloLand's Rules and Guidelines page! We believe in maintaining a friendly, welcoming, and respectful community for all our members. To ensure a positive and enjoyable experience for everyone, please take a moment to review and abide by our forum rules. These rules are designed to foster a safe and engaging environment for discussions and interactions.

[i]📌 General Rules 📌[/i]

    [*] Be Respectful: Treat all members with kindness and respect. Harassment, bullying, hate speech, or any form of discrimination will not be tolerated.

    [*] Stay On-Topic: Keep your discussions relevant to the forum category. If you have a new topic to discuss, please create a new thread in the appropriate section.

    [*] No Spamming: Avoid posting multiple identical or irrelevant messages. Advertising, self-promotion, and excessive posting are considered spam.

    [*] Mind Your Language: Keep conversations and content family-friendly. Inappropriate, offensive, or explicit content is strictly prohibited.

    [*] Respect Privacy: Do not share personal information, including contact details, without consent. Respect the privacy of all members.

[i]📢 Posting Guidelines 📢[/i]

    [*] Use Descriptive Titles: Create thread titles that clearly reflect the content or question you're sharing.

    [*] Avoid Plagiarism: Respect copyright laws and give proper credit when sharing content or ideas that are not your own.

    [*] Quality Over Quantity: Post thoughtful, well-structured responses. Avoid one-word or low-quality responses.

    [*] Report Issues: If you encounter any rule violations or inappropriate behavior, report them to the moderation team instead of engaging in disputes.

[i]🚫 What's Not Allowed 🚫[/i]

    [*] Trolling: Deliberately provoking or annoying other members is not allowed.

    [*] Impersonation: Pretending to be someone else, including staff, is strictly forbidden.

    [*] Illegal Activities: Discussing or promoting illegal activities, is not permitted.

    [*] Multiple Accounts: Using multiple accounts for any purpose, including evading bans, is against the rules.

    [*] Breaking the Forum: Attempting to disrupt the forum's functionality or security is prohibited.

[i]👮 Enforcement and Penalties 👮[/i]

Our moderation team is here to ensure the rules are followed. Violating these rules may result in various consequences, including warnings, post removal, temporary suspensions, or, in severe cases, permanent bans. Please understand that we enforce these rules to maintain a positive and respectful community.

By participating in HoloLand, you agree to abide by these rules and guidelines. We appreciate your cooperation and look forward to an enjoyable and enriching experience for all members. If you have any questions or concerns about the rules, please feel free to reach out to the moderation team.

[i]🤝 Thank you for being a valued part of HoloLand, and enjoy your time here![/i]",
            'created_at' => (new \DateTime())->sub(new \DateInterval('PT3H54M')),
            'updated_at' => (new \DateTime())->sub(new \DateInterval('PT3H54M')),
        ]);

        $RULES->locks()->attach($STAFF_LOCK);

    }

    private function Support(): void {
        $SUPPORT = Forum::factory()->create([
            'title' => 'Support',
            'subtitle' => 'Need help? We got you covered!',
            'description' => "Welcome to the HoloLand Support Forum, where you can find answers to your questions and get help from our dedicated support team. 🌟 We understand that navigating a new platform can be challenging, so we've created this forum to provide you with the assistance you need. Whether you're having trouble with your account, need help with a technical issue, or have a general inquiry, we're here to help! Only members of our staff team, and you, can see threads you make.",
            'image_id' => 15,
            ]);

        $THREAD_CLOAK_STAFF = Privilege::where(['name' => "THREAD_CLOAK_STAFF"])->first();
        $SUPPORT->autoThreadCloaks()->attach($THREAD_CLOAK_STAFF);

        ThreadForm::factory()->create([
            'forum_id' => 5,
            'type' => 'text',
            'label' => 'Email',
            'field_count' => 0,
        ]);

        ThreadForm::factory()->create([
            'forum_id' => 5,
            'type' => 'big-text',
            'label' => 'Message',
            'description' => 'message',
            'field_count' => 2,
        ]);

        ThreadForm::factory()->create([
            'forum_id' => 5,
            'type' => 'bool',
            'label' => 'I read the FAQ',
            'field_count' => 3,
        ]);

        $THREAD = Thread::factory()->create([
            'forum_id' => 5,
            'user_id' => 7,
            'title' => 'Change email',
            'content' => "Hi! I'm a bit lost, I'm trying to change my email to newEmail@example.com but can't find how. Can you help me?",
        ]);

        // We have to manually assign the cloak here since the logic does not run database side...
        $THREAD->cloaks()->attach($THREAD_CLOAK_STAFF);
    }
}
