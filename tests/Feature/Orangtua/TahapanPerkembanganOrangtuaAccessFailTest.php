<?php

namespace Tests\Feature\Orangtua;

use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TahapanPerkembanganOrangtuaAccessFailTest extends TestCase
{
    use RefreshDatabase;

    public function test_non_orangtua_user_cannot_access_perkembangan_index()
    {
        // Membuat pengguna dengan peran yang salah (admin)
        $user = User::create([
            'nama_anak' => 'Budi',
            'nik_anak' => '9876543210123456',
            'password' => Hash::make('123456'),
            'role' => 'admin', // Peran yang tidak sesuai
        ]);

        // Mencoba mengakses halaman dengan menggunakan pengguna yang tidak sesuai
        $response = $this->actingAs($user)->get('/orangtua/tahapan_perkembangan');

        // Pastikan responsnya adalah Forbidden (403), karena peran pengguna tidak sesuai
        $response->assertStatus(403);
    }
}
