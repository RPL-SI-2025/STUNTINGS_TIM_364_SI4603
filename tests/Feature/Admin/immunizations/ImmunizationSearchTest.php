<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use App\Models\Immunization;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ImmunizationSearchTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_search_immunization_by_name()
    {
        $admin = User::create([
            'nama_anak' => null,
            'nik_anak' => '1234567890123456',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        Immunization::create(['name' => 'Polio', 'age' => '0 bulan']);
        Immunization::create(['name' => 'Campak', 'age' => '9 bulan']);
        Immunization::create(['name' => 'DPT', 'age' => '2 bulan']);

        $response = $this->actingAs($admin)->get('/admin/immunizations?name=Polio');

        $response->assertStatus(200);
        $response->assertSee('Polio');
        $response->assertDontSee('Campak');
        $response->assertDontSee('DPT');
    }
}
