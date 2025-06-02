<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class SaveBMIFailed extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
   

    public function test_bmi_save_failed_when_fields_are_empty()
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

        // Submit form SIMPAN BMI tanpa mengisi kolom apapun
        $simpan = $this->actingAs($user)->post(route('simpan-bmi'), [
            // Tidak ada input
        ]);
        $simpan->assertSessionHasErrors(['gender', 'tinggi', 'berat']);
    }
}
