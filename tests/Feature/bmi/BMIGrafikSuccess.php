<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Bmi;

class BMIGrafikSuccess extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    

    public function test_bmi_grafik_appears_after_save()
    {
        // Buat user
        $user = User::create([
            'role' => 'orangtua',
            'nik_anak' => '1234567890123456',
            'password' => bcrypt('password123'),
            'nama_anak' => 'Cantika'
        ]);

        // Simulasi login
        $response = $this->post('/login', [
            'nik_anak' => '1234567890123456',
            'password' => 'password123',
        ]);
        $response->assertRedirect('/orangtua/dashboard');

        // Simpan hasil BMI
        $bmi = Bmi::create([
            'user_id' => $user->id,
            'tanggal' => now()->format('Y-m-d H:i'),
            'tinggi' => 170,
            'berat' => 65,
            'bmi' => 22.5,
            'status' => 'Normal',
            'gender' => 'pria',
        ]);

        // Akses halaman BMI (grafik)
        $bmiPage = $this->actingAs($user)->get(route('bmi'));
        $bmiPage->assertStatus(200);
        $bmiPage->assertSee('Grafik Perkembangan BMI');
        $bmiPage->assertSee('canvas id="bmiChart"', false); // pastikan ada elemen grafik
        $bmiPage->assertSee((string)$bmi->bmi); // pastikan nilai BMI muncul di halaman (data grafik)
    }
}
