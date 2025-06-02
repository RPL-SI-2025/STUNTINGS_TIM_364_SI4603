<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ImmunizationStoreFailureEmptyFieldsTest extends TestCase
{
    use RefreshDatabase;

    public function test_store_fails_when_name_is_missing()
    {
        $admin = User::create([
            'nama_anak' => null,
            'nik_anak' => '1234567890123456',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)->post('/admin/immunizations', [
            'name' => '', 
            'age' => '2 bulan',
            'description' => 'Imunisasi DPT',
        ]);

        $response->assertSessionHasErrors('name');
    }
}
