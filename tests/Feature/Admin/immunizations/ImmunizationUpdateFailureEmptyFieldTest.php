<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use App\Models\Immunization;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ImmunizationUpdateFailureEmptyFieldTest extends TestCase
{
    use RefreshDatabase;

    public function test_update_fails_when_required_field_is_empty()
    {
        $admin = User::create([
            'nama_anak' => null,
            'nik_anak' => '1234567890123456',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        $immunization = Immunization::create([
            'name' => 'Polio',
            'age' => '0 bulan',
            'description' => 'Deskripsi awal',
        ]);

        $response = $this->actingAs($admin)->put("/admin/immunizations/{$immunization->id}", [
            'name' => '', 
            'age' => '2 bulan',
            'description' => 'Deskripsi setelah update',
        ]);

        $response->assertSessionHasErrors('name');
    }
}
