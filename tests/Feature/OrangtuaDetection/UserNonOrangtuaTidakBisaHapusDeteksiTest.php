<?php

namespace Tests\Feature\OrangtuaDetection;

use Tests\TestCase;
use App\Models\User;
use App\Models\Detection;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserNonOrangtuaTidakBisaHapusDeteksiTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_non_orangtua_tidak_bisa_hapus_deteksi()
    {
        $admin = User::create([
            'role' => 'admin',
            'nama_anak' => 'Dummy',
            'nik_anak' => '0000000000000000',
            'password' => bcrypt('password'),
        ]);

        $orangtua = User::create([
            'role' => 'orangtua',
            'nama_anak' => 'Joko',
            'nik_anak' => '9999999999999999',
            'password' => bcrypt('password'),
        ]);

        $detection = Detection::create([
            'user_id' => $orangtua->id,
            'nama' => $orangtua->nama_anak,
            'umur' => 24,
            'jenis_kelamin' => 'L',
            'berat_badan' => 11,
            'tinggi_badan' => 82,
            'z_score' => 0.5,
            'status' => 'Normal',
        ]);

        $response = $this->actingAs($admin)->delete("/orangtua/detections/{$detection->id}");

        $response->assertStatus(404);
        $this->assertDatabaseHas('detections', ['id' => $detection->id]);
    }
}
