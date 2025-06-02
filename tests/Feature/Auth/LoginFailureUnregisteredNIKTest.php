<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;

class LoginFailureUnregisteredNIKTest extends TestCase
{
    public function test_login_fails_with_unregistered_nik()
    {
        $response = $this->post('/login', [
            'nik_anak' => '3210987654325689',
            'password' => 'password123',
        ]);

        $response->assertSessionHasErrors('login');
        $this->assertGuest();
    }
}
