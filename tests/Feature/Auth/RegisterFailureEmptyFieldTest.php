<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;

class RegisterFailureEmptyFieldTest extends TestCase
{
    public function test_register_fails_when_required_fields_are_empty()
    {
        $response = $this->post('/register', []);

        $response->assertSessionHasErrors(['nama_anak', 'nik_anak', 'password']);
    }
}
