<?php

namespace Tests\Feature\OrangtuaDetection;

use Tests\TestCase;
use App\Models\User;
use App\Models\Detection;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrangtuaTidakBisaHapusDeteksiOrangLainTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function orangtua_tidak_bisa_hapus_deteksi_orang_lain()
    {
        // Buat user orangtua yang login tanpa factory
        $orangtua1 = User::create([
            'role' => 'orangtua',
            'nama_anak' => 'Budi',
            'nik_anak' => '1234567890123456',
            'password' => bcrypt('password123'),
        ]);

        // Buat user orangtua lain tanpa factory
        $orangtua2 = User::create([
            'role' => 'orangtua',
            'nama_anak' => 'Buda',
            'nik_anak' => '1234567890123457',
            'password' => bcrypt('password123'),
        ]);

        // Buat deteksi yang milik orangtua2
        $detection = Detection::create([
            'user_id' => $orangtua2->id,
            'umur' => 24,
            'jenis_kelamin' => 'L',
            'berat_badan' => 12.5,
            'tinggi_badan' => 80,
            'nama' => 'Buda',
            'z_score' => -1.5,
            'status' => 'Normal',
        ]);

        // Jalankan delete sebagai orangtua1 (yang bukan pemilik data)
        $response = $this->actingAs($orangtua1)
                         ->delete(route('orangtua.detections.destroy', $detection->id));

        // Karena controller pakai findOrFail tanpa cek ownership,
        // user ini gak punya akses ke data orang lain, jadi response-nya 404
        $response->assertStatus(403);

        // Pastikan data deteksi tetap ada di database
        $this->assertDatabaseHas('detections', ['id' => $detection->id]);
    }
}
