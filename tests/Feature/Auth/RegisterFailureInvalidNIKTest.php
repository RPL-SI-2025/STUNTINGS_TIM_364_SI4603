<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;

class RegisterFailureInvalidNIKTest extends TestCase
{
    public function test_register_fails_when_nik_is_not_16_digits()
    {
        $response = $this->post('/register', [
            'nama_anak' => 'Tania',
            'nik_anak' => '12345678', 
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasErrors('nik_anak');
    }
}
