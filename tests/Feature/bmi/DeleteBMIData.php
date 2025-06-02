<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Bmi;

class DeleteBMIData extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */ 

    public function test_delete_bmi_data_from_history()
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

        // Pastikan data ada di database
        $this->assertDatabaseHas('bmi', [
            'id' => $bmi->id,
            'user_id' => $user->id,
        ]);

        // Hapus data BMI via aksi di riwayat
        $delete = $this->actingAs($user)->post(route('hapus-bmi-row', $bmi->id));
        $delete->assertRedirect(route('bmi'));

        // Pastikan data sudah terhapus dari database
        $this->assertDatabaseMissing('bmi', [
            'id' => $bmi->id,
            'user_id' => $user->id,
        ]);
    }
}
