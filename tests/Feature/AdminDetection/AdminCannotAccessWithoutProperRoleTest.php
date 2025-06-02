<?php

namespace Tests\Feature\AdminDetection;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class AdminCannotAccessWithoutProperRoleTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function non_admin_tidak_bisa_mengakses_view_detection()
    {
        $user = User::create([
            'nama_anak' => 'Budi',
            'nik_anak' => '9999999999999999',
            'password' => bcrypt('orangtua123'),
            'role' => 'orangtua',
        ]);

        $response = $this->actingAs($user)->get(route('admin.detections.index'));

        $response->assertStatus(403);
    }

    #[Test]
    public function guest_tidak_bisa_mengakses_view_detection()
    {
        $response = $this->get(route('admin.detections.index'));

        $response->assertRedirect('/login');
    }
}
