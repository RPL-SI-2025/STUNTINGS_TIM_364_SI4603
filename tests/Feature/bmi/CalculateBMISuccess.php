<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class CalculateBMISuccess extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */

    public function test_bmi_calculation_flow_for_male()
    {
        // Buat user hanya dengan field yang ada di tabel users
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

        // Akses dashboard
        $dashboard = $this->actingAs($user)->get('/orangtua/dashboard');
        $dashboard->assertStatus(200);
        $dashboard->assertSee('BMI');

        // Akses halaman BMI
        $bmiPage = $this->actingAs($user)->get(route('bmi'));
        $bmiPage->assertStatus(200);
        $bmiPage->assertSee('Kalkulator BMI');

        // Submit form BMI (gender: pria, tinggi: 170, berat: 65)
        $hitung = $this->actingAs($user)->post(route('hitung-bmi'), [
            'gender' => 'pria',
            'tinggi' => 170,
            'berat' => 65,
        ]);
        $hitung->assertSessionHasNoErrors();
        $hitung->assertSessionHas('bmi');
        $hitung->assertSessionHas('status');
    }

    public function test_bmi_calculation_flow_for_female()
    {
        // Buat user hanya dengan field yang ada di tabel users
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

        // Akses dashboard
        $dashboard = $this->actingAs($user)->get('/orangtua/dashboard');
        $dashboard->assertStatus(200);
        $dashboard->assertSee('BMI');

        // Akses halaman BMI
        $bmiPage = $this->actingAs($user)->get(route('bmi'));
        $bmiPage->assertStatus(200);
        $bmiPage->assertSee('Kalkulator BMI');

        // Submit form BMI (gender: wanita, tinggi: 160, berat: 55)
        $hitung = $this->actingAs($user)->post(route('hitung-bmi'), [
            'gender' => 'wanita',
            'tinggi' => 160,
            'berat' => 55,
        ]);
        $hitung->assertSessionHasNoErrors();
        $hitung->assertSessionHas('bmi');
        $hitung->assertSessionHas('status');
    }
}
