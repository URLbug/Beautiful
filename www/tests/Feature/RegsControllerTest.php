<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegsControllerTest extends TestCase
{
    protected function delete_user(): void
    {
        $user = User::query()
        ->where('email', 'test@example.com');

        if($user->exists())
        {
            $user->delete();
        }
    }

    public function test_base(): void
    {
        $response = $this->get('/regs');

        $response->assertStatus(200);
    }

    public function test_regs_new_user(): void
    {
        $response = $this->post('/regs', [
            'username' => 'TEST',
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $response->assertRedirectToRoute('login');

        $this->delete_user();
    }

    public function test_regs_exists_email(): void
    {
        $response = $this->post('/regs', [
            'username' => 'admin',
            'email' => 'admin@admin.com',
            'password' => 'password',
        ]);

        $response->assertStatus(302);
    }

    public function test_regs_exists_username(): void
    {
        $response = $this->post('/regs', [
            'username' => 'admin',
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $response->assertRedirectToRoute('login');
    }

    public function test_regs_min_password(): void
    {
        $response = $this->post('/regs', [
            'username' => 'admin',
            'email' => 'test@example.com',
            'password' => 'pass',
        ]);

        $response->assertStatus(302);

        $this->delete_user();
    }

    public function test_regs_without_username(): void
    {
        $response = $this->post('/regs', [
            'username' => '',
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $response->assertStatus(302);
    }

    public function test_regs_without_email(): void
    {
        $response = $this->post('/regs', [
            'username' => 'TEST',
            'email' => '',
            'password' => 'password',
        ]);

        $response->assertStatus(302);
    }

    public function test_regs_without_password(): void
    {
        $response = $this->post('/regs', [
            'username' => 'TEST',
            'email' => 'test@example.com',
            'password' => '',
        ]);

        $response->assertStatus(302);
    }


    public function test_regs_special_char_username(): void
    {
        $response = $this->post('/regs', [
            'username' => '😀',
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $response->assertRedirectToRoute('login');

        $this->delete_user();
    }

    public function test_regs_special_char_email(): void
    {
        $response = $this->post('/regs', [
            'username' => 'TEST',
            'email' => '😀@😀.com',
            'password' => 'password',
        ]);

        $response->assertStatus(302);
    }

    public function test_regs_special_char_password(): void
    {
        $response = $this->post('/regs', [
            'username' => 'TEST',
            'email' => 'test@example.com',
            'password' => '😀😀😀😀😀😀',
        ]);
        
        $response->assertRedirectToRoute('login');
        
        $this->delete_user();
    }
}
