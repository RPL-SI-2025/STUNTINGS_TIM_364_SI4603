<?php

namespace Tests\Feature\Orangtua;

use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TahapanPerkembanganOrangtuaAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_orangtua_can_access_perkembangan_index()
    {
        $orangtua = User::create([
            'nama_anak' => 'Rara',
            'nik_anak' => '1234567890123333',
            'password' => Hash::make('123456'),
            'role' => 'orangtua',
        ]);

        $response = $this->actingAs($orangtua)->get('/orangtua/tahapan_perkembangan');

        $response->assertStatus(200);
        $response->assertViewIs('orangtua.tahapan_perkembangan.index');
    }

}
