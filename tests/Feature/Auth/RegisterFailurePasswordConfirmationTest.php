<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;

class RegisterFailurePasswordConfirmationTest extends TestCase
{
    public function test_register_fails_when_password_confirmation_does_not_match()
    {
        $response = $this->post('/register', [
            'nama_anak' => 'Tania',
            'nik_anak' => '3210987654325899',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasErrors('password');
    }
}
