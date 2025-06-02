<?php

namespace Tests\Feature\OrangtuaDetection;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrangtuaDetectionValidationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function orangtua_tidak_dapat_melakukan_deteksi_jika_data_tidak_lengkap()
    {
        $user = User::create([
            'role' => 'orangtua',
            'nama_anak' => 'Budi',
            'nik_anak' => '1234567890123456',
            'password' => bcrypt('password123'),
        ]);

        $this->actingAs($user);

        $data = [
            'umur' => '', // kosong
            'jenis_kelamin' => '', // kosong
            'berat_badan' => 12.5,
            // tinggi_badan tidak diisi
        ];

        $response = $this->post(route('orangtua.detections.store'), $data);

        $response->assertSessionHasErrors(['umur', 'jenis_kelamin', 'tinggi_badan']);
    }
}
