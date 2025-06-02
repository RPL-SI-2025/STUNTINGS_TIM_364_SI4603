<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Bmi;

class SaveBMIResultSuccess extends TestCase
{
    use RefreshDatabase;


    public function test_save_bmi_result_and_see_in_history()
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

        // Hitung BMI (POST ke route hitung-bmi)
        $hitung = $this->actingAs($user)->post(route('hitung-bmi'), [
            'gender' => 'pria',
            'tinggi' => 170,
            'berat' => 65,
        ]);
        $hitung->assertSessionHasNoErrors();
        $hitung->assertSessionHas('bmi');
        $hitung->assertSessionHas('status');

        // Simpan hasil BMI (POST ke route simpan-bmi)
        $simpan = $this->actingAs($user)->post(route('simpan-bmi'), [
            'gender' => 'pria',
            'tinggi' => 170,
            'berat' => 65,
            'bmi' => session('bmi'),
            'status' => session('status'),
        ]);
        $simpan->assertSessionHas('success');

        // Pastikan data tersimpan di database (tabel: bmi)
        $this->assertDatabaseHas('bmi', [
            'user_id' => $user->id,
            'gender' => 'pria',
            'tinggi' => 170,
            'berat' => 65,
        ]);

        // Cek riwayat data BMI di halaman BMI
        $bmiPage = $this->actingAs($user)->get(route('bmi'));
        $bmiPage->assertStatus(200);
        $bmiPage->assertSee('Riwayat Data BMI');
        $bmiPage->assertSee('170');
        $bmiPage->assertSee('65');
        $bmiPage->assertSee('Pria');
    }
}
