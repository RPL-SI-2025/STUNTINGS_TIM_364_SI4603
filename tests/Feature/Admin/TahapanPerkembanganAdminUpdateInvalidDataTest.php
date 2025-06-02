<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use App\Models\User;
use App\Models\TahapanPerkembangan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class TahapanPerkembanganAdminUpdateInvalidDataTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_update_fails_due_to_invalid_integer_field()
    {
        $admin = User::create([
            'nama_anak' => null,
            'nik_anak' => '1234567890123456',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        $tahapan = TahapanPerkembangan::create([
            'nama_tahapan' => 'Awal',
            'deskripsi' => 'Deskripsi awal',
        ]);

        $response = $this->actingAs($admin)->from(route('admin.tahapan_perkembangan.edit', $tahapan->id))
            ->put(route('admin.tahapan_perkembangan.update', $tahapan->id), [
                'nama_tahapan' => 'Update',
                'deskripsi' => 'Deskripsi Update',
                'umur_minimal_bulan' => 'abc', // invalid
                'umur_maksimal_bulan' => 'xyz', // invalid
            ]);

        $response->assertRedirect(route('admin.tahapan_perkembangan.edit', $tahapan->id));
        $response->assertSessionHasErrors(['umur_minimal_bulan', 'umur_maksimal_bulan']);
    }
}
