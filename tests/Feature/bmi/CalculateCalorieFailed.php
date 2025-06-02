<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Bmi;

class CalculateCalorieFailed extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    

    public function test_calorie_calculation_failed_when_fields_are_empty()
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

        // Submit form kalori tanpa usia
        $hitungKalori1 = $this->actingAs($user)->post(route('hitungKalori'), [
            'gender' => 'pria',
            'tinggi' => 170,
            'berat' => 65,
            // 'usia' => 15, // kosong
            'activity_level' => 'moderately_active',
        ]);
        $hitungKalori1->assertSessionHasErrors(['usia']);

        // Submit form kalori tanpa activity_level
        $hitungKalori2 = $this->actingAs($user)->post(route('hitungKalori'), [
            'gender' => 'pria',
            'tinggi' => 170,
            'berat' => 65,
            'usia' => 15,
            // 'activity_level' => 'moderately_active', // kosong
        ]);
        $hitungKalori2->assertSessionHasErrors(['activity_level']);
    }
}
