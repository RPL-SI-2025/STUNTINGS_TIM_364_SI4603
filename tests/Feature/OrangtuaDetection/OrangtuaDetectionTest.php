<?php

namespace Tests\Feature\OrangtuaDetection;

use App\Models\User;
use App\Models\Detection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrangtuaDetectionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function orangtua_dapat_melakukan_deteksi_stunting()
    {
        // Buat user orangtua tanpa factory
        $user = User::create([
            'role' => 'orangtua',
            'nama_anak' => 'Budi',
            'nik_anak' => '1234567890123456',
            'password' => bcrypt('password123'),
        ]);

        $this->actingAs($user);

        // Data input deteksi
        $data = [
            'umur' => 24,
            'jenis_kelamin' => 'L',
            'berat_badan' => 12.5,
            'tinggi_badan' => 80,
        ];

        // Kirim POST ke route penyimpanan deteksi
        $response = $this->post(route('orangtua.detections.store'), $data);

        $response->assertRedirect(route('orangtua.detections.create'));
        $response->assertSessionHas('success', 'Deteksi berhasil disimpan!');

        // Cek database ada data deteksi dengan user_id sama
        $this->assertDatabaseHas('detections', [
            'user_id' => $user->id,
            'umur' => 24,
            'jenis_kelamin' => 'L',
            'berat_badan' => 12.5,
            'tinggi_badan' => 80,
        ]);
    }
}
