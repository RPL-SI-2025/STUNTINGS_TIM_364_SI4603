<?php

namespace Tests\Feature\Orangtua\ImmunizationRecord;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ReadFailureUnauthorizedTest extends TestCase
{
    use RefreshDatabase;

    public function test_read_fails_for_non_orangtua_role()
    {
        $admin = User::create([
            'nama_anak' => null,
            'nik_anak' => '1234567890123456',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)->get('/orangtua/immunization_records');
        $response->assertForbidden();
    }
}
