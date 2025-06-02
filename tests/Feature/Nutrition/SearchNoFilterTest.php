<?php

namespace Tests\Feature\Nutrition;

use Tests\TestCase;
use App\Models\User;

class SearchNoFilterTest extends TestCase
{
    public function test_search_without_filter_returns_empty()
    {
        $orangtua = User::create([
            'nama_anak' => 'Sinta',
            'nik_anak' => '1234567890123456',
            'role' => 'orangtua',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->actingAs($orangtua)->get('/nutrition/user');

        // Fokus hanya pada konten
        $response->assertDontSee('Nasi Goreng');
        $response->assertDontSee('Bubur Ayam');
    }
}
