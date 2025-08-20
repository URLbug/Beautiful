<?php

namespace Database\Seeders;

use App\Modules\Master\Models\User;
use App\Modules\Profile\Models\Comment;
use App\Modules\Profile\Models\Like;
use App\Modules\Profile\Models\Post;
use Couchbase\Role;
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

        \App\Modules\Master\Models\Role::create([
            'name' => 'admin',
            'slug' => 'admin',
            'permissions' => 1
        ]);

        \App\Modules\Master\Models\Role::create([
            'name' => 'user',
            'slug' => 'user',
            'permissions' => 3
        ]);

        User::factory()->create([
            'username' => 'admin',
            'email' => 'admin@admin.com',
            'password' => env('ADMIN_PASSWORD'),
            'role_id' => 1
        ]);

        if(env('APP_ENV') !== 'production') {
            Post::factory(10)->create();
            Comment::factory(30)->create();
            Like::factory(10)->create();
        }
    }
}
