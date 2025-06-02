<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Bmi;

class CalculateCalorieSuccess extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    

    public function test_calorie_calculation_success()
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

        // Simpan hasil BMI (agar form kalori bisa diakses)
        $bmi = Bmi::create([
            'user_id' => $user->id,
            'tanggal' => now()->format('Y-m-d H:i'),
            'tinggi' => 170,
            'berat' => 65,
            'bmi' => 22.5,
            'status' => 'Normal',
            'gender' => 'pria',
        ]);

        // Submit form kalori
        $hitungKalori = $this->actingAs($user)->post(route('hitungKalori'), [
            'gender' => 'pria',
            'tinggi' => 170,
            'berat' => 65,
            'usia' => 15,
            'activity_level' => 'moderately_active',
        ]);
        $hitungKalori->assertSessionHasNoErrors();
        $hitungKalori->assertSessionHas('kalori');
        $hitungKalori->assertSessionHas('show_kalori_results');

        // Pastikan hasil estimasi kalori muncul di halaman
        $kaloriPage = $this->actingAs($user)->get(route('bmi'));
        $kaloriPage->assertStatus(200);
        $kaloriPage->assertSee('Estimasi Kebutuhan Kalori Harian');
        $kaloriPage->assertSee('Total Kalori per Hari');
    }
}
