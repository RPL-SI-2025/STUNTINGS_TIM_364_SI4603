<?php

namespace Tests\Feature\OrangtuaDetection;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserNonOrangtuaTidakBisaMenyimpanDeteksiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_non_orangtua_tidak_bisa_menyimpan_deteksi()
    {
        $admin = User::create([
    'role' => 'admin',
    'nama_anak' => 'Dummy',
    'nik_anak' => '0000000000000000',
    'password' => bcrypt('password'),
    ]);

        $this->actingAs($admin);

        $data = [
            'umur' => 24,
            'jenis_kelamin' => 'L',
            'berat_badan' => 12.5,
            'tinggi_badan' => 80,
        ];

        $response = $this->post(route('orangtua.detections.store'), $data);

        $response->assertStatus(403);
    }
}
