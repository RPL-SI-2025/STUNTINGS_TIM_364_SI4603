<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ImmunizationStoreValidationFailureTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_cannot_store_immunization_with_empty_fields()
    {
        $admin = User::create([
            'nama_anak' => null,
            'nik_anak' => '1234567890123456',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)->post('/admin/immunizations', []);

        $response->assertSessionHasErrors('name');
    }
}
