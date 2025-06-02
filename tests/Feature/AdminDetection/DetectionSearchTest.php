<?php

namespace Tests\Feature\AdminDetection;

use Tests\TestCase;
use App\Models\User;
use App\Models\Detection;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DetectionSearchTest extends TestCase
{
    use RefreshDatabase;

    #[\PHPUnit\Framework\Attributes\Test]
    public function admin_can_search_detections_by_child_name()
    {
        $admin = User::create([
            'role' => 'admin',
            'nik_anak' => '0000000000000000',
            'nama_anak' => 'Admin Anak',
            'password' => bcrypt('password123'),
        ]);

        $orangtua = User::create([
            'role' => 'orangtua',
            'nik_anak' => '9999999999999999',
            'nama_anak' => 'Budi',
            'password' => bcrypt('orangtua123'),
        ]);

        Detection::create([
            'user_id' => $orangtua->id,
            'nama' => 'Budi', // kolom 'nama' wajib diisi jika ada di tabel
            'nama_anak' => 'Budi',
            'umur' => 24,
            'jenis_kelamin' => 'P',
            'berat_badan' => 10,
            'tinggi_badan' => 85,
            'z_score' => 1.2,
            'status' => 'Normal',
        ]);

        Detection::create([
            'user_id' => $orangtua->id,
            'nama' => ' Annisa',
            'nama_anak' => 'Annisa',
            'umur' => 30,
            'jenis_kelamin' => 'P',
            'berat_badan' => 12,
            'tinggi_badan' => 90,
            'z_score' => 0.8,
            'status' => 'Normal',
        ]);

        // Pakai route name dan query param search
        $response = $this->actingAs($admin)->get(route('admin.detections.index', ['search' => 'Annisa']));

        $response->assertStatus(200);
        $response->assertSee('Annisa');
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function admin_search_returns_no_results_if_name_not_found()
    {
        $admin = User::create([
            'role' => 'admin',
            'nik_anak' => '1111111111111111',
            'nama_anak' => 'Admin Anak 2',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->actingAs($admin)->get(route('admin.detections.index', ['search' => 'NamaGaAda']));

        $response->assertStatus(200);
        $response->assertSee('Belum ada data deteksi'); // Sesuaikan dengan pesan pada view kamu
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function non_admin_user_cannot_access_admin_detection_page()
    {
        $orangtua = User::create([
            'role' => 'orangtua',
            'nik_anak' => '2222222222222222',
            'nama_anak' => 'Budi',
            'password' => bcrypt('orangtua123'),
        ]);

        $response = $this->actingAs($orangtua)->get(route('admin.detections.index'));

        $response->assertStatus(403);
    }
}
