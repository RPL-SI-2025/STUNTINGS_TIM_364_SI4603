<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginFailureWrongPasswordTest extends TestCase
{
    public function test_login_fails_with_wrong_password()
    {
        User::create([
            'nama_anak' => 'Tania',
            'nik_anak' => '3210987654325689',
            'password' => Hash::make('password123'),
            'role' => 'orangtua',
        ]);

        $response = $this->post('/login', [
            'nik_anak' => '3210987654325678',
            'password' => 'salahh',
        ]);

        $response->assertSessionHasErrors('login');
        $this->assertGuest();
    }
}
