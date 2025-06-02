<?php

namespace Tests\Feature\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ImmunizationSearchFailureUnauthenticatedTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_user_is_redirected_when_searching_immunization()
    {
        $response = $this->get('/admin/immunizations?name=Polio');

        $response->assertRedirect('/login');
    }
}
