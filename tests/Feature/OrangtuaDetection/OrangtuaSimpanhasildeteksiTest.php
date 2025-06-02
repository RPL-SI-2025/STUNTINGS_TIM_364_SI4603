<?php

namespace Tests\Feature\OrangtuaDetection;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrangtuaSimpanhasildeteksiTest extends TestCase
{
    use RefreshDatabase;

    public function test_orangtua_can_store_detection_successfully()
    {
        $user = User::create([
            'nama_anak' => 'Budi',
            'nik_anak' => '1234567890123456',
            'password' => bcrypt('password'),
            'role' => 'orangtua',
        ]);

        $this->actingAs($user);

        // Simulasi file WHO data laki-laki
        Storage::fake('local');
        $whoData = [['Month' => 24, 'M' => 85.0, 'SD' => 3.5]];
        Storage::disk('local')->put('zscores_boys.json', json_encode($whoData));

        $response = $this->post(route('orangtua.detections.store'), [
            'umur' => 24,
            'jenis_kelamin' => 'L',
            'berat_badan' => 12.5,
            'tinggi_badan' => 85.0,
        ]);

        $response->assertRedirect(route('orangtua.detections.create'));
        $this->assertDatabaseHas('detections', [
            'user_id' => $user->id,
            'status' => 'Normal',
            'z_score' => -0.92
        ]);
    }

    public function test_store_detection_fails_when_who_data_for_age_not_found()
    {
        $user = User::create([
            'nama_anak' => 'Ani',
            'nik_anak' => '1234567890123457',
            'password' => bcrypt('password'),
            'role' => 'orangtua',
        ]);

        $this->actingAs($user);

        Storage::fake('local');
        $whoData = [['Month' => 12, 'M' => 75.0, 'SD' => 3.0]]; // Tidak ada data umur 24
        Storage::disk('local')->put('zscores_girls.json', json_encode($whoData));

        $response = $this->post(route('orangtua.detections.store'), [
            'umur' => 999,
            'jenis_kelamin' => 'P',
            'berat_badan' => 10.2,
            'tinggi_badan' => 85.0,
        ]);

        $response->assertSessionHas('error', 'Data WHO tidak tersedia untuk umur ini.');
    }

    public function test_store_detection_fails_with_invalid_input()
    {
        $user = User::create([
            'nama_anak' => 'Cici',
            'nik_anak' => '1234567890123458',
            'password' => bcrypt('password'),
            'role' => 'orangtua',
        ]);

        $this->actingAs($user);

        $response = $this->post(route('orangtua.detections.store'), [
            'umur' => '',
            'jenis_kelamin' => '',
            'berat_badan' => '',
            'tinggi_badan' => '',
        ]);

        $response->assertSessionHasErrors(['umur', 'jenis_kelamin', 'berat_badan', 'tinggi_badan']);
    }
}
