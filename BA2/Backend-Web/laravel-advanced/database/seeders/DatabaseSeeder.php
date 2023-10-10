<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $sarah = User::factory()->create([
            'name' => 'Sarah',
            'email' => 'sarah@example.com',
            'password' => bcrypt('password'), ]);

        $michal = User::factory()->create([
            'name' => 'Michal',
            'email' => 'michal@example.com',
            'password' => bcrypt('password'), ]);


        $emily = User::factory()->create([
            'name' => 'Emily',
            'email' => 'emily@example.com',
            'password' => bcrypt('password'), ]);


        $james = User::factory()->create([
            'name' => 'James',
            'email' => 'james@example.com',
            'password' => bcrypt('password'), ]);


        $rebecca = User::factory()->create([
            'name' => 'Rebecca',
            'email' => 'rebecca@example.com',
            'password' => bcrypt('password'), ]);


        $post1 = Post::factory()->create([
            'title' => 'Thanks for hosting!',
            'content' => 'What a lovely event! Thanks for having us. The food was delicious, and the decorations were beautiful. Cant wait for the next gathering!',
            'user_id' => $sarah->id,
        ]);

        $post2 = Post::factory()->create([
            'title' => 'Had a lot of fun!',
            'content' => 'It was a pleasure being here today. The music was fantastic, and I had a great time catching up with old friends. Thanks for the wonderful hospitality!',
            'user_id' => $michal->id,
        ]);

        Comment::factory()->create([
            'content' => 'Michael, it was so nice seeing you too! Let us not wait so long before the next get-together. 😊',
            'user_id' => $emily->id,
            'post_id' => $post2->id,
        ]);

        Comment::factory()->create([
            'content' => 'This was truly a memorable occasion. The speeches were heartfelt, and the atmosphere was warm and welcoming. Thanks for including us in your celebration!',
            'user_id' => $james->id,
            'post_id' => $post2->id,
        ]);

        Comment::factory()->create([
            'content' => 'Thanks for the kind words, Sarah. It was a pleasure having you and your family here. We hope to see you again soon!',
            'user_id' => $rebecca->id,
            'post_id' => $post1->id,
        ]);



    }
}
