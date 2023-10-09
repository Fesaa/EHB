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

        $user = User::factory()->create([
            'name' => 'TestUser',
            'email' => 'test2@example.com',
            'password' => bcrypt('password'), ]);

        $post1 = Post::factory()->create([
            'title' => 'Test Post',
            'content' => 'This is a test post',
            'user_id' => $user->id,
        ]);

        $post2 = Post::factory()->create([
            'title' => 'Test Post 2',
            'content' => 'This is a test post 2',
            'user_id' => $user->id,
        ]);

        Comment::factory()->create([
            'content' => 'This is a test comment',
            'user_id' => $user->id,
            'post_id' => $post1->id,
        ]);

        Comment::factory()->create([
            'content' => 'This is a test comment 2',
            'user_id' => $user->id,
            'post_id' => $post2->id,
        ]);

    }
}
