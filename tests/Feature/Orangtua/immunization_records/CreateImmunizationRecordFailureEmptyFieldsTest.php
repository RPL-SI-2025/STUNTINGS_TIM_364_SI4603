<?php

namespace Tests\Feature\Orangtua\ImmunizationRecord;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class CreateImmunizationRecordFailureEmptyFieldsTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_fails_with_empty_fields()
    {
        $user = User::create([
            'nama_anak' => 'Dummy Anak',
            'nik_anak' => '3210987654320000',
            'password' => Hash::make('password123'),
            'role' => 'orangtua',
        ]);

        $response = $this->actingAs($user)->post('/orangtua/immunization_records', []);

        $response->assertSessionHasErrors([
            'immunization_id',
            'immunized_at',
            'status',
        ]);
    }
}
