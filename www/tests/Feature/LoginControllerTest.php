<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{

    public function test_base(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_auth(): void
    {
        $response = $this->post('/login', [
            'email' => 'admin@admin.com',
            'password' => 'password',
        ]);

        $response->assertRedirectToRoute('profile', [
            'username' => 'admin',
        ]);
    }

    public function test_logout(): void
    {
        $response = $this->get('/logout');

        $response->assertRedirectToRoute('login');
    }

    public function test_not_auth(): void
    {
        $response = $this->post('/login', [
            'email' => '123@123.com',
            'password' => '123',
        ]);

        $response->assertRedirectToRoute('home');
    }

    public function test_not_password(): void
    {
        $response = $this->post('/login', [
            'email' => 'admin@admin.com',
            'password' => '',
        ]);

        $response->assertStatus(302);
    }

    public function test_not_email(): void
    {
        $response = $this->post('/login', [
            'email' => '',
            'password' => 'password',
        ]);

        $response->assertStatus(302);
    }

    public function test_wrong_password(): void
    {
        $response = $this->post('/login', [
            'email' => 'admin@admin.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(302);
    }

    public function test_wrong_email(): void
    {
        $response = $this->post('/login', [
            'email' => 'admin@123.com',
            'password' => 'password',
        ]);

        $response->assertStatus(302);
    }

    public function test_remember_me(): void
    {
        $response = $this->post('/login', [
            'email' => 'admin@admin.com',
            'password' => 'password',
            'remember_me' => 'on',
        ]);

        $response->assertRedirectToRoute('profile', [
            'username' => 'admin'
        ]);
    }

    public function test_other_remember_me(): void
    {
        $response = $this->post('/login', [
            'email' => 'admin@admin.com',
            'password' => 'password',
            'remember_me' => 'admin',
        ]);

        $response->assertRedirectToRoute('profile', [
            'username' => 'admin',
        ]);
    }
}
