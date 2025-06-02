<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use App\Models\TahapanPerkembangan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class TahapanPerkembanganAdminCreateTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_tahapan_perkembangan()
    {
        $admin = User::create([
            'nama_anak' => null,
            'nik_anak' => '1234567890123456',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        $data = [
            'nama_tahapan' => 'Merangkak',
            'deskripsi' => 'Tahapan merangkak bayi usia 8 bulan',
            'umur_minimal_bulan' => 6,
            'umur_maksimal_bulan' => 12,
        ];

        $response = $this->actingAs($admin)
                         ->post('/admin/tahapan_perkembangan', $data);

        $response->assertRedirect(route('admin.tahapan_perkembangan.index'));
        $this->assertDatabaseHas('tahapan_perkembangan', [
            'nama_tahapan' => 'Merangkak'
        ]);
    }
}
