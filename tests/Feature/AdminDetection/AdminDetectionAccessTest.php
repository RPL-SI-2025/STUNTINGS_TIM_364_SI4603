<?php

namespace Tests\Feature\AdminDetection;

use App\Models\User;
use App\Models\Detection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminDetectionAccessTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();

        // Jalankan seeder admin
        $this->artisan('db:seed', ['--class' => 'AdminSeeder']);

        // Ambil user admin
        $this->admin = User::where('role', 'admin')->first();

        // Tambahkan data dummy anak untuk dicek di tampilan
        $parent = User::create([
            'nama_anak' => 'Ani',
            'nik_anak' => '9876543210987654',
            'password' => Hash::make('orangtua123'),
            'role' => 'orangtua',
        ]);

        Detection::create([
            'user_id' => $parent->id,
            'nama' => 'Ani',
            'umur' => 24,
            'jenis_kelamin' => 'P',
            'berat_badan' => 11.5,
            'tinggi_badan' => 85.0,
            'z_score' => 0.5,
            'status' => 'Normal',
        ]);
    }

    /** @test */
    public function admin_dapat_mengakses_halaman_view_detection()
    {
        $response = $this->actingAs($this->admin)->get(route('admin.detections.index'));

        $response->assertStatus(200);
        $response->assertSeeText('Ani'); // pastikan nama anak terlihat
    }
}
