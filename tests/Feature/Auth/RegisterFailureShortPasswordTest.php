<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;

class RegisterFailureShortPasswordTest extends TestCase
{
    public function test_register_fails_when_password_is_too_short()
    {
        $response = $this->post('/register', [
            'nama_anak' => 'Tania',
            'nik_anak' => '3210987654325673',
            'password' => '123', 
            'password_confirmation' => '123',
        ]);

        $response->assertSessionHasErrors('password');
    }
}
