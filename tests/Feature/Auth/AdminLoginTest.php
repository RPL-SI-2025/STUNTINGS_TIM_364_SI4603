<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class AdminLoginTest extends TestCase
{

    public function test_admin_can_login_with_valid_credentials()
    {
        Artisan::call('db:seed', ['--class' => 'Database\\Seeders\\AdminSeeder']);

        $response = $this->post('/login', [
            'nik_anak' => '1234567890123456',
            'password' => 'admin123',
        ]);

        $response->assertRedirect('/admin/dashboard');
        $this->assertAuthenticated();
    }
}
