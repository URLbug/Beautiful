<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use App\Owners\S3Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class PostControllerTest extends TestCase
{
    private function login(): void
    {
        $response = $this->post('/login', [
            'email' => 'admin@admin.com',
            'password' => 'password',
        ]);
    }

    protected function ajaxPost(string $uri, array $data = [])
    {
        return $this->post($uri, $data, ['HTTP_X-Requested-With' => 'XMLHttpRequest']);
    }

    public function test_base(): void
    {
        $this->login();

        $response = $this->get('/posts');

        $response->assertStatus(200);
    }

    public function test_base_not_auth(): void
    {
        $response = $this->get('/posts');

        $response->assertStatus(302);
    }
    
    public function test_get_posts(): void
    {
        $this->login();

        $response = $this->get('/posts/1');

        $response->assertStatus(200);
    }

    public function test_get_ghost_posts(): void
    {
        $this->login();

        $response = $this->get('/posts/111');

        $response->assertStatus(404);
    }

    public function test_unlike_and_like_post(): void
    {
        $this->login();

        $response = $this->ajaxPost('/posts/1');

        $response->assertJson([
            'id' => 1,
            'likes' => 1,
            'code' => 200,
        ]);

        $response = $this->ajaxPost('/posts/1');

        $response->assertJson([
            'id' => 1,
            'likes' => 0,
            'code' => 200,
        ]);
    }

    public function test_unlike_and_like_ghost_post(): void
    {
        $this->login();

        $response = $this->post('/posts/111');

        $response->assertStatus(404);

        $response = $this->post('/posts/111');

        $response->assertStatus(404);
    }

    /**
     * @test
     */
    // public function test_store_post_success()
    // {
    //     // Arrange
    //     $this->login();

    //     $data = [
    //         'name' => 'Test Post',
    //         'file' => UploadedFile::fake()->image('test.png', 400, 400),
    //         'description' => 'Test description',
    //     ];

    //     // Act
    //     $response = $this->post(route('posts'), $data);

    //     // Assert
    //     $response->assertRedirect();
        
    //     $post = Post::query()
    //     ->where('name', 'Test Post')
    //     ->where('user_id', 1)
    //     ->orderByDesc('id')
    //     ->first();
        
    //     $this->assertEquals($data['name'], $post->name);
    //     $this->assertEquals($data['description'], $post->description);
    //     $this->assertEquals(1, $post->user_id);
    //     $this->assertNotNull($post->file);

    //     auth()->logout();
    // }

    /**
     * @test
     */
    public function test_store_post_without_file()
    {
        // Arrange
        $this->login();

        $data = [
            'name' => 'Test Post',
            'file' => '',
            'description' => 'Test description',
        ];

        // Act
        $response = $this->post(route('posts'), $data);

        // Assert
        $response->assertSessionHasErrors();

        auth()->logout();
    }
}
