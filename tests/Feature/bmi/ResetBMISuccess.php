<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class ResetBMISuccess extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */


    public function test_bmi_reset_flow()
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

        // Akses halaman BMI
        $bmiPage = $this->actingAs($user)->get(route('bmi'));
        $bmiPage->assertStatus(200);

        // Isi dan submit form BMI (hitung)
        $hitung = $this->actingAs($user)->post(route('hitung-bmi'), [
            'gender' => 'pria',
            'tinggi' => 170,
            'berat' => 65,
        ]);
        $hitung->assertSessionHasNoErrors();
        $hitung->assertSessionHas('bmi');
        $hitung->assertSessionHas('status');

        // Reset form BMI
        $reset = $this->actingAs($user)->post(route('reset-bmi'));
        $reset->assertSessionMissing('bmi');
        $reset->assertSessionMissing('status');

        // Pastikan halaman BMI form kosong (tidak ada value BMI & status)
        $bmiPageAfterReset = $this->actingAs($user)->get(route('bmi'));
        $bmiPageAfterReset->assertStatus(200);
        $bmiPageAfterReset->assertDontSee(session('bmi'));
        $bmiPageAfterReset->assertDontSee(session('status'));
    }
}
