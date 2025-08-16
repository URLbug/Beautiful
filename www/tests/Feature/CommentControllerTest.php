<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class CommentControllerTest extends TestCase
{
    private function login()
    {
        Auth::attempt([
            'email' => 'admin@admin.com',
            'password' => 'password',
        ]);
    }

    /**
     * Make ajax POST request
     */
    protected function ajaxPost(string $uri, array $data = [])
    {
        return $this->post($uri, $data, ['HTTP_X-Requested-With' => 'XMLHttpRequest']);
    }

    public function test_base(): void
    {
        $response = $this->get('/comment');

        $response->assertStatus(405);
    }

    public function test_add_comment(): void
    {
        $this->login();

        $response = $this->post('/comment', [
            'text' => 'test',
            'post' => 1,
        ]);

        $response->assertStatus(302);

        auth()->logout();
    }

    public function test_add_comment_null(): void
    {
        $this->login();

        $response = $this->post('/comment', [
            'text' => 'test',
            'post' => 0,
        ]);

        $response->assertStatus(302);
        auth()->logout();
    }

    public function test_add_comment_char(): void
    {
        $this->login();

        $response = $this->post('/comment', [
            'text' => '😀😀😀😀',
            'post' => 1,
        ]);

        $response->assertStatus(302);

        $response = $this->post('/comment', [
            'text' => 'test',
            'post' => '😀',
        ]);

        $response->assertStatus(302);
        auth()->logout();
    }

    public function test_add_comment_empty(): void
    {
        $this->login();

        $response = $this->post('/comment', [
            'text' => '',
            'post' => '',
        ]);

        $response->assertStatus(302);

        $response = $this->post('/comment', [
            'text' => null,
            'post' => null,
        ]);

        $response->assertStatus(302);
        auth()->logout();
    }

    public function test_add_comment_not_text(): void
    {
        $this->login();

        $response = $this->post('/comment', [
            'text' => '',
            'post' => 1,
        ]);

        $response->assertStatus(302);
        auth()->logout();
    }

    public function test_add_long_text(): void
    {
        $this->login();

        $response = $this->post('/comment', [
            'text' => fake()->text(500),
            'post' => 1,
        ]);

        $response->assertStatus(302);
        auth()->logout();
    }

    // public function test_like_comment(): void
    // {
    //     $this->login();

    //     $response = $this->ajaxPost('/comment/1');

    //     $response->assertJson([
    //         'id' => 1,
    //         'likes' => 1,
    //         'code' => 200,
    //     ]);
    //     auth()->logout();
    // }

    // public function test_unlike_comment(): void
    // {
    //     $this->login();

    //     $response = $this->ajaxPost('/comment/1');

    //     $response->assertSuccessful()
    //     ->assertJson([
    //         'id' => 1,
    //         'likes' => 0,
    //         'code' => 200,
    //     ]);
    //     auth()->logout();
    // }

    // public function test_like_and_unlike_comment_null(): void
    // {
    //     $this->login();

    //     $response = $this->ajaxPost('/comment/0');

    //     $response->assertStatus(302);

    //     $response = $this->ajaxPost('/comment/0');

    //     $response->assertStatus(302);
    // }
}
