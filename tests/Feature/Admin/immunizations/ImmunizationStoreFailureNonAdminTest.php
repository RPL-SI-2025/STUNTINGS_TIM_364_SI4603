<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ImmunizationStoreFailureNonAdminTest extends TestCase
{
    use RefreshDatabase;

    public function test_store_fails_when_user_is_not_admin()
    {
        $orangtua = User::create([
            'nama_anak' => 'Tania',
            'nik_anak' => '3210987654325678',
            'password' => Hash::make('password123'),
            'role' => 'orangtua',
        ]);

        $response = $this->actingAs($orangtua)->post('/admin/immunizations', [
            'name' => 'BCG',
            'age' => '1 bulan',
            'description' => 'Imunisasi BCG untuk bayi',
        ]);

        $response->assertForbidden(); 
    }
}
