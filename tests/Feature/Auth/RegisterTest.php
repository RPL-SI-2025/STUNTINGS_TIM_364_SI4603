<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function test_orangtua_can_register_with_valid_data()
    {
        $response = $this->post('/register', [
            'nama_anak' => 'Tania',
            'nik_anak' => '3210987654325678',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect('/login');

        $this->assertDatabaseHas('users', [
            'nama_anak' => 'Tania',
            'nik_anak' => '3210987654325678',
            'role' => 'orangtua',
        ]);
    }
}
