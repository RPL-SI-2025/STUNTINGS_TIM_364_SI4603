<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_login_orangtua_berhasil()
{
    \App\Models\User::create([
        'nama_anak' => 'Tania',
        'nik_anak' => '3210987654325678',
        'password' => bcrypt('password123'),
        'role' => 'orangtua',
    ]);

    $response = $this->post('/login', [
        'nik_anak' => '3210987654325678',
        'password' => 'password123',
    ]);

    $response->assertRedirect('/orangtua/dashboard');
    $this->assertAuthenticated();
}
}