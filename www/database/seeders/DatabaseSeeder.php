<?php

namespace Database\Seeders;

use App\Modules\Master\Models\User;
use App\Modules\Profile\Models\Comment;
use App\Modules\Profile\Models\Like;
use App\Modules\Profile\Models\Post;
use Illuminate\Database\Seeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'username' => 'admin',
            'email' => 'admin@admin.com',
        ]);

        Post::factory(10)->create();
        Comment::factory(30)->create();
        Like::factory(10)->create();
    }
}
