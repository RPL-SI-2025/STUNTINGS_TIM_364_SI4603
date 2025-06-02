<?php

namespace Tests\Feature\AdminDetection;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class GuestCannotAccessAdminDetectionTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function guest_tidak_bisa_mengakses_halaman_detection_admin()
    {
        $response = $this->get(route('admin.detections.index'));

        // Karena belum login, seharusnya diarahkan ke halaman login
        $response->assertRedirect('/login');
    }
}
