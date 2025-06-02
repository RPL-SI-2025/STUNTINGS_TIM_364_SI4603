<?php

namespace Tests\Feature\Orangtua\ImmunizationRecord;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReadFailureGuestTest extends TestCase
{
    use RefreshDatabase;

    public function test_read_fails_when_not_authenticated()
    {
        $response = $this->get('/orangtua/immunization_records');
        $response->assertRedirect('/login');
    }
}
