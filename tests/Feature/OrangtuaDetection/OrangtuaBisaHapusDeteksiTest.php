<?php

namespace Tests\Feature\OrangtuaDetection;

use Tests\TestCase;
use App\Models\User;
use App\Models\Detection;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrangtuaBisaHapusDeteksiTest extends TestCase
{
    use RefreshDatabase;

    public function test_orangtua_bisa_hapus_deteksi_miliknya()
    {
        $orangtua = User::create([
            'role' => 'orangtua',
            'nama_anak' => 'Andi',
            'nik_anak' => '1234567890123456',
            'password' => bcrypt('password'),
        ]);

        $detection = Detection::create([
            'user_id' => $orangtua->id,
            'nama' => $orangtua->nama_anak,
            'umur' => 12,
            'jenis_kelamin' => 'L',
            'berat_badan' => 10,
            'tinggi_badan' => 80,
            'z_score' => -1.5,
            'status' => 'Normal',
        ]);

        $response = $this->actingAs($orangtua)->delete("/orangtua/deteksi-stunting/{$detection->id}");
        $response->assertRedirect();
        $this->assertDatabaseMissing('detections', ['id' => $detection->id]);
    }
}
