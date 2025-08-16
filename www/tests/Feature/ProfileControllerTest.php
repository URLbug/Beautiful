<?php

namespace Tests\Feature;

use App\Owners\S3Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class ProfileControllerTest extends TestCase
{
    function auth_user(): void
    {
        Auth::attempt([
            'email' => 'admin@admin.com',
            'password' => 'password',
        ]);
    }

    

    public function test_base(): void
    {
        $this->auth_user();

        $response = $this->get('/profile/admin');

        $response->assertStatus(200);

        auth()->logout();
    }

    public function test_not_exists_user(): void
    {
        $this->auth_user();

        $response = $this->get('/profile/test');

        $response->assertStatus(404);

        auth()->logout();
    }

    public function test_not_auth_user(): void
    {
        $response = $this->get('/profile/admin');

        $response->assertStatus(302);
    }

    public function test_edit_description(): void
    {
        $this->auth_user();

        $response = $this->patch('/profile/admin', [
            'description' => fake()->text(),
        ]);

        $response->assertStatus(302);

        auth()->logout();
    }

    public function test_edit_description_250(): void
    {
        $this->auth_user();

        $response = $this->patch('/profile/admin', [
            'description' => fake()->text(500),
        ]);

        $response->assertStatus(302);

        auth()->logout();
    }

    public function test_edit_description_char(): void
    {
        $this->auth_user();

        $response = $this->patch('/profile/admin', [
            'description' => '😜😜😜😜',
        ]);

        $response->assertStatus(302);

        auth()->logout();
    }

    public function test_edit_socialnetworks(): void
    {
        $this->auth_user();

        $response = $this->patch('/profile/admin', [
            'github' => fake()->url(),
        ]);

        $response->assertStatus(302);

        $response = $this->patch('/profile/admin', [
            'patreon' => fake()->url(),
        ]);

        $response->assertStatus(302);

        $response = $this->patch('/profile/admin', [
            'discord' => fake()->url(),
        ]);

        $response->assertStatus(302);

        $response = $this->patch('/profile/admin', [
            'twitter' => fake()->url(),
        ]);

        $response->assertStatus(302);

        $response = $this->patch('/profile/admin', [
            'tiktok' => fake()->url(),
        ]);

        $response->assertStatus(302);

        auth()->logout();
    }

    public function test_edit_not_url(): void
    {
        $this->auth_user();

        $response = $this->patch('/profile/admin', [
            'github' => fake()->text(),
        ]);

        $response->assertStatus(302);

        $response = $this->patch('/profile/admin', [
            'patreon' => fake()->name(),
        ]);

        $response->assertStatus(302);

        $response = $this->patch('/profile/admin', [
            'discord' => fake()->city(),
        ]);

        $response->assertStatus(302);

        $response = $this->patch('/profile/admin', [
            'twitter' => fake()->randomAscii(),
        ]);

        $response->assertStatus(302);

        $response = $this->patch('/profile/admin', [
            'tiktok' => fake()->randomDigit(),
        ]);

        $response->assertStatus(302);

        auth()->logout();
    }

    // public function test_edit_picture(): void
    // {
    //     $this->auth_user();

    //     $response = $this->patch('/profile/admin', [
    //         'picture' => UploadedFile::fake()->image('test.png'),
    //     ]);

    //     $response->assertStatus(302);

    //     auth()->logout();
    // }

    // public function test_edit_picture_2(): void
    // {
    //     $this->auth_user();

    //     $response = $this->patch('/profile/admin', [
    //         'picture' => UploadedFile::fake()->image('test.png'),
    //     ]);

    //     $response->assertStatus(302);

    //     auth()->logout();
    // }

    public function test_edit_not_picture(): void
    {
        $this->auth_user();

        $response = $this->patch('/profile/admin', [
            'picture' => fake()->randomAscii(),
        ]);

        $response->assertStatus(302);

        auth()->logout();
    }
}
